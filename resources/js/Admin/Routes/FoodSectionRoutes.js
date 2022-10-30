import HomePage from '../Components/Pages/FoodSection/Home';

import AllPage from '../Components/Pages/FoodSection/All';
import CreatePage from '../Components/Pages/FoodSection/Create';
import ShowPage from '../Components/Pages/FoodSection/Show';
import EditPage from '../Components/Pages/FoodSection/Edit';


export default {
    path: 'food-section',
    component: HomePage,
    name: 'FoodSection',
    children: [
        { path: 'all', component: AllPage, name: 'FoodSection.All' },
        { path: 'create', component: CreatePage, name: 'FoodSection.Create' },
        { path: 'show/:id', component: ShowPage, name: 'FoodSection.Show' },
        { path: 'edit/:id', component: EditPage, name: 'FoodSection.Edit' },

    ]
};