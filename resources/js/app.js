import "./bootstrap";
import { createApp } from "vue";
import Home from "/resources/js/components/Home.vue";
import Login from "/resources/js/components/Login.vue";
import Register from "/resources/js/components/Register.vue";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import VueTheMask from 'vue-the-mask'
const app = createApp();

app.use(VueSweetalert2);

app.use(VueTheMask)
app.component("home", Home);
app.component("login", Login);
app.component("register", Register);

app.mount("#app");


