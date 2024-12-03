import { reactive, readonly, shallowRef, Ref } from 'vue';
import { get } from '@/api/base';
import { state, RemoteData, isLoaded } from '@/interfaces/RemoteData';
import { ConcordanceData } from '@/interfaces/ConcordanceData';
import { ConcordanceVerse } from '@/interfaces/ConcordanceVerse';

const data = shallowRef<RemoteData<ConcordanceData>>({ state: state.NotAsked });
const actual = shallowRef<RemoteData<ConcordanceVerse[]>>({ state: state.NotAsked });
const root = reactive(new Map<string, Ref<RemoteData<ConcordanceVerse[]>>>());
const base = reactive(new Map<string, Ref<RemoteData<ConcordanceVerse[]>>>());

function getConcordanceData(lang: string, sura: number, verse: number, word: number): void {
  get(`/api/data/language/${lang}/concordance/sura/${sura}/verse/${verse}/word/${word}`, data);
}

function getWordReferences(): void {
  actual.value = { state: state.NotAsked };
  if (isLoaded(data.value)) {
    const { analyses } = data.value.payload;
    const { word_cc } = analyses[0];
    get(`/api/data/concordance/references/word_cc/${word_cc}`, actual);
  }
}

function getReferences(type: 'base_cc' | 'root_cc'): void {
  if (type === 'base_cc') {
    base.clear();
  } else if (type === 'root_cc') {
    root.clear();
  }
  if (isLoaded(data.value)) {
    const { analyses } = data.value.payload;
    const words = analyses.map((a) => a[type]).filter((entry) => entry);
    // Is the no way to say that dict is also reactive?
    let dict: Map<string, Ref<RemoteData<ConcordanceVerse[]>>>;
    if (type === 'base_cc') {
      dict = base;
    } else {
      dict = root;
    }

    words.forEach((w) => {
      dict.set(
        w,
        shallowRef<RemoteData<ConcordanceVerse[]>>({ state: state.NotAsked }),
      );
    });
    dict.forEach((value, key) => {
      get(`/api/data/concordance/references/${type}/${key}`, value);
    });
  }
}

/**
 * Only export readonly variables.
 */
const concordanceData = readonly(data);
const wordRefs = readonly(actual);
const baseRefs = readonly(reactive(base));
const rootRefs = readonly(reactive(root));

export {
  concordanceData,
  getConcordanceData,
  getWordReferences,
  getReferences,
  wordRefs,
  baseRefs,
  rootRefs,
};
