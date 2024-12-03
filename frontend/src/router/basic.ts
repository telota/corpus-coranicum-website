/* eslint-disable @typescript-eslint/explicit-module-boundary-types */
import { RouteRecordRaw } from 'vue-router';
import FourOFour from '@/views/FourOFour.vue';
import RouterView from '@/views/RouterView.vue';
import ManuscriptSingle from '@/views/ManuscriptSingle.vue';
import ManuscriptPage from '@/views/ManuscriptPage.vue';
import aboutRoutes from '@/router/about';
import verseRoutes from '@/router/verses';
import commentaryRoutes from '@/router/commentary';

const IntertextsOverview = () => import('@/views/IntertextsOverview.vue');
const ManuscriptsOverview = () => import('@/views/ManuscriptsOverview.vue');
const InfoPage = () => import('@/views/InfoPage.vue');
const Start = () => import('@/views/Start.vue');

const routes: Array<RouteRecordRaw> = [
  {
    path: '',
    component: Start,
    name: 'HomePage',
  },
  {
    path: 'about',
    component: RouterView,
    name: 'About',
    children: aboutRoutes,
  },
  {
    path: 'contact',
    component: InfoPage,
    name: 'Contact',
  },
  {
    path: 'faq',
    component: InfoPage,
    name: 'FAQ',
  },
  {
    path: 'data-protection',
    component: InfoPage,
    name: 'DataProtection',
  },
  {
    path: 'imprint',
    component: InfoPage,
    name: 'Impressum',
  },
  {
    path: 'print',
    component: InfoPage,
    name: 'PrintEditionOverview',
  },
  {
    path: 'variants',
    component: InfoPage,
    name: 'VariantReadingsOverview',
  },
  {
    path: 'concordance',
    component: InfoPage,
    name: 'ConcordanceOverview',
  },
  {
    path: 'intertexts',
    component: IntertextsOverview,
    name: 'IntertextsOverview',
  },
  {
    path: 'manuscripts',
    component: ManuscriptsOverview,
    name: 'ManuscriptsOverview',
  },
  {
    path: 'manuscripts/:manuscript',
    component: ManuscriptSingle,
    name: 'ManuscriptSingle',
    children: [
      {
        path: 'page/:page',
        component: ManuscriptPage,
        name: 'ManuscriptPage',
      },
    ],
  },
  {
    path: 'commentary',
    component: RouterView,
    name: 'Commentary',
    children: commentaryRoutes,
  },
  {
    path: 'verse-navigator',
    component: RouterView,
    name: 'VerseNavigator',
    children: verseRoutes,
  },
  {
    path: ':catchAll(.+)',
    name: 'NotFound',
    component: FourOFour,
  },
];

export default routes;
