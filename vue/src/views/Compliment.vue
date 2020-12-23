<template>
  <div class="compliment-page">
    <h1 v-text="compliment.compliment" />
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive } from "vue";
import type { Compliment } from "@/models";
import { getCompliment } from "@/utils"
import { useRoute } from "vue-router";

export default defineComponent({
  props: ["compliment"],
  setup() {
    const $route = useRoute();
    const compliment = reactive<Partial<Compliment> & { loaded: boolean }>({ loaded: false });

    (async () => {
      const { id, compliment: _compliment } = await getCompliment($route.params.id as string);
      compliment.id = id;
      compliment.compliment = _compliment;
      compliment.loaded = true;
    })();

    return { compliment };
  }
});
</script>
