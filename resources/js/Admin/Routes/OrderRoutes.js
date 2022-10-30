import HomePage from '../Components/Pages/Order/Home';

import AllPage from '../Components/Pages/Order/All';
import ShowPage from '../Components/Pages/Order/Show';

import AllTrashPage from '../Components/Pages/Order/AllTrash';
import ShowTrashPage from '../Components/Pages/Order/ShowTrash';

export default {
    path: 'order',
    component: HomePage,
    name: 'Order',
    children: [
        { path: 'all', component: AllPage, name: 'Order.All' },
        { path: 'show/:id', component: ShowPage, name: 'Order.Show' },

        { path: 'all-trash', component: AllTrashPage, name: 'Order.AllTrash' },
        { path: 'trash-show/:id', component: ShowTrashPage, name: 'Order.ShowTrash' },
    ]
};