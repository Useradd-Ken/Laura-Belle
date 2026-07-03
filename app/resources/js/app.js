import { createApp } from "vue";
import AppWithNav from "./AppWithNav.vue";
import router from "./router/index.js";
import "../css/app.css";

const app = createApp(AppWithNav);

app.use(router);
app.mount("#app");
