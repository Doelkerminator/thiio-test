/**
 * main.ts
 *
 * Bootstraps Vuetify and other plugins then mounts the App`
 */

// Plugins
import { registerPlugins } from '@/plugins'

// Components
import App from './App.vue'

// Composables
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from './router';
import "./assets/css/index.css";

const pinia = createPinia();
const app = createApp(App)

registerPlugins(app)

app
    .use(pinia)
    .use(router)
    .mount('#app');
