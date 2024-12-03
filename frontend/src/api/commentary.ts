import { shallowRef } from 'vue';
import { isNotAsked, RemoteData, state } from '@/interfaces/RemoteData';
import { get } from '@/api/base';
import { Commentary } from '@/interfaces/Commentary';
import { CommentaryIntroduction } from '@/interfaces/CommentaryIntroduction';

const commentary = shallowRef<RemoteData<Commentary>>({
  state: state.NotAsked,
});
const available = shallowRef<RemoteData<number[]>>({
  state: state.NotAsked,
});
const intro = shallowRef<RemoteData<CommentaryIntroduction>>({
  state: state.NotAsked,
});

function getAvailable(): void {
  if (isNotAsked(available.value)) {
    get('/api/data/commentary/available', available);
  }
}

function getCommentary(sura: number): void {
  get(`/api/data/commentary/sura/${sura}`, commentary);
}

function getIntro(introName: string): void {
  get(`/api/data/commentary/introduction/${introName}`, intro);
}

export { commentary, getCommentary, available, getAvailable, intro, getIntro };
