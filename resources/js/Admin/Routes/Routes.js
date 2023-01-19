import Adminlayout from '../Adminlayout';
import Welcome from 'AdminViews/Welcome';

import SliderRoutes from './SliderRoutes';
import ProductCategoryRoutes from './ProductCategoryRoutes';
import ProductSubCategoryRoutes from './ProductSubCategoryRoutes';
import UserRoutes from './UserRoutes';
import StoreRoutes from './StoreRoutes';
import ProductItemRoutes from './ProductItemRoutes';
import SiteSettingRoutes from './SiteSettingRoutes';
import CouponRoutes from './CouponRoutes';
import FoodSectionRoutes from './FoodSectionRoutes';
import OrderRoutes from './OrderRoutes';
import ExtraCategoryRoutes from './ExtraCategoryRoutes';
import ExtraRoutes from './ExtraRoutes';
import SubscriptionRoutes from './SubscriptionRoutes';
import CountryRoutes from './CountryRoutes';
import GovernmentRoutes from './GovernmentRoutes';
import AddressRoutes from './AddressRoutes';
import CityRoutes from './CityRoutes';
import RoleRoutes from './RoleRoutes';

console.log('admin rout');

export default {
    path: '/dashboard/pages',
    component: Adminlayout,
    name: 'Adminlayout',
    children: [
        { path: '', component: Welcome },
        { path: 'welcome', component: Welcome, name: 'welcome' },

        SliderRoutes,
        ProductCategoryRoutes,
        ProductSubCategoryRoutes,
        UserRoutes,
        StoreRoutes,
        ProductItemRoutes,
        SiteSettingRoutes,
        CouponRoutes,
        FoodSectionRoutes,
        OrderRoutes,
        ExtraCategoryRoutes,
        ExtraRoutes,
        SubscriptionRoutes,
        CountryRoutes,
        GovernmentRoutes,
        AddressRoutes,
        CityRoutes,
        RoleRoutes
    ]
}