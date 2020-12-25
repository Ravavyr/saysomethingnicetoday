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
  padding: 0.5rem 2rem 0.5rem 0;
  font-size: 1.5rem;
  line-height: 1.6;
  text-decoration: none;
  $color: map-get($txt-colors, tertiary);
  color: $color;
  transition: 300ms ease;
  transition-delay: 150ms;
}
.compliments li:nth-child(1n) a:hover {
    transition: 200ms ease;
    color: map-get($txt-colors,green);
    transition-delay: 0;

}
.compliments li:nth-child(2n) a:hover {
    transition: 200ms ease;
    color: map-get($txt-colors,yellow);
    transition-delay: 0;

}
.compliments li:nth-child(3n) a:hover {
    transition: 200ms ease;
    color: map-get($txt-colors,blue);
    transition-delay: 0;

}
@media (max-width:1600px){
  .compliment-card {font-size:1.2rem; line-height:1.2;}
}
</style>
