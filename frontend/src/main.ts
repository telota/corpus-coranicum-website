import { createApp } from 'vue';
import { i18n } from '@/i18n';
import { createMetaManager } from 'vue-meta';
import VueMatomo from 'vue-matomo';
import App from './App.vue';
import router from './router';
import './style.css';

createApp(App)
  .use(i18n)
  .use(router)
  .use(createMetaManager())
  .use(VueMatomo, {
    host: 'https://piwik.bbaw.de',
    siteId: 2,
    router,
    requireConsent: false,
  })
  .mount('#app');
