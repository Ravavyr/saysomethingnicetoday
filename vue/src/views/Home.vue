<template>
  <main id="home-page">
    <header>
      <h1>Say Something Nice Today</h1>
    </header>
    <section class="content-wrapper">
      <div class="compliments">
        <h2>We'll tweet it to your friend anonymously from our account.</h2>
        <form @submit.prevent>
          <input
            type="search"
            v-model="searchQuery"
            placeholder="Find nice things to say..."
          />
        </form>
        <ol v-if="state.allCompliments">
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
      </div>
      <div class="thewhy">
        <figure class="y">
          <img src="@/assets/joyride.svg" alt="A Happy Announcement">
          <figcaption>Lift Someone Up High.</figcaption>
        </figure>
        <figure class="g">
          <img src="@/assets/happy_announcement.svg" alt="A Happy Announcement">
          <figcaption>Cheer on a Friend.</figcaption>
        </figure>
        <figure class="b">
          <img src="@/assets/intense_feeling.svg" alt="A Happy Announcement">
          <figcaption>Show someone some Love.</figcaption>
        </figure>
        <figure class="g">
          <img src="@/assets/i_can_fly.svg" alt="A Happy Announcement">
          <figcaption>Raise someone's Spirit.</figcaption>
        </figure>
        <figure class="b">
          <img src="@/assets/exciting_news.svg" alt="A Happy Announcement">
          <figcaption>Make someone's Day.</figcaption>
        </figure>
      </div>
    </section>
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

        compliments = compliments
          .map((a) => ({sort: Math.random(), value: a}))
          .sort((a, b) => a.sort - b.sort)
          .map((a) => a.value)
        return compliments;
        //return compliments.sort(function randomize(a, b) {return Math.random() - 0.5;});
        //return compliments;
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
      color: map-get($txt-colors, green);
    }
  }

  .content-wrapper{display:flex; flex-wrap:wrap; justify-content:space-between;}

  form input {
    font-family: inherit;
    background: map-get($bg-colors, primary);
    color: map-get($txt-colors, primary);
    outline: none;
    border: none;
    width: 25%;
    min-width:300px;
    font-size: 1.2rem;
    border-bottom: 1px solid map-get($txt-colors, secondary);
    padding-bottom: 0.4rem;

    &:focus {
      border-bottom-color: map-get($txt-colors, primary);
    }
    &::-webkit-search-cancel-button{
      appearance:none;
      width: 0;
      height: 0;
      border-bottom: 15px solid red;
      border-right: 15px solid transparent;
    }
  }


  .compliments {
    width: 65%;

    h2 {
      font-size: 1.6rem;
      font-weight: 500;
      color: #444;
      margin-top: 1rem;
      color: map-get($txt-colors, secondary);
    }

    ol{
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 0 2rem;
      list-style: none;
      margin: 0 !important;
      padding: 0 !important;
    }
  }
  .thewhy{
    width:35%;

    figure.g{ color:#6DFF63;}
    figure.y{color:#DCFF63;}
    figure.b{color:#63FFF5;}

    img{margin:0 0.5rem 0 0.5rem;}
    figcaption{display:block; padding:0.5rem; margin-bottom:3rem; font-weight:700; text-align:center; font-size:1.8rem;}

  }

}

@media (max-width:1600px){
  #home-page{
    .compliments ol{gap:0 1rem;}
  }
}
@media (max-width:1200px){
  #home-page{
    header h1{font-size:3.5rem;}
    .compliments h2{ font-size:1.2rem;}
    .thewhy figcaption{font-size:1.4rem;}
  }
}
@media (max-width:960px){
  #home-page{
    .compliments{width:50%;}
    .compliments ol{ grid-template-columns: repeat(1,1fr);}
    .thewhy{width:50%;}
    .thewhy figcaption{font-size:1.2rem;}
  }
}
@media (max-width:800px){
  #home-page{
    header h1{font-size:2.5rem;}
    .compliments h2{ font-size:1rem;}
  }
}
@media (max-width:680px){
  #home-page{
    .compliments{width:100%;}
    .compliments ol{width:100%; height:370px; border-bottom:2px dashed #444; padding-bottom:1rem; overflow:hidden; overflow-y:scroll;}
    .thewhy{width:100%; padding-top:2rem; display:flex; flex-wrap:wrap; justify-content:center; }
    .thewhy figure{width:calc(50% - 2rem); display:block; margin:1rem;}
    .thewhy figure img{margin:0;}
    .thewhy figcaption{font-size:1rem;}
  }
}
@media (max-width:460px){
  #home-page{
    header h1{font-size:1.8rem;}
    .thewhy figure{width:calc(100% - 2rem);}
  }
}
@media (max-width:400px){
  #home-page{
    header h1{font-size:1.4rem;}
  }
}
</style>
