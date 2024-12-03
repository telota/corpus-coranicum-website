import NavigationLink from '@/interfaces/NavigationLink';

const links = (t: (key: string) => string): NavigationLink[] => [
  {
    label: () => t('navigation.about'),
    to: { name: 'AboutTheProject' },
    active: ['AboutTheProject'],
  },
  {
    label: () => t('navigation.research'),
    to: { name: 'Research' },
    active: ['Research'],
  },
  {
    label: () => t('navigation.tools'),
    to: { name: 'Tools' },
    active: ['Tools'],
  },
  {
    label: () => t('navigation.materials'),
    to: { name: 'Sources' },
    active: ['Sources'],
  },
  {
    label: () => t('navigation.contributors'),
    to: { name: 'Contributors' },
    active: ['Contributors'],
  },
  {
    label: () => t('navigation.collegium_coranicum'),
    to: { name: 'Collegium' },
    active: ['Collegium'],
  },
  {
    label: () => t('navigation.events'),
    to: { name: 'Events' },
    active: ['Events'],
  },
];
export default links;
