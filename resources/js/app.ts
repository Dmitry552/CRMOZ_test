import './bootstrap';
import {createApp} from "vue";

import router from "./routes";
import {store, key} from './store';

import App from './components/App.vue';

const app = createApp(App)
    .use(store, key)
    .use(router)

app.mount('#app');
