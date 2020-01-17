const mix = require('laravel-mix');

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

mix.sass('resources/sass/metronic/style.scss', 'public/css/metronic.css')
    .sass('resources/sass/admin/app.scss', 'public/css/admin.css')
    .js('resources/js/admin/app.js', 'public/js/admin.js')
    .sass('resources/sass/seller/app.scss', 'public/css/seller.css')
    .js('resources/js/seller/app.js', 'public/js/seller.js')
    .version();
