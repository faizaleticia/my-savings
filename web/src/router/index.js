import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home/Home';
import Account from '../views/Account/Account';
import Login from '../views/Login/Login';
import Register from '../views/Register/Register';

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
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: {
      title: 'Login',
    }
  },
  {
    path: '/register',
    name: 'Registrr',
    component: Register,
    meta: {
      title: 'Registrar-se',
    }
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
});

export default router;
