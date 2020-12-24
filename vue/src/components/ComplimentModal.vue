<template>
  <div id="compliment-modal" ref="modal" aria-hidden="true">
    <div id="modal-content">
      <h1>Say Something Nice Today</h1>
      <h2>
        We will post a tweet that includes the nice thing to say that you have
        picked and mentions the given Twitter account.
      </h2>

      <form @submit.prevent="onSubmit">
        <label>
          Twitter Handle (without the @):
          <input
            id="twitter-handle"
            type="text"
            placeholder="SmthNiceToday"
            title="Friend's Twitter handle without the @"
            required
          />
        </label>
        <label>
          Nice Thing to Say:
          <span v-html="compliment.compliment" />
        </label>
        <nav>
          <router-link to="/">Cancel</router-link>
          <input type="submit" value="Send Nice Thing to Say" />
        </nav>
        <div
          id="response-message"
          v-if="responseMessage.error && responseMessage.message"
        >
          <span
            v-if="responseMessage.error === false"
            v-text="responseMessage.message"
          />
          <span class="error" v-text="responseMessage.message" />
        </div>
      </form>
    </div>
  </div>
</template>

<script lang="ts">
import type { Compliment } from "@/models";
import { defineComponent, computed, reactive } from "vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";

export default defineComponent({
  setup() {
    const store = useStore();
    const route = useRoute();
    const complimentId = route.params.id;
    const compliments = store.state.allCompliments as Compliment[];
    const compliment = compliments.filter(({ id }) => id === complimentId)[0] as Compliment;
    const responseMessage = reactive<any>({});
    async function onSubmit(e) {
      const username = e.target[0].value;
      const res = await fetch("/post.php", {
        method: "POST",
        body: JSON.stringify({
          username,
          compliment: complimentId,
        }),
      });
      if (res.status === 200) {
        responseMessage.error= false
        responseMessage.message = "Tweet message successfully created."
      } else {
        responseMessage.error = true;
        responseMessage.message= "Failed to submit the nice thing to say. Recheck your credentials and try again later.";
      }
    }
    return { compliment, onSubmit, responseMessage };
  },
  mounted() {
    // adds the transition for the page opacity
    const _this = this;
    setTimeout(() => (_this.$refs.modal as any).classList.add("showing"));
  },
});
</script>

<style lang="scss" scoped>
#compliment-modal {
  display: flex;
  align-items: center;
  justify-content: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100vh;
  background: rgba(map-get($bg-colors, primary), 0.75);
  opacity: 0;
  pointer-events: all;
  transition: opacity 300ms ease;

  &.showing {
    pointer-events: all;
    opacity: 1;
  }

  #modal-content {
    text-align: left;
    color: map-get($txt-colors, secondary);
    width: 45%;
    height: 70%;
    padding: 2rem;
    border-radius: 0.5rem;
    background: rgba(map-get($bg-colors, secondary), 0.99);

    h1 {
      margin: 0;
      margin-bottom: 1rem;
      font-size: 3rem;
      font-family: "Roboto Slab", sans-serif;
      color: map-get($txt-colors, primary);
    }

    h2 {
      font-size: 1.4rem;
      font-weight: 500;
      line-height: 1.5;
    }

    form {
      display: flex;
      flex-direction: column;

      label,
      input {
        font-family: inherit;
        color: inherit;
      }

      > input,
      > label {
        display: block;
        margin: 0.5rem 0;
      }

      nav {
        margin-top: 2rem;
        display: flex;

        input[type="submit"],
        a {
          padding: 0.5rem 1rem;
        }

        input[type="submit"] {
          cursor: pointer;
          color: map-get($bg-colors, primary);
        }

        a {
          text-decoration: none;
          color: map-get($txt-colors, primary);
        }
      }
    }

    #response-message {
      margin-top: 1rem;

      span {
        color: map-get($txt-colors, secondary);
        &.error {
          color: red;
        }
      }
    }
  }
}
</style>
