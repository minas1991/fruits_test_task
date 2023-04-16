import { createWebHistory, createRouter } from "vue-router";
import Fruits from '../components/Fruits';
import Favorites from '../components/Favorites';

const routes = [
    {
        name: 'Fruits',
        path: '/',
        component: Fruits
    },
    {
        name: 'Favorites',
        path: '/favorites',
        component: Favorites
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
});


export default router;