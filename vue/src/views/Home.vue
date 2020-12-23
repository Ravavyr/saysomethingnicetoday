<template>
  <main id="home-page">
    <div>
      <h1>Featured Compliment</h1>
      <router-link
        v-if="state.featured"
        :to="getComplimentPath(state.featured.id)"
      >
        <h3 v-text="state.featured.compliment" />
      </router-link>
    </div>
    <ol>
      <li v-for="{ id, compliment } in state.compliments" :key="id">
        <ComplimentCard :id="id" :compliment="compliment" />
      </li>
    </ol>
  </main>
</template>

<script lang="ts">
import { defineComponent, reactive } from "vue";
import { getRandomCompliment, getComplimentPath, getCompliments } from "@/utils";
import type { State } from "@/models";
import ComplimentCard from "@/components/ComplimentCard.vue";

export default defineComponent({
  name: "Home",
  components: { ComplimentCard },
  setup() {
    const state = reactive<State>({ loaded: false });

    async function loadCompliments() {
      const compliments = await getCompliments();
      const featured = await getRandomCompliment();
      state.compliments = compliments;
      state.featured = featured;
      state.loaded = true;
    }

    loadCompliments();

    return { state, getComplimentPath };
  },
});
</script>
