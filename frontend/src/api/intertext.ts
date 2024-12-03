import { readonly, shallowRef } from 'vue';
import { get } from '@/api/base';
import { RemoteData, state } from '@/interfaces/RemoteData';
import { IntertextSummary } from '@/interfaces/IntertextSummary';
import { IntertextDetail } from '@/interfaces/IntertextDetail';
import { Verse } from '@/interfaces/Verse';
import { IntertextShort } from '@/interfaces/IntertextShort';

const verseResults = shallowRef<RemoteData<IntertextSummary[]>>({ state: state.NotAsked });
const intertextDetail = shallowRef<RemoteData<IntertextDetail>>({ state: state.NotAsked });
const allIntertexts = shallowRef<RemoteData<IntertextShort[]>>({ state: state.NotAsked });

function getAllIntertexts(): void {
  get('/api/data/intertexts', allIntertexts);
}

function getIntertextResults(v: Verse): void {
  get(`/api/data/intertexts/sura/${v.sura}/verse/${v.verse}`, verseResults);
}

function getIntertextDetail(id: string): void {
  get(`/api/data/intertexts/${id}`, intertextDetail);
}

const intertextVerseResults = verseResults;

export {
  getAllIntertexts,
  getIntertextResults,
  getIntertextDetail,
  allIntertexts,
  intertextVerseResults,
  intertextDetail,
};
