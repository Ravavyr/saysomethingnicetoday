import Vuex from "vuex";
import type { Compliment } from "./models";

export interface State {
  allCompliments: Compliment[] | null;
}

export enum StoreActions {
  LoadCompliments = "loadCompliments",
}

export enum StoreGetters {
  GetRandomCompliment = "getRandomCompliment",
}

export const store = new Vuex.Store<State>({
  state: {
    allCompliments: null,
  },
  actions: {
    async [StoreActions.LoadCompliments](context) {
      const state = context.state;
      if (state.allCompliments === null) {
        const res = await fetch(`${window.location.origin}/compliments.json`);
        const data = await res.json();
        state.allCompliments = data;
      }
    },
  },
});
