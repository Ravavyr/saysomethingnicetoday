<template>
  <div id="compliment-modal" ref="modal" aria-hidden="true">
    <div id="modal-content">
      <h1>Say Something Nice Today</h1>
      <h2>
        We will post a tweet with the <span class="g">nice thing to say</span> that you have
        chosen and mention the given <span class="b">Twitter</span> account.
      </h2>

      <form @submit.prevent="onSubmit">
        <label>
          Twitter Handle (without the @):
          <input
            id="twitter-handle"
            type="text"
            placeholder="SmthNiceToday"
            pattern="[^@]*"
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
          <span class="error" v-text="responseMessage.message" />
        </div>
        <div
          id="response-message"
          v-if="responseMessage.success && responseMessage.message"
        >
          <span class="success">Tweet successfully created.</span>
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
      const res = await fetch("https://api.saysomethingnice.today/post", {
        method: "POST",
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: JSON.stringify({
          username:username,
          compliment: complimentId,
        }),
      });
      if (res.status === 200) {
        responseMessage.success= true;
        responseMessage.message = 'indeed';
      } else {
        responseMessage.error = true;
        responseMessage.message= "Failed to send, please only send once [for now, Twitter's API has limits] :).";
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
    height: auto;
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
    h2 .b{ color:map-get($txt-colors, blue);}
    h2 .g{ color:map-get($txt-colors, green);}

    form {
      display: flex;
      flex-direction: column;

      label,
      input {
        font-family: inherit;
        color: inherit;
        min-width:200px;
      }

      > input,
      > label {
        display: block;
        margin: 0.5rem 0;
      }
      input[type="text"]{color:map-get($txt-colors, yellow);}
      input[type="text"]::placeholder{color:map-get($txt-colors, yellow); opacity:0.7;}

      nav {
        margin-top: 2rem;
        display: flex;

        input[type="submit"],
        a {
          padding: 0.5rem 1rem;
        }

        input[type="submit"] {
          cursor: pointer;
          border:0;
          color: #1b1b1b;
          font-weight:700;
          background: map-get($txt-colors, blue);

          &:hover{background: map-get($txt-colors, green);}
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
        &.success {
          color: map-get($txt-colors, green);
        }
      }
    }
  }
}
@media (max-width:1400px){
  #compliment-modal{
    #modal-content{width:65%}

  }
}
@media (max-width:1200px){
  #compliment-modal{
    #modal-content h1{font-size:2.5rem;}

  }
}
@media (max-width:960px){
  #compliment-modal{
    #modal-content{width:80%}

  }
}
@media (max-width:1200px){
  #compliment-modal{
    #modal-content h1{font-size:1.8rem;}
    #modal-content h2{font-size:1.2rem;}
  }
}
@media (max-width:460px){
  #compliment-modal{
    #modal-content h1{font-size:1.4rem;}
    #modal-content h2{font-size:1rem;}
  }
}
@media (max-width:360px){
  #compliment-modal{
    #modal-content{padding:2rem 1rem; width:100%; border-radius:0;}
  }
}
</style>
