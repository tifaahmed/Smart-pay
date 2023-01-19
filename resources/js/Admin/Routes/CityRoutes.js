import HomePage from '../Components/Pages/City/Home';

import AllPage from '../Components/Pages/City/All';
import CreatePage from '../Components/Pages/City/Create';
import ShowPage from '../Components/Pages/City/Show';
import EditPage from '../Components/Pages/City/Edit';

import AllTrashPage from '../Components/Pages/City/AllTrash';
import ShowTrashPage from '../Components/Pages/City/ShowTrash';

export default {
    path: 'city',
    component: HomePage,
    name: 'City',
    children: [
        { path: 'all', component: AllPage, name: 'City.All' },
        { path: 'create', component: CreatePage, name: 'City.Create' },
        { path: 'show/:id', component: ShowPage, name: 'City.Show' },
        { path: 'edit/:id', component: EditPage, name: 'City.Edit' },

        { path: 'all-trash', component: AllTrashPage, name: 'City.AllTrash' },
        { path: 'trash-show/:id', component: ShowTrashPage, name: 'City.ShowTrash' },
    ]
};