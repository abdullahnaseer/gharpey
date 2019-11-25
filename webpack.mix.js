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

mix.js('resources/js/admin/app.js', 'public/js/admin.js');
mix.js('resources/js/seller/app.js', 'public/js/seller.js');
mix.js('resources/js/buyer/app.js', 'public/js/buyer.js');

mix.sass('resources/sass/app.scss', 'public/css');

mix.sass('resources/sass/limitless/layouts/layout_1/default/compile/bootstrap.scss', 'public/css/vendor');
mix.sass('resources/sass/limitless/layouts/layout_1/default/compile/bootstrap_limitless.scss', 'public/css/vendor');
mix.sass('resources/sass/limitless/layouts/layout_1/default/compile/components.scss', 'public/css/vendor');
mix.sass('resources/sass/limitless/layouts/layout_1/default/compile/layout.scss', 'public/css/vendor');
mix.sass('resources/sass/limitless/layouts/layout_1/default/compile/colors.scss', 'public/css/vendor');

mix.styles([
    'public/css/vendor/bootstrap.css',
    'public/css/vendor/bootstrap_limitless.css',
    'public/css/vendor/components.css',
    'public/css/vendor/layout.css',
    'public/css/vendor/colors.css',
    'resources/css/icons/icomoon/styles.css'
], 'public/css/admin.css');

mix.scripts([
    'resources/js/limitless/main/jquery.min.js',
    'resources/js/limitless/main/bootstrap.bundle.min.js',
    'resources/js/limitless/plugins/loaders/blockui.min.js',
    'resources/js/limitless/plugins/visualization/d3/d3.min.js',
    'resources/js/limitless/plugins/visualization/d3/d3_tooltip.js',
    'resources/js/limitless/plugins/forms/styling/switchery.min.js',
    'resources/js/limitless/plugins/forms/selects/bootstrap_multiselect.js',
    'resources/js/limitless/plugins/ui/moment/moment.min.js',
    'resources/js/limitless/plugins/pickers/daterangepicker.js',
    'resources/js/limitless/demo_pages/dashboard.js',
], 'public/js/limitless.js');

mix.styles([
    'public/css/vendor/bootstrap.css',
    'public/css/vendor/bootstrap_limitless.css',
    'public/css/vendor/components.css',
    'public/css/vendor/layout.css',
    'public/css/vendor/colors.css',
    'resources/css/icons/icomoon/styles.css'
], 'public/css/seller.css');


mix.copyDirectory('resources/images', 'public/img');

mix.copyDirectory([
    'resources/css/icons/fontawesome/fonts',
    'resources/css/icons/icomoon/fonts',
    'resources/css/icons/material/fonts',
    'resources/css/icons/summernote',
], 'public/fonts');

mix.copyDirectory([
    'resources/css/icons/fontawesome/fonts',
    'resources/css/icons/icomoon/fonts',
    'resources/css/icons/material/fonts',
    'resources/css/icons/summernote',
], 'public/css/fonts');
