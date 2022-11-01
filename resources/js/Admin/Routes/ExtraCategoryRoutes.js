import HomePage from '../Components/Pages/ExtraCategory/Home';

import AllPage from '../Components/Pages/ExtraCategory/All';
import CreatePage from '../Components/Pages/ExtraCategory/Create';
import ShowPage from '../Components/Pages/ExtraCategory/Show';
import EditPage from '../Components/Pages/ExtraCategory/Edit';

export default {
    path: 'extra-category',
    component: HomePage,
    name: 'ExtraCategory',
    children: [
        { path: 'all', component: AllPage, name: 'ExtraCategory.All' },
        { path: 'create', component: CreatePage, name: 'ExtraCategory.Create' },
        { path: 'show/:id', component: ShowPage, name: 'ExtraCategory.Show' },
        { path: 'edit/:id', component: EditPage, name: 'ProductSubCategory.Edit' },
    ]
};