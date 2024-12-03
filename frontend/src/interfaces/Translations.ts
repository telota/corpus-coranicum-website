import { IntertextLanguage } from './IntertextLanguage';

export type Translations = {
  [key in IntertextLanguage]: string;
};
