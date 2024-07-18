import "./bootstrap";
import { createApp } from "vue";
import Home from "/resources/js/components/Home.vue";

const app = createApp();


app.component("home", Home);

app.mount("#app");
