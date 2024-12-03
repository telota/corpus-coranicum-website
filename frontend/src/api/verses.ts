import { shallowRef } from 'vue';
import { get } from '@/api/base';
import { RemoteData, state } from '@/interfaces/RemoteData';
import { VerseRange } from '@/interfaces/VerseRange';
import { VerseTranslation } from '@/interfaces/VerseTranslaton';

const verseRange = shallowRef<RemoteData<VerseTranslation[]>>({ state: state.NotAsked });

function getVerses(lang: string, r: VerseRange): void {
  const url = `/api/data/language/${lang}/quran/verses/`
    + `start/${r.start.sura}/${r.start.verse}/`
    + `end/${r.end.sura}/${r.end.verse}`;
  get(url, verseRange);
}

// eslint-disable-next-line import/prefer-default-export
export { getVerses, verseRange };
