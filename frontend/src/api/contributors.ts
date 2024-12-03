import { shallowRef } from 'vue';
import { ContributorGroup } from '@/interfaces/ContributorGroup';
import { RemoteData, state } from '@/interfaces/RemoteData';

const contributors = shallowRef<RemoteData<ContributorGroup[]>>({
  state: state.NotAsked,
});

function toUrl(language: string): string {
  return `api/website/language/${language}/info/team`;
}

export { contributors, toUrl };
