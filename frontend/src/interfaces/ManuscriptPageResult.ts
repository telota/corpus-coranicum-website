import { MaybeImages } from './ImageNotAllowed';

export interface ManuscriptPageResult {
  id: number;
  folio: string;
  side: string;
  images: MaybeImages;
}
