import { createMemoryHistory, createRouter } from "vue-router";

import Login from "./components/Login.vue";

const routes = [
    {
        path:"/",
        component: Login
    }
]

export const router = createRouter({
    history: createMemoryHistory(),
    routes
})