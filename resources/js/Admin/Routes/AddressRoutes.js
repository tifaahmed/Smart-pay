import HomePage from '../Components/Pages/Address/Home';

import AllPage from '../Components/Pages/Address/All';
import CreatePage from '../Components/Pages/Address/Create';
import ShowPage from '../Components/Pages/Address/Show';
import EditPage from '../Components/Pages/Address/Edit';

export default {
    path: 'address',
    component: HomePage,
    name: 'Address',
    children: [
        { path: 'all', component: AllPage, name: 'Address.All' },
        { path: 'create', component: CreatePage, name: 'Address.Create' },
        { path: 'show/:id', component: ShowPage, name: 'Address.Show' },
        { path: 'edit/:id', component: EditPage, name: 'Address.Edit' },
    ]
};