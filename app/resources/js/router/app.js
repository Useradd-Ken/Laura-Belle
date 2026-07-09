import { createApp } from "vue";
import AppWithNav from "../vue/AppWithNav.vue";
import router from "./index.js";
import "../../css/app.css"

const app = createApp(AppWithNav);

app.use(router);
app.mount("#app");
