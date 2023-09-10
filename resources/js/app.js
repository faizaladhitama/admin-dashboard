import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

// Vuetify
import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

import { mdi } from 'vuetify/iconsets/mdi';
import { md } from 'vuetify/iconsets/md';
import { aliases, fa } from 'vuetify/iconsets/fa';

import {
    VDataTable,
    VDataTableServer,
    VDataTableVirtual,
} from "vuetify/labs/VDataTable";

import '@mdi/font/css/materialdesignicons.css';
import 'material-design-icons-iconfont/dist/material-design-icons.css';
import '@fortawesome/fontawesome-free/css/all.css';


// Quasar
import { Quasar } from 'quasar'
import quasarLang from 'quasar/lang/id'

// Import icon libraries
import '@quasar/extras/roboto-font-latin-ext/roboto-font-latin-ext.css'
import '@quasar/extras/material-icons/material-icons.css'

// Import Quasar css
import 'quasar/dist/quasar.css'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const vuetify = createVuetify({
            components: {
                ...components,
                VDataTable,
                VDataTableServer,
                VDataTableVirtual,
            },
            directives,
            icons: {
                defaultSet: 'fa',
                aliases,
                sets: {
                    fa,
                    mdi,
                    md
                },
            },
        })
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(vuetify)
            .use(ZiggyVue)
            .use(Quasar, {
                plugins: {}, // import Quasar plugins and add here
                lang: quasarLang,
                /*
                config: {
                  brand: {
                    // primary: '#e46262',
                    // ... or all other brand colors
                  },
                  notify: {...}, // default set of options for Notify Quasar plugin
                  loading: {...}, // default set of options for Loading Quasar plugin
                  loadingBar: { ... }, // settings for LoadingBar Quasar plugin
                  // ..and many more (check Installation card on each Quasar component/directive/plugin)
                }
                */
            })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
