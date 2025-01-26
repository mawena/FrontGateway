import { createApp } from 'vue'
import App from '@/App.vue'
import { registerPlugins } from '@core/utils/plugins'
import VueMask from '@devindex/vue-mask';
// Styles
import '@core-scss/template/index.scss'
import '@styles/styles.scss'


// Create vue app
const app = createApp(App)


// Register plugins
registerPlugins(app)
app.use(VueMask);

// Mount vue app
app.mount('#app')
