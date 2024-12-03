import { ManuscriptImage } from './ManuscriptImage';

export type ImageNotAllowed = 'NOT_ALLOWED';

export type MaybeImages = ManuscriptImage[] | ImageNotAllowed;

export function isImages(maybe: MaybeImages): maybe is ManuscriptImage[] {
  return typeof maybe !== 'string';
}
