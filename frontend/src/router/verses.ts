/* eslint-disable @typescript-eslint/explicit-module-boundary-types */
import { RouteRecordRaw } from 'vue-router';

const PrintEdition = () => import('@/views/PrintEdition.vue');
const CommentarySingle = () => import('@/views/CommentarySingle.vue');
const Concordance = () => import('@/views/Concordance.vue');
const IntertextResults = () => import('@/views/IntertextResults.vue');
const IntertextSingle = () => import('@/views/IntertextSingle.vue');
const Intertexts = () => import('@/views/Intertexts.vue');
const ManuscriptResults = () => import('@/views/ManuscriptResults.vue');
const Variants = () => import('@/views/Variants.vue');

const routes: Array<RouteRecordRaw> = [
  {
    path: '',
    redirect: {
      name: 'VersePrint',
      params: {
        sura: 1,
        verse: 1,
      },
    },
  },
  {
    path: 'sura/:sura/verse/:verse/intertexts',
    component: Intertexts,
    children: [
      {
        path: '',
        component: IntertextResults,
        name: 'VerseIntertextResults',
      },

      {
        path: ':id',
        component: IntertextSingle,
        name: 'VerseIntertextDetail',
      },
    ],
  },
  {
    path: 'sura/:sura/verse/:verse/print',
    component: PrintEdition,
    name: 'VersePrint',
  },
  {
    path: 'sura/:sura/verse/:verse/manuscripts',
    component: ManuscriptResults,
    name: 'VerseManuscriptResults',
  },
  {
    path: 'sura/:sura/verse/:verse/variants',
    component: Variants,
    name: 'VerseVariants',
  },
  {
    path: 'sura/:sura/verse/:verse/concordance/word/:word',
    component: Concordance,
    name: 'VerseConcordance',
  },
  {
    path: 'sura/:sura/verse/:verse/commentary',
    component: CommentarySingle,
    name: 'VerseCommentary',
  },
];

export default routes;
