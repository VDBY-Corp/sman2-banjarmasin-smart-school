import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";
import fg from "fast-glob";

const getPagesJs = () => {
    const pages = fg.sync("resources/js/pages/*.js");

    // return array of page
    return pages
};

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                ...getPagesJs(),
            ],
            refresh: true,
        }),
    ],
});
