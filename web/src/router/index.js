import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home/Home';
import Account from '../views/Account/Account';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: {
      title: 'Página inicial',
    }
  },
  {
    path: '/accounts',
    name: 'Contas',
    component: Account,
    meta: { 
      title: 'Contas',
    },
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
});

export default router;
