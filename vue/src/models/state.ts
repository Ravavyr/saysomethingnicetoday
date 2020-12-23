import type { Compliment } from "./compliment";

export interface State {
  compliments?: Compliment[];
  featured?: Compliment;
  loaded: boolean;
}
