import NavigationLink from '@/interfaces/NavigationLink';
import topicLinks from '@/components/header/topic_links';
import aboutLinks from '@/components/header/about_links';
import aboutRoutes from '@/router/about';
import { RouteLocationNormalizedLoaded } from 'vue-router';
import { WritableComputedRef } from 'vue';

const links = (
  t: (key: string) => string,
  route: RouteLocationNormalizedLoaded,
  locale: WritableComputedRef<string>,
): NavigationLink[] => [
  {
    label: () => t('navigation.home'),
    to: {
      name: 'HomePage',
      params: { lang: locale.value },
    },
    active: ['HomePage'],
  },
  {
    label: () => t('navigation.about'),
    to: undefined,
    active: aboutRoutes.map((r) => (r.name ? r.name.toString() : '')),
    children: aboutLinks(t),
  },
  {
    label: () => t('navigation.topics'),
    to: undefined,
    active: ['ManuscriptsOverview', 'VariantReadingsOverview', 'IntertextsOverview'],
    children: topicLinks(t),
  },
  {
    label: () => t('navigation.verse_navigation'),
    to: {
      name: 'VersePrint',
      params: {
        lang: locale.value,
        sura: route.query.sura ? +route.query.sura : 1,
        verse: route.query.verse ? +route.query.verse : 1,
      },
    },
    active: [
      'VersePrint',
      'VerseIntertextResults',
      'VerseIntertextDetail',
      'VerseVariants',
      'VerseManuscriptResults',
      'VerseCommentary',
      'VerseConcordance',
    ],
  },
];

export default links;
