import HomePage from '../Components/Pages/Coupon/Home';

import AllPage from '../Components/Pages/Coupon/All';
import CreatePage from '../Components/Pages/Coupon/Create';
import ShowPage from '../Components/Pages/Coupon/Show';
import EditPage from '../Components/Pages/Coupon/Edit';


export default {
    path: 'coupon',
    component: HomePage,
    name: 'Coupon',
    children: [
        { path: 'all', component: AllPage, name: 'Coupon.All' },
        { path: 'create', component: CreatePage, name: 'Coupon.Create' },
        { path: 'show/:id', component: ShowPage, name: 'Coupon.Show' },
        { path: 'edit/:id', component: EditPage, name: 'Coupon.Edit' },

    ]
};