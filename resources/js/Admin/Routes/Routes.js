import Adminlayout from '../Adminlayout';
import Welcome from 'AdminViews/Welcome';

import SliderRoutes from './SliderRoutes';
import ProductCategoryRoutes from './ProductCategoryRoutes';
import ProductSubCategoryRoutes from './ProductSubCategoryRoutes';


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
    ]
}