import { VariantsReader } from './VariantsReader';
import { VariantsWork } from './VariantsWork';

export interface VariantsCanonical {
  work: VariantsWork;
  readers: VariantsReader[];
}
