
let mix = require('laravel-mix')


// Voyager
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
mix
    .js('resources/assets/js/app.js', 'publishes/assets/js')

// mix.options({ processCssUrls: false }).sass('resources/assets/sass/app.scss', 'publishable/assets/css', { implementation: require('node-sass') })
// .js('resources/assets/js/app.js', 'publishable/assets/js')
// .copy('node_modules/tinymce/skins', 'publishable/assets/js/skins')
// .copy('resources/assets/js/skins', 'publishable/assets/js/skins')
// .copy('node_modules/tinymce/themes/modern', 'publishable/assets/js/themes/modern')
// .copy('node_modules/ace-builds/src-noconflict', 'publishable/assets/js/ace/libs');

// //require('laravel-elixir-vue-2');

// /*
//  |--------------------------------------------------------------------------
//  | Mix Asset Management
//  |--------------------------------------------------------------------------
//  |
//  | Mix provides a clean, fluent API for defining some Webpack build steps
//  | for your Laravel application. By default, we are compiling the Sass
//  | file for the application as well as bundling up all the JS files.
//  |
//  */

// mix.js(
//     [
//         // 'resources/assets/js/jquery-3.2.1.min.js',
//         // 'resources/assets/js/jquery-migrate-3.0.0.js',
//         'resources/assets/bootstrap/js/bootstrap.min.js',
//         'resources/assets/js/jquery.appear.js',
//         'resources/assets/owlcarousel/js/owl.carousel.min.js',
//         'resources/assets/js/jquery.mixitup.js',
//         // 'resources/assets/js/jquery.magnific-popup.min.js',
//         'resources/assets/js/jquery.stellar.min.js',
//         'resources/assets/js/jquery.mb.YTPlayer.min.js',
//         'resources/assets/js/jquery.waypoints.min.js',
//         'resources/assets/js/jquery.counterup.min.js',
//         'resources/assets/js/wow.min.js',
//         'resources/assets/js/form-contact.js',
//         'resources/assets/js/components/loadFast.js',
//         'resources/assets/js/scripts.js'
//     ]
//     , 'public/js/app.js'
// ).sourceMaps();

// // mix.sass('resources/assets/sass/app.scss', 'public/css')
// //     .options({
// //         processCssUrls: false
// //     });

// mix.styles(
//     [
//         'resources/assets/bootstrap/css/bootstrap.min.css',
//         'resources/assets/fonts/linear-fonts.css',
//         'resources/assets/owlcarousel/css/owl.carousel.css',
//         'resources/assets/owlcarousel/css/owl.theme.css',
//         'resources/assets/css/magnific-popup.css',
//         'resources/assets/css/animate.min.css',
//         'resources/assets/css/style.css',
//         'resources/assets/css/responsive.css'
//     ], 'public/css/app.css'
// );
// //     .options({
// //         processCssUrls: false
// // });

// if (mix.config.inProduction) {
//     mix.version();
// }

// mix.copyDirectory('resources/assets/images', 'public/images');