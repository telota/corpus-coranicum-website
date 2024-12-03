import { ManuscriptShort } from './ManuscriptShort';

export interface ArchiveDetail {
  id: number;
  city: string;
  country_code: string;
  name: string;
  link: string;
  image: string;
  image_description: string;
  image_link: string;
  description: string;
  manuscripts: ManuscriptShort[];
}
