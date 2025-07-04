import { createRouter, createWebHistory } from "vue-router";
import Categories from "./Pages/Categories/Index.vue";
import Brands from "./components/Brands/index.vue";
import Products from "./components/Products/index.vue";
// Import các component tương ứng với các route
const routes = [
    {
        path: "/categories",
        component: Categories,
    },
    {
        path: "/brands",
        component: Brands,
    },
    {
        path: "/products",
        component: Products,
    },
    // Thêm các route khác nếu cần
];
const router = createRouter({
    history: createWebHistory(),
    routes,
});
export default router;