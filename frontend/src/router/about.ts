import { RouteRecordRaw } from 'vue-router';
import InfoPage from '@/views/InfoPage.vue';
import Events from '@/views/Events.vue';
import Contributors from '@/views/Contributors.vue';

const routes: Array<RouteRecordRaw> = [
  {
    path: '',
    component: InfoPage,
    name: 'AboutTheProject',
  },
  {
    path: 'collegiumcoranicum',
    component: Events,
    name: 'Collegium',
  },
  {
    path: 'research',
    component: InfoPage,
    name: 'Research',
  },
  {
    path: 'tools',
    component: InfoPage,
    name: 'Tools',
  },
  {
    path: 'sources',
    component: InfoPage,
    name: 'Sources',
  },
  {
    path: 'team',
    component: Contributors,
    name: 'Contributors',
  },
  {
    path: 'events',
    component: Events,
    name: 'Events',
  },
];
export default routes;
