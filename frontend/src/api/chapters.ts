import { shallowRef, readonly } from 'vue';
import { get } from '@/api/base';
import { Chapter } from '@/interfaces/Chapter';
import { isNotAsked, RemoteData, state } from '@/interfaces/RemoteData';

const chaptersModifable = shallowRef<RemoteData<Chapter[]>>({ state: state.NotAsked });

function getChapters(): void {
  if (isNotAsked(chaptersModifable.value)) {
    get('/api/init/quran', chaptersModifable);
  }
}

const chapters = readonly(chaptersModifable);

export { getChapters, chapters };
