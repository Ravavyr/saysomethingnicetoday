<template>
  <router-link :to="`/compliments/${compliment.id}`" class="compliment-card">
    <span v-html="compliment.compliment" />
  </router-link>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import type { Compliment } from "@/models";

export default defineComponent({
  name: "ComplimentCard",
  props: {
    id: {
      type: String,
      required: true
    },
    compliment: {
      type: String,
      required: true
    },
  },
  setup(compliment: Compliment) {
    return { compliment };
  }
});
</script>

<style lang="scss">
.compliment-card {
  display: flex;
  align-items: center;
  width: 100%;
  height: 100%;
  padding: 1rem 0;
  padding-right: 2rem;
  font-size: 1.5rem;
  line-height: 1.6;
  text-decoration: none;
  $color: map-get($txt-colors, tertiary);
  color: $color;
  transition: 300ms ease;
  transition-delay: 150ms;

  &:hover {
    transition: 300ms ease;
    color: lighten($color, 25%);
    transition-delay: 0;
  }
}
</style>
