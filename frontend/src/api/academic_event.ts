import { AcademicEvent } from '@/interfaces/AcademicEvent';
import { RemoteData, state } from '@/interfaces/RemoteData';
import { shallowRef } from 'vue';
import { get } from './base';

const events = shallowRef<RemoteData<AcademicEvent[]>>({ state: state.NotAsked });

function getCollegium(): void {
  get('api/website/collegium-coranicum', events);
}

function getEvents(): void {
  get('api/website/events', events);
}

export {
  events, getCollegium, getEvents,
};
