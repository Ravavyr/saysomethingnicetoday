<template>
  <main id="home-page">
    <header>
      <h1>Say Something Nice Today</h1>
      <h2>We'll tweet it to your friend anonymously from our account.</h2>
    </header>
    <form @submit.prevent>
      <input
        type="search"
        v-model="searchQuery"
        placeholder="Find nice things to say..."
      />
    </form>
    <ol v-if="state.allCompliments" class="compliments">
      <li
        v-for="{ id, compliment } in filterCompliments(
          state.allCompliments,
          searchQuery
        )"
        :key="id"
      >
        <ComplimentCard :id="id" :compliment="compliment" />
      </li>
    </ol>
    <router-view />
  </main>
</template>

<script lang="ts">
import type { State } from "@/store";
import type { Store } from "vuex";
import type { Compliment } from "@/models";
import { computed, defineComponent, ref } from "vue";
import ComplimentCard from "@/components/ComplimentCard.vue";
import { useStore } from "vuex";
import { StoreActions } from "@/store";
import FuzzySearch from "fuzzy-search";

export default defineComponent({
  name: "Home",
  components: { ComplimentCard },
  setup() {
    const store = useStore() as Store<State>;
    const state = computed<State>(() => store.state);
    const searchQuery = ref("");

    function filterCompliments(compliments: Compliment[], _query: string) {
      const query = _query.trim();
      if (query) {
        return new FuzzySearch(compliments, ["compliment"]).search(query) as Compliment[];
      } else {
        return compliments;
      }
    }

    return { state, searchQuery, filterCompliments };
  },
});
</script>

<style lang="scss" scoped>
#home-page {
  width: 100%;

  header {
    h1 {
      font-family: "Roboto Slab";
      font-size: 5.5rem;
      font-weight: 500;
      margin-top: 1rem;
      margin-bottom: 0;
      color: map-get($txt-colors, primary);
    }

    h2 {
      font-size: 1.6rem;
      font-weight: 500;
      color: #444;
      margin-top: 1rem;
      color: map-get($txt-colors, secondary);
    }
  }

  form input {
    font-family: inherit;
    background: map-get($bg-colors, primary);
    color: map-get($txt-colors, primary);
    outline: none;
    border: none;
    width: 25%;
    font-size: 1.2rem;
    border-bottom: 1px solid map-get($txt-colors, secondary);
    padding-bottom: 0.4rem;

    &:focus {
      border-bottom-color: map-get($txt-colors, primary);
    }
  }

  .compliments {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0 4rem;
    list-style: none;
    margin: 0 !important;
    padding: 0 !important;
  }
}
</style>
