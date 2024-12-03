import { shallowRef, readonly } from 'vue';
import { isNotAsked, RemoteData, state } from '@/interfaces/RemoteData';
import { get } from '@/api/base';
import { PrintEditionData } from '@/interfaces/PrintEditionData';
import { PrintEditionWeb } from '@/interfaces/PrintEditionWeb';
import { PrintEditionPage } from '@/interfaces/PrintEditionPage';

const printEditionData = shallowRef<RemoteData<PrintEditionData>>({ state: state.NotAsked });

const printEditionWeb = shallowRef<RemoteData<PrintEditionWeb>>({ state: state.NotAsked });

const cairoPages = shallowRef<RemoteData<PrintEditionPage[]>>({ state: state.NotAsked });

function getPrintWeb(lang: string): void {
  get(`/api/website/language/${lang}/print-edition`, printEditionWeb);
}

function getPrintData(lang: string, sura: number, verse: number): void {
  get(`/api/data/language/${lang}/print-edition/sura/${sura}/verse/${verse}`, printEditionData);
}

function getCairoPages(): void {
  if (isNotAsked(cairoPages.value)) {
    get('/api/data/cairo-pages', cairoPages);
  }
}

const printData = readonly(printEditionData);

export { getPrintWeb, getPrintData, printData, cairoPages, getCairoPages };
