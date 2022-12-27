import HomePage from '../Components/Pages/Country/Home';

import AllPage from '../Components/Pages/Country/All';
import CreatePage from '../Components/Pages/Country/Create';
import ShowPage from '../Components/Pages/Country/Show';
import EditPage from '../Components/Pages/Country/Edit';

import AllTrashPage from '../Components/Pages/Country/AllTrash';
import ShowTrashPage from '../Components/Pages/Country/ShowTrash';

export default {
    path: 'country',
    component: HomePage,
    name: 'Country',
    children: [
        { path: 'all', component: AllPage, name: 'Country.All' },
        { path: 'create', component: CreatePage, name: 'Country.Create' },
        { path: 'show/:id', component: ShowPage, name: 'Country.Show' },
        { path: 'edit/:id', component: EditPage, name: 'Country.Edit' },

        { path: 'all-trash', component: AllTrashPage, name: 'Country.AllTrash' },
        { path: 'trash-show/:id', component: ShowTrashPage, name: 'Country.ShowTrash' },
    ]
};