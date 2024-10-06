import "./bootstrap";
import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import axios from "axios";
import App from "./components/App.vue";
import ProductList from "./components/ProductList.vue";
import CreateProduct from "./components/CreateProduct.vue";
import EditProduct from "./components/EditProduct.vue";
import Login from "./components/Login.vue";
import Register from "./components/Register.vue";
import Sidebar from "./components/Sidebar.vue";

const routes = [
    {
        path: "/",
        name: "products",
        component: ProductList,
        meta: { requiresAuth: true },
    },
    {
        path: "/product/create",
        name: "create",
        component: CreateProduct,
        meta: { requiresAuth: true },
    },
    {
        path: "/products/:id/edit",
        name: "edit",
        component: EditProduct,
        meta: { requiresAuth: true },
    },
    { path: "/login", name: "login", component: Login },
    { path: "/register", name: "register", component: Register },
    {
        path: "/videos",
        name: "videos",
        component: () => import("./components/VideoPlayer.vue"),
        meta: { requiresAuth: true },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    if (to.meta.requiresAuth) {
        try {
            const response = await axios.get("/auth-check", {
                withCredentials: true,
            });

            if (response.data.message === "User is authenticated") {
                next();
            } else {
                next({ name: "login" });
            }
        } catch (error) {
            next({ name: "login" });
        }
    } else {
        next();
    }
});

const app = createApp(App);
app.component("Sidebar", Sidebar);
app.use(router);
app.mount("#app");
