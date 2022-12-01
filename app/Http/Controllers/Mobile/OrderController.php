<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response ;
use Illuminate\Support\Str;
use Auth;

// Resource
use App\Http\Resources\Mobile\Collections\OrderCollection as ModelCollection;
use App\Http\Resources\Mobile\Order\OrderResource as ModelResource;

// lInterfaces
use App\Repository\OrderRepositoryInterface ;
use App\Repository\OrderInformationRepositoryInterface ;
use App\Repository\OrderItemRepositoryInterface  ;
use App\Repository\OrderItemExtraRepositoryInterface  ;
use App\Repository\OrderStoreRepositoryInterface;
use App\Repository\CouponRepositoryInterface;
use App\Repository\CartRepositoryInterface;

// Requests
use App\Http\Requests\Api\Mobile\Order\OrderStoreApiRequest as modelInsertRequest;
// use App\Http\Requests\Api\Mobile\Order\OrderUpdateApiRequest as modelUpdateRequest;


class OrderController extends Controller
{
    private $Repository;
    private $OrderInformationRepository;
    private $OrderItemRepository;
    private $OrderItemExtraRepository;
    private $OrderStoreRepository;
    private $CouponRepository;
    private $CartRepository;
    
    public function __construct(
        OrderRepositoryInterface $OrderRepository,
        OrderInformationRepositoryInterface $OrderInformationRepository,
        OrderStoreRepositoryInterface $OrderStoreRepository,
        OrderItemRepositoryInterface $OrderItemRepository,
        OrderItemExtraRepositoryInterface $OrderItemExtraRepository,

        CouponRepositoryInterface $CouponRepository,
        CartRepositoryInterface $CartRepository
    )
    {
        $this->OrderRepository = $OrderRepository;
        $this->OrderInformationRepository = $OrderInformationRepository;
        $this->OrderItemRepository = $OrderItemRepository;
        $this->OrderItemExtraRepository = $OrderItemExtraRepository;
        $this->OrderStoreRepository = $OrderStoreRepository;
        $this->CouponRepository = $CouponRepository;
        $this->CartRepository = $CartRepository;
        $this->default_per_page = 10;
    }
    
    public function all(Request $request){
        try {
            $modal =    $this->OrderRepository->all()    ;
            return new ModelCollection($modal);
        } catch (\Exception $e) {
            return $this -> MakeResponseErrors(  
                [$e->getMessage()  ] ,
                'Errors',
                Response::HTTP_NOT_FOUND
            );
        }
    }
    
    public function collection(Request $request){
        try {
            $modal = $this->OrderRepository->collection( $request->per_page ?? $this->default_per_page);
            return new ModelCollection($modal);
        } catch (\Exception $e) {
            return $this -> MakeResponseErrors(  
                [$e->getMessage()  ] ,
                'Errors',
                Response::HTTP_NOT_FOUND
            );
        }
    }




    public function store(modelInsertRequest $request) {
        $carts = Auth::user()->carts;
        $request_payment_type = $request->payment_type;
        $request_coupon_code = $request->coupon_code;
        $site_fee =  $this->get_site_fee();
        try {
            //  get all related stores
            $store_models = $this->get_store_models($carts);

            //////1 create order_model  //////
                // sent payment_type
                //store basec data without calculate  the prices
                $order_model = $this->OrderRepository->custome_create($request_payment_type,$site_fee);
            //////1  create order_model //////


            foreach ($store_models as $key => $store_model) {
                // sent coupon_code & store_id
                // get coupon_model to record the Order Stor data    
                $coupon_model = $this->get_store_coupon($store_model->id,$request_coupon_code);

                //////2  udate coupon_model //////
                    $coupon_model 
                    ? 
                    $this->CouponRepository->update($coupon_model->id,['usage_counter'=>$coupon_model->usage_counter -1]) 
                    :
                    null;
                //////2  create coupon_model //////

                //////3  order_store_model //////
                    // sent order_id (parent), store_model(get info) , coupon_model(get info)
                    //store data without calculate  the prices
                    $order_store_model = $this->OrderStoreRepository->custome_create(
                            $order_model->id,
                            $store_model,
                            $coupon_model
                        );
                //////3  order_store_model //////

                // order_items create
                foreach ($carts as  $cart) {
                    // sent store_id product_id
                    // get product_item_model if related to sore  to record the Order Item data                    
                    $cart = $cart->store_id == $store_model->id ? $cart : null;

                    if ($cart) {
                        //////4  OrderItem //////
                            // sent store_id(parent),product_model(get info),quantity of every product
                            //store data without calculate  the prices
                            $order_item_model = $this->OrderItemRepository->custome_create(
                                        $order_store_model->id,
                                        $cart
                                    );
                        //////4  OrderItem //////
                        // create order_item_extras

                        foreach ($cart->cart_extras as  $cart_extra) {
                            //////5  OrderItemExtra //////

                                // sent order_item_id , extra_model 
                                //store data with prices
                                $this->OrderItemExtraRepository->custome_create($order_item_model->id,$cart_extra);
                            //////5  OrderItemExtra //////
                        }
                        //////4  OrderItem //////
                            $product_price_after_offer = $this->get_calculated_cart_product_price(
                                    $cart->product_price,
                                    $cart->product_discount,
                                );
                            $order_item_extra_sub_totals = $this->get_calculated_order_item_extra_sub_totals(
                                    $order_item_model
                                );
                            $sub_total = $this->get_calculated_order_item_sub_total (
                                    $product_price_after_offer,
                                    $cart->quantity,
                                    $order_item_extra_sub_totals
                                );
                            $this->OrderItemRepository->update($order_item_model->id , [
                                'order_item_extra_sub_totals'=>$order_item_extra_sub_totals, // collect sub_total of table order_item_extras
                                'sub_total'=> $sub_total // (product_price after offer  * quantity ) + order_item_extra_sub_totals
                            ]);
                        //////4  OrderItem //////
                    }    
                }
                //////3  OrderStore //////
                    $order_item_sub_totals = $this->get_order_item_sub_totals(
                            $order_store_model
                        );
                    $discount_number = 
                        $coupon_model  ? 
                            $this->get_calculated_discount_number(
                                $coupon_model->discount,
                                $coupon_model->type,
                                $coupon_model->percent_limit,
                                $order_item_sub_totals
                            ) 
                        : 0  ;
                    $sub_total  =    $this->get_calculated_store_sub_total(
                                $discount_number ,
                                $order_item_sub_totals ,
                                $order_store_model->delevery_fee 
                            );
                    $this->OrderStoreRepository->update($order_store_model->id ,[
                        'order_item_sub_totals'=>$order_item_sub_totals , 
                        'coupon_discount'=>$discount_number ,
                        'sub_total'=>  $sub_total
                    ]);

                //////3  OrderStore //////

            }
            //////1  order //////
                $order_store_sub_totals = $this->get_calculated_order_store_sub_totals(
                                                $order_model
                                            ) ;
                $total = $this->get_calculated_order_total(
                            $order_model
                        ) ;
                $this->OrderRepository->update($order_model->id,[
                    'order_store_sub_totals'=>  $order_store_sub_totals,
                    'total'=>   $total
                ]);
            //////1  order //////

            //////5  OrderInformation //////
                // sent address_id
                // get address_modal to record the OrderInformation  data                    
                $address_modal = $this->get_order_address($request->address_id);

                // sent $order_id,$address_modal
                $order_information_model = $this->OrderInformationRepository->custome_create($order_model->id,$address_modal);
            //////5  OrderInformation //////

            //////6  delete the cart //////
                Auth::user()->carts()->delete();
            //////6  delete the cart //////


            return $this -> MakeResponseSuccessful( 
                [ new ModelResource ( $order_model ) ],
                'Successful'               ,
                Response::HTTP_OK
            ) ;

        } catch (\Exception $e) {
            $order_model->delete();
             return $this -> MakeResponseErrors(  
                 [$e->getMessage()  ] ,
                 'Errors',
                 Response::HTTP_BAD_REQUEST
             );
        }
    }

    public function show($id) {
        try {
            $model = $this->OrderRepository->findById($id);
            return $this -> MakeResponseSuccessful( 
                [ new ModelResource ( $model ) ],
                'Successful',
                Response::HTTP_OK
            ) ;
        } catch (\Exception $e) {
            return $this -> MakeResponseErrors(  
                [$e->getMessage()  ] ,
                'Errors',
                Response::HTTP_NOT_FOUND
            );
        }
    }



}

