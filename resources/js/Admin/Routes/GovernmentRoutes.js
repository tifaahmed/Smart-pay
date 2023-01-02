import HomePage from '../Components/Pages/Government/Home';

import AllPage from '../Components/Pages/Government/All';
import CreatePage from '../Components/Pages/Government/Create';
import ShowPage from '../Components/Pages/Government/Show';
import EditPage from '../Components/Pages/Government/Edit';

import AllTrashPage from '../Components/Pages/Government/AllTrash';
import ShowTrashPage from '../Components/Pages/Government/ShowTrash';

export default {
    path: 'government',
    component: HomePage,
    name: 'Government',
    children: [
        { path: 'all', component: AllPage, name: 'Government.All' },
        { path: 'create', component: CreatePage, name: 'Government.Create' },
        { path: 'show/:id', component: ShowPage, name: 'Government.Show' },
        { path: 'edit/:id', component: EditPage, name: 'Government.Edit' },

        { path: 'all-trash', component: AllTrashPage, name: 'Government.AllTrash' },
        { path: 'trash-show/:id', component: ShowTrashPage, name: 'Government.ShowTrash' },
    ]
};