import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import { store } from "./store";
import "./scss/global.scss";
import VueGtag from 'vue-gtag';


createApp(App)
  .use(router)
  .use(store)
  .use(VueGtag, { config: { id: 'G-YK8VECEJ74' } })
  .mount("#app");

