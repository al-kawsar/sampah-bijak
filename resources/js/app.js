import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { ZiggyVue } from "ziggy-js";
import { Link, Head } from "@inertiajs/vue3";
import Antd, { message } from "ant-design-vue";
import "ant-design-vue/dist/reset.css";

createInertiaApp({
    progress: {
        delay: 250,
        color: "#29d",
        includeCSS: true,
        showSpinner: true,
    },
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({
            render: () => h(App, props),
        });

        app.use(plugin);
        app.use(ZiggyVue);
        app.use(Antd);
        app.component("Link", Link);
        app.component("Head", Head);
        app.mount(el);

    },
});
