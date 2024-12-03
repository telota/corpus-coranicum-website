import { createRouter, createWebHistory, RouteRecordRaw, RouterScrollBehavior } from 'vue-router';
import FourOFour from '@/views/FourOFour.vue';
import basicRoutes from '@/router/basic';

const Home = () => import('@/views/Home.vue');

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    redirect: '/de',
  },
  {
    path: '/:lang(de|en|fr)',
    component: Home,
    name: 'Home',
    children: basicRoutes,
  },
  {
    path: '/:catchAll(.*)*',
    name: 'LanguageNotFound',
    component: FourOFour,
  },
  // {
  //   path: '/about',
  //   name: 'About',
  //   // route level code-splitting
  //   // this generates a separate chunk (about.[hash].js) for this route
  //   // which is lazy-loaded when the route is visited.
  //   component: () => import(/* webpackChunkName: "about" */ '../views/About.vue'),
  // },
];

const scrollBehavior: RouterScrollBehavior = (to, from, savedPosition) => {
  if (to.hash) {
    return { el: to.hash };
  }
  return { top: 0 };
};

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
  scrollBehavior,
});

export default router;
