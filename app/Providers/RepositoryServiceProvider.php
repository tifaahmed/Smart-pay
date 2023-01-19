<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repository\Eloquent\BaseRepository;use App\Repository\EloquentRepositoryInterface;
use App\Repository\Eloquent\SliderRepository;use App\Repository\SliderRepositoryInterface;
use App\Repository\Eloquent\ProductCategoryRepository;use App\Repository\ProductCategoryRepositoryInterface;
use App\Repository\Eloquent\ProductItemRepository;use App\Repository\ProductItemRepositoryInterface;
use App\Repository\Eloquent\StoreRepository;use App\Repository\StoreRepositoryInterface;
use App\Repository\Eloquent\UserRepository;use App\Repository\UserRepositoryInterface;
use App\Repository\Eloquent\SiteSettingRepository;use App\Repository\SiteSettingRepositoryInterface;
use App\Repository\Eloquent\CountryRepository;use App\Repository\CountryRepositoryInterface;
use App\Repository\Eloquent\GovernmentRepository;use App\Repository\GovernmentRepositoryInterface;
use App\Repository\Eloquent\CityRepository;use App\Repository\CityRepositoryInterface;
use App\Repository\Eloquent\ExtraCategoryRepository;use App\Repository\ExtraCategoryRepositoryInterface;
use App\Repository\Eloquent\ExtraRepository;use App\Repository\ExtraRepositoryInterface;
use App\Repository\Eloquent\CouponRepository;use App\Repository\CouponRepositoryInterface;
use App\Repository\Eloquent\OrderRepository;use App\Repository\OrderRepositoryInterface;
use App\Repository\Eloquent\AddressRepository;use App\Repository\AddressRepositoryInterface;
use App\Repository\Eloquent\OrderItemRepository;use App\Repository\OrderItemRepositoryInterface;
use App\Repository\Eloquent\OrderInformationRepository;use App\Repository\OrderInformationRepositoryInterface;
use App\Repository\Eloquent\OrderItemExtraRepository;use App\Repository\OrderItemExtraRepositoryInterface;
use App\Repository\Eloquent\OrderStoreRepository;use App\Repository\OrderStoreRepositoryInterface;
use App\Repository\Eloquent\FoodSectionRepository;use App\Repository\FoodSectionRepositoryInterface;
use App\Repository\Eloquent\CartRepository;use App\Repository\CartRepositoryInterface;
use App\Repository\Eloquent\CartExrtraRepository;use App\Repository\CartExrtraRepositoryInterface;
use App\Repository\Eloquent\SubscriptionRepository;use App\Repository\SubscriptionRepositoryInterface;
use App\Repository\Eloquent\RoleRepository;use App\Repository\RoleRepositoryInterface;
use App\Repository\Eloquent\PermissionRepository;use App\Repository\PermissionRepositoryInterface;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class,BaseRepository::class);
        $this->app->bind(SliderRepositoryInterface::class,SliderRepository::class);

        $this->app->bind(ProductCategoryRepositoryInterface::class,ProductCategoryRepository::class);
        $this->app->bind(ProductItemRepositoryInterface::class,ProductItemRepository::class);

        $this->app->bind(StoreRepositoryInterface::class,StoreRepository::class);
        $this->app->bind(UserRepositoryInterface::class,UserRepository::class);
        $this->app->bind(AddressRepositoryInterface::class,AddressRepository::class);

        $this->app->bind(SiteSettingRepositoryInterface::class,SiteSettingRepository::class);

        $this->app->bind(CountryRepositoryInterface::class,CountryRepository::class);
        $this->app->bind(GovernmentRepositoryInterface::class,GovernmentRepository::class);
        $this->app->bind(CityRepositoryInterface::class,CityRepository::class);

        $this->app->bind(ExtraCategoryRepositoryInterface::class,ExtraCategoryRepository::class);
        $this->app->bind(ExtraRepositoryInterface::class,ExtraRepository::class);

        $this->app->bind(CouponRepositoryInterface::class,CouponRepository::class);
        $this->app->bind(OrderRepositoryInterface::class,OrderRepository::class);
        $this->app->bind(OrderItemRepositoryInterface::class,OrderItemRepository::class);
        $this->app->bind(OrderInformationRepositoryInterface::class,OrderInformationRepository::class);
        $this->app->bind(OrderItemExtraRepositoryInterface::class,OrderItemExtraRepository::class);
        $this->app->bind(OrderStoreRepositoryInterface::class,OrderStoreRepository::class);
        $this->app->bind(FoodSectionRepositoryInterface::class,FoodSectionRepository::class);
        $this->app->bind(CartRepositoryInterface::class,CartRepository::class);
        $this->app->bind(CartExrtraRepositoryInterface::class,CartExrtraRepository::class);
        $this->app->bind(SubscriptionRepositoryInterface::class,SubscriptionRepository::class);
        $this->app->bind(RoleRepositoryInterface::class,RoleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class,PermissionRepository::class);
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
