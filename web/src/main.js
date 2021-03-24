import { createApp } from 'vue';
import App from './App.vue';
import moment from 'moment';
import router from './router';
import { FontAwesomeIcon } from "@/plugins/font-awesome";

createApp(App)
    .use(router)
    .use(moment)
    .component("fa", FontAwesomeIcon)
    .mount('#app');
