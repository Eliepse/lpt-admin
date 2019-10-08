const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass("resources/sass/app.scss", "public/css")
    .js("resources/js/app.js", "public/js")
    .extract(["vue", "v-calendar", "list.js", "dayjs", "axios", "bootstrap", "popper.js", "jquery", "lodash"]);


if (mix.inProduction()) {
    mix.version()
        .copyDirectory("resources/images", "public/images");
}

if (!mix.inProduction()) {
    mix.sourceMaps();
}

mix.webpackConfig({
    stats: {
        //excludeAssets: /vendor/
    }
});
