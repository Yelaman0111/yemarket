require("./bootstrap");

import { createApp } from "vue";
import router from "./router/index";

import IndexVue from "./components/IndexVue";
import AppHeader from "./components/AppHeader";

createApp({
    components: {
        IndexVue,
        AppHeader,
    },
})
    .use(router)
    .mount("#app");
