<template>
  <router-link :to="getComplimentPath(compliment.id)">
    {{ compliment.compliment }}
  </router-link>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import type { Compliment } from "@/models";
import { getComplimentPath } from "@/utils";

export default defineComponent({
  name: "ComplimentCard",
  props: {
    id: String,
    compliment: String
  },
  setup(props) {
    const compliment = props as Compliment;
    return { compliment, getComplimentPath };
  }
});
</script>
