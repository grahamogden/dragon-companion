import "./bootstrap";
import "../css/app.css";

import { createApp, h, DefineComponent } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import { createPinia } from "pinia";
import FontAwesomeIcon from "./plugins/font-awesome.ts";
import BaseLayout from "./Layouts/BaseLayout.vue";
import CreatorDashboardLayout from "./Layouts/CreatorDashboardLayout.vue";
import SimpleContainerLayout from "./Layouts/SimpleContainerLayout.vue";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name) => {
        const page = await resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>("./Pages/**/*.vue")
        );

        if (!page.default.layout || !page.default.layout.length) {
            page.default.layout = name.startsWith("Creator/")
                ? [BaseLayout, CreatorDashboardLayout]
                : [BaseLayout, SimpleContainerLayout];
        }

        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(createPinia())
            .component("font-awesome-icon", FontAwesomeIcon)
            .mixin({
                methods: { route },
            })
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
