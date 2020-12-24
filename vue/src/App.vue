<template>
  <router-view />
</template>

<script lang="ts">
import { defineComponent, computed } from "vue";
import { useStore } from "vuex";
import { StoreActions } from "@/store";

export default defineComponent({
  setup() {
    const store = useStore();
    store.dispatch(StoreActions.LoadCompliments);
  },
});
</script>

<style lang="scss">
html {
  font-family: "Inter", sans-serif;
}

body {
  margin: 0;
}

#app {
  padding: 1rem 5rem;
  background: map-get($bg-colors, primary);
  min-height: 100vh;
  padding-bottom: 4rem;
}
</style>
