import { ref } from 'vue';
import { RemoteData, state } from '@/interfaces/RemoteData';
import { InfoItem } from '@/interfaces/InfoItem';

const info = ref<RemoteData<InfoItem[]>>({ state: state.NotAsked });

function toInfoUrl(address: string, language: string): string {
  return `/api/website/language/${language}/info/${address}`;
}

export { info, toInfoUrl };
