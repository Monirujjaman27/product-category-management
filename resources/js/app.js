import "./bootstrap";
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js', { scope: '/' }).then(function (registration) {
        console.log(`SW registered successfully!`);
    }).catch(function (registrationError) {
        console.log(`SW registration failed`);
    });
}
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
