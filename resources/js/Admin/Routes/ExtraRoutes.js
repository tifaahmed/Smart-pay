import HomePage from '../Components/Pages/Extra/Home';

import AllPage from '../Components/Pages/Extra/All';
import CreatePage from '../Components/Pages/Extra/Create';
import ShowPage from '../Components/Pages/Extra/Show';
import EditPage from '../Components/Pages/Extra/Edit';

export default {
    path: 'extra',
    component: HomePage,
    name: 'Extra',
    children: [
        { path: 'all', component: AllPage, name: 'Extra.All' },
        { path: 'create', component: CreatePage, name: 'Extra.Create' },
        { path: 'show/:id', component: ShowPage, name: 'Extra.Show' },
        { path: 'edit/:id', component: EditPage, name: 'Extra.Edit' },
    ]
};