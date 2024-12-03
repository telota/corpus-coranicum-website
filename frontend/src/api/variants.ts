import { readonly, shallowRef } from 'vue';
import { get } from '@/api/base';
import { isLoaded, RemoteData, state } from '@/interfaces/RemoteData';
import { Verse } from '@/interfaces/Verse';
import { VariantsVerse } from '@/interfaces/VariantsVerse';
import { VariantsCanonical } from '@/interfaces/VariantsCanonical';

const variantResults = shallowRef<RemoteData<VariantsVerse>>({ state: state.NotAsked });
const canonical = shallowRef<RemoteData<VariantsCanonical>>({ state: state.NotAsked });
const word = shallowRef<number | undefined>(undefined);

function getVariants(v: Verse): void {
  get(`/api/data/variants/sura/${v.sura}/verse/${v.verse}`, variantResults);
}

function getCanonical(): void {
  if (!isLoaded(canonical.value)) {
    get('/api/data/variants/canonical', canonical);
  }
}

function setSelectedWord(w: number | undefined): void {
  if (w === word.value) {
    word.value = undefined;
  } else {
    word.value = w;
  }
}

const selectedWord = readonly(word);

export { variantResults, getVariants, canonical, getCanonical, selectedWord, setSelectedWord };
