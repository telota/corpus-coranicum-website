import { RouteLocationNormalizedLoaded } from 'vue-router';
import { ConcordanceAnalyis } from '@/interfaces/ConcordanceAnalysis';

enum WordType {
  Word = 'word_cc',
  Base = 'base_cc',
  Root = 'root_cc'
}

function makeWordLabel(
  t: (key: string, any) => string,
  route: RouteLocationNormalizedLoaded,
  w: WordType,
  a: ConcordanceAnalyis,
): string {
  switch (w) {
    case WordType.Word:
      return t('concordance.word_cc', {
        word: a.word,
        sura: route.params.sura,
        verse: route.params.verse,
      });
    default:
      return w.toString();
  }
}

export { WordType, makeWordLabel };
