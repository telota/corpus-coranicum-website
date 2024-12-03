import NavigationLink from '@/interfaces/NavigationLink';

const links = (t: (key: string) => string): NavigationLink[] => [
  {
    label: () => t('navigation.print_edition'),
    to: { name: 'PrintEditionOverview' },
    active: ['PrintEditionOverview'],
  },
  {
    label: () => t('navigation.manuscripts'),
    to: { name: 'ManuscriptsOverview' },
    active: ['ManuscriptsOverview'],
  },
  {
    label: () => t('navigation.variant_readings'),
    to: { name: 'VariantReadingsOverview' },
    active: ['VariantReadingsOverview'],
  },
  {
    label: () => t('navigation.intertexts'),
    to: { name: 'IntertextsOverview' },
    active: ['IntertextsOverview'],
  },
  {
    label: () => t('navigation.commentary'),
    to: { name: 'CommentaryOverview' },
    active: ['Commentary'],
  },
  {
    label: () => t('navigation.concordance'),
    to: { name: 'ConcordanceOverview' },
    active: ['ConcordanceOverview'],
  },
];
export default links;
