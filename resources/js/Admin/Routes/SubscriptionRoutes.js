import HomePage from '../Components/Pages/Subscription/Home';

import AllPage from '../Components/Pages/Subscription/All';
import CreatePage from '../Components/Pages/Subscription/Create';
import ShowPage from '../Components/Pages/Subscription/Show';
import EditPage from '../Components/Pages/Subscription/Edit';


export default {
    path: 'subscription',
    component: HomePage,
    name: 'Subscription',
    children: [
        { path: 'all', component: AllPage, name: 'Subscription.All' },
        { path: 'create', component: CreatePage, name: 'Subscription.Create' },
        { path: 'show/:id', component: ShowPage, name: 'Subscription.Show' },
        { path: 'edit/:id', component: EditPage, name: 'Subscription.Edit' },

    ]
};