import { createWebHistory, createRouter } from "vue-router";

import Login from "./components/Login.vue";
import Dashboard from "./components/Dashboard.vue";
import { useSessionStore } from './stores/SessionStore';
import axios from "axios";
import { server } from "./config";
import Layout from "./components/Layout.vue";
import LoginLayout from "./components/LoginLayout.vue";
import SignUp from "./components/SignUp.vue";
import Edit from "./components/Edit.vue";
import Admin from "./components/Admin.vue";

const routes = [
    {
        path:"/auth",
        component: LoginLayout,
        children: [
            {
                path: 'login',
                name: 'Login',
                component: Login,
            },
            {
                path: 'signup',
                name: 'Signup',
                component: SignUp
            }
        ]
    },
    {
        path: "/",
        component: Layout,
        children: [
            {
                path: '',
                name: 'Dashboard',
                component: Dashboard
            },
            {
                path: 'edit',
                name: 'Edit',
                component: Edit
            },
            {
                path: 'admin',
                name: 'Admin',
                component: Admin
            }
        ]
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach(async(to,from) => {
    const session = useSessionStore();
    if(to.name != 'Login' && to.name != 'Signup') {
        try {
            const response = await axios.get(`${server}/api/session`, {
                headers: {
                    jwt: session.getJwt
                }
            })
    
            if(response.status === 200) {
                session.setUser(response.data.user);
            }
            else {
                return {name: 'Login'};
            }
        }
        catch(error) {
            return {name: 'Login'};
        }
    } 
});

export default router;