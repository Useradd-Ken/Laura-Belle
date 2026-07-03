import { createApp } from "vue";
import Login from "./Login.vue";
import Accounting from "./Accounting.vue";
import JournalEntry from "./JournalEntry.vue";
import GeneralLedger from "./GenLedger.vue";
import "../css/app.css";

const el = document.getElementById("app");

if (el) {
    switch (el.dataset.page) {
        case "login":
            createApp(Login).mount("#app");
            break;
        case "accounting":
            createApp(Accounting).mount("#app");
            break;
        case "general-ledger":
            createApp(GeneralLedger).mount("#app");
            break;
        case "journal-entry":
            createApp(JournalEntry).mount("#app");
            break;
    }
}
