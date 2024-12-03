import { VariantsReader } from './VariantsReader';
import { VariantsWork } from './VariantsWork';
import { html } from './Html';

export interface VariantsReading {
  reading_id: number;
  readers: VariantsReader[];
  reading_commentary: null | html;
  variants: {
    [key: number]: string;
  };
  work: VariantsWork;
}
