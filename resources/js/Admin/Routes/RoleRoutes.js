import HomePage from '../Components/Pages/Role/Home';

import AllPage from '../Components/Pages/Role/All';
import CreatePage from '../Components/Pages/Role/Create';
import ShowPage from '../Components/Pages/Role/Show';
import EditPage from '../Components/Pages/Role/Edit';

export default {
    path: 'role',
    component: HomePage,
    name: 'Role',
    children: [
        { path: 'all', component: AllPage, name: 'Role.All' },
        { path: 'create', component: CreatePage, name: 'Role.Create' },
        { path: 'show/:id', component: ShowPage, name: 'Role.Show' },
        { path: 'edit/:id', component: EditPage, name: 'Role.Edit' },
    ]
};