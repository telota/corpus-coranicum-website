import NavigationLink from '@/interfaces/NavigationLink';

function verseLinks(t: (key: string) => string): NavigationLink[] {
  return [
    {
      label: () => t('navigation.print_edition'),
      to: { name: 'VersePrint' },
      active: ['VersePrint'],
    },
    {
      label: () => t('navigation.manuscripts'),
      to: { name: 'VerseManuscriptResults' },
      active: ['VerseManuscriptResults'],
    },
    {
      label: () => t('navigation.variant_readings'),
      to: { name: 'VerseVariants' },
      active: ['VerseVariants'],
    },
    {
      label: () => t('navigation.intertexts'),
      to: { name: 'VerseIntertextResults' },
      active: ['VerseIntertextResults', 'VerseIntertextDetail'],
    },
    {
      label: () => t('navigation.commentary'),
      to: { name: 'VerseCommentary' },
      active: ['VerseCommentary'],
    },
    {
      label: () => t('navigation.concordance'),
      to: {
        name: 'VerseConcordance',
        params: { word: 1 },
      },
      active: ['VerseConcordance'],
    },
  ];
}

// eslint-disable-next-line import/prefer-default-export
export { verseLinks };
