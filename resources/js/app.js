import "./bootstrap";
import { createApp } from "vue";
import App from "./App.vue";
import router from "./router"; // Import Vue Router
import { createPinia } from "pinia";
const pinia = createPinia();

// Create Vue application
const app = createApp(App);

// Use Vue Router
app.use(router);
app.use(pinia);

// Mount the Vue app
app.mount("#app");
