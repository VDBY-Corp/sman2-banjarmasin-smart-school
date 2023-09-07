import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";
import glob from "glob";

const getPagesJs = () => {
    const pages = glob.sync("resources/js/pages/*.js");

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
