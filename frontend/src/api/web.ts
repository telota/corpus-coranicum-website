import { Ref, ref } from 'vue';
import { RouteLocationNormalizedLoaded } from 'vue-router';
import routeParamToString from '@/router/param_as_string';
import { getAndGetOnNewLanguage } from '@/api/base';
import { RemoteData, state } from '@/interfaces/RemoteData';
import { IntertextWeb } from '@/interfaces/IntertextWeb';
import { PrintEditionWeb } from '@/interfaces/PrintEditionWeb';
import { ConcordanceWeb } from '@/interfaces/ConcordanceWeb';
import { CommentaryWeb } from '@/interfaces/CommentaryWeb';
import { VariantsWeb } from '@/interfaces/VariantsWeb';
import { ManuscriptWeb } from '@/interfaces/ManuscriptWeb';

const concordanceWeb = ref<RemoteData<ConcordanceWeb>>({ state: state.NotAsked });
const commentaryWeb = ref<RemoteData<CommentaryWeb>>({ state: state.NotAsked });
const intertextWeb = ref<RemoteData<IntertextWeb>>({ state: state.NotAsked });
const printWeb = ref<RemoteData<PrintEditionWeb>>({ state: state.NotAsked });
const variantsWeb = ref<RemoteData<VariantsWeb>>({ state: state.NotAsked });
const manuscriptWeb = ref<RemoteData<ManuscriptWeb>>({ state: state.NotAsked });

function toUrl(address: string, lang: string): string {
  return `/api/website/language/${lang}/${address}`;
}

function webWatcher<W>(
  route: RouteLocationNormalizedLoaded,
  address: string,
  getter: Ref<RemoteData<W>>,
): void {
  const url = toUrl(address, routeParamToString(route.params.lang));
  getAndGetOnNewLanguage(url, getter, route);
}

export {
  webWatcher, printWeb, concordanceWeb, commentaryWeb,
  intertextWeb, manuscriptWeb, variantsWeb,
};
