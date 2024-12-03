import { shallowRef } from 'vue';
import { RemoteData, state } from '@/interfaces/RemoteData';
import { get } from '@/api/base';
import { Verse } from '@/interfaces/Verse';
import { ManuscriptSummary } from '@/interfaces/ManuscriptSummary';
import { ManuscriptDetail } from '@/interfaces/ManuscriptDetail';
import { ManuscriptPageDetail } from '@/interfaces/ManuscriptPageDetail';
import { ArchiveDetail } from '@/interfaces/ArchiveDetail';

// eslint-disable-next-line max-len
const manuscriptVerseResults = shallowRef<RemoteData<ManuscriptSummary[]>>({ state: state.NotAsked });
const manuscriptDetail = shallowRef<RemoteData<ManuscriptDetail>>({ state: state.NotAsked });
const pageDetail = shallowRef<RemoteData<ManuscriptPageDetail>>({ state: state.NotAsked });
const archives = shallowRef<RemoteData<ArchiveDetail[]>>({ state: state.NotAsked });

function getManuscriptVerseresults(v: Verse): void {
  get(`/api/data/manuscripts/sura/${v.sura}/verse/${v.verse}`, manuscriptVerseResults);
}

function getManuscriptDetail(id: number): void {
  get(`/api/data/manuscripts/${id}`, manuscriptDetail);
}

function getPageDetail(lang: string, manuscriptId: number, pageId: string): void {
  get(`/api/data/language/${lang}/manuscripts/${manuscriptId}/pages/${pageId}`, pageDetail);
}

function getArchives(lang: string): void {
  get(`/api/data/language/${lang}/manuscripts/archives`, archives);
}

export {
  manuscriptVerseResults,
  getManuscriptVerseresults,
  manuscriptDetail,
  getManuscriptDetail,
  pageDetail,
  getPageDetail,
  archives,
  getArchives,
};
