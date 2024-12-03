/* eslint-disable @typescript-eslint/explicit-module-boundary-types */
import { RouteRecordRaw } from 'vue-router';

const CommentaryOverview = () => import('@/views/CommentaryOverview.vue');
const CommentaryIntroduction = () => import('@/views/CommentaryIntroduction.vue');

const routes: Array<RouteRecordRaw> = [
  {
    path: '',
    component: CommentaryOverview,
    name: 'CommentaryOverview',
  },
  {
    path: 'introduction/:intro',
    component: CommentaryIntroduction,
    name: 'CommentaryIntroduction',
  },
];
export default routes;
