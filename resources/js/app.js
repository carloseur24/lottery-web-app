import "./bootstrap";
import { createApp } from "vue";
import Nav from "../../resources/js/components/nav.vue";

const app = createApp();
app.component("nav", Nav);

app.mount("#app");
