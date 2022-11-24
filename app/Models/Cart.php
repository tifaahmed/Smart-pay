<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Auth ;
use App\Models\User;              // belongsTo
use App\Models\ProductItem;       // belongsTo
use App\Models\Store;       // belongsTo

use App\Models\CartExtra;         // HasMany

class Cart extends Model
{
    use HasFactory ;
    protected $table = 'carts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',  // integer , onDelete('cascade')

        'store_id', //integer , will not delete if product deleted

        'product_id', //integer , will not delete if product deleted
        'product_title', //string , nullable  
        'product_discount', //float , default(0) , 10%,5%,15%,20% product offer  
        'product_price', //float , default(1) , single product pure price
        'quantity' 
    ];

    // get
        // calculate single product discount
        // return integer
        public function getProductPriceAfterOfferAttribute (): int{
            $result = - (  $this->product_price * ($this->product_discount/100)  ) + $this->product_price ;
            $result = ( $result > 0 )? $result :   0;
            return $result;
        }
        // calculate (single product price after discount x quantity)+( extras_price x quantity)
        // return integer
        public function getProductPriceSubTotalAttribute (): int{
            $cart_product_price =  $this->product_price_after_offer * $this->quantity ;
            $cart_product_extras_price = $this->cart_extras->sum('extra_price') * $this->quantity ;
            $result = $cart_product_price + $cart_product_extras_price;
            return $result;
        }
        public function getProductImageAttribute (): string{
            return $cart_product_price =  check_image($this->product_item->image) ;
        }
        
    //scope
        public function scopeRelateAuthUser($query){
            return $query->where('user_id',Auth::user()->id);
        }
    // belongsTo
        public function user(){
            return $this->belongsTo(User::class,'user_id');
        }
        public function product_item(){
            return $this->belongsTo(ProductItem::class,'product_id');
        }
        public function store(){
            return $this->belongsTo(Store::class,'store_id');
        }
    // HasMany
        public function cart_extras(){
            return $this->HasMany(CartExtra::class,'cart_id');
        }    
}
