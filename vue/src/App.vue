<template>
  <router-view />
</template>

<script lang="ts">
import { computed, defineComponent } from 'vue';
import { useStore } from 'vuex';
import { StoreActions } from '@/store';

export default defineComponent({
  setup() {
    const store = useStore();
    store.dispatch(StoreActions.LoadCompliments);
  },
});
</script>

<style>
html {
  font-family: "Inter", sans-serif;
}

body {
  margin: 0;
}

#app {
  padding: 1rem 5rem;
  background: var(--bg-colors-primary);
  min-height: 100vh;
  padding-bottom: 4rem;
}
@media (max-width:1600px){
  #app{padding:1rem 1rem;}
}
</style>
