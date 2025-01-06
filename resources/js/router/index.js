import { createRouter, createWebHistory } from "vue-router";
import Categories from "../Pages/category/index.vue";
import Product from "../Pages/product/index.vue";
import Home from "../Pages/Home.vue";
import NotFound from "../Pages/NotFound.vue";
// Import your components

const routes = [
    { path: "/", component: Home, name: "home" },
    { path: "/categories", component: Categories, name: "categories" },
    { path: "/products", component: Product, name: "product" },
    { path: "/:pathMatch(.*)*", component: NotFound, name: "notfound" },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
