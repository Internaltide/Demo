let mix = require('laravel-mix');
let ghdownload = require('github-download');
let fs = require('fs');

/*
 |--------------------------------------------------------------------------
 | Github Package Management
 |--------------------------------------------------------------------------
 | Some useful and great github package doesn't provide way of npm install yet.
 | So we must download and manage them by our self.
 |
 */
// Require github package list
let list = [
    'github_modules/bootstrapFormHelpers : github.com/vlamanna/BootstrapFormHelpers.git'
];

// Begin download
list.forEach(function(item, index, array){
    let temp = item.split(' : ');
    fs.exists(temp[0], function(exists){
        if( !exists ){
            console.log('\n'+'Downloading '+temp[0]+' ...\n');
            ghdownload('git://'+temp[1], temp[0]);
        } else {
            console.log('\n'+temp[0]+' already exists!!\n');
        }
    });
});

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

/**
 * Global
 */
// core js & css
mix.scripts(['resources/assets/js/smartTools.js'], 'public/js/smartTools.js');
mix.js('resources/assets/js/app.js', 'public/js').sass('resources/assets/sass/app.scss', 'public/css');

// fonts file
mix.copyDirectory('node_modules/font-awesome/fonts', 'public/fonts');

// app favicon
mix.copy('resources/assets/themes/favicon.ico','public/favicon.ico');

/**
 * Gentelella Themes(Default)
 */
// Image Management
mix.copy('node_modules/gentelella/production/images/img.jpg','public/default/images/img.jpg');
mix.copy('node_modules/gentelella/vendors/iCheck/skins/flat/green@2x.png','public/css/green@2x.png');
mix.copyDirectory('resources/assets/themes/default/images','public/default/images');

// CSS Management
mix.styles([
    'public/css/app.css',
    'node_modules/gentelella/vendors/animate.css/animate.css',
    'node_modules/gentelella/vendors/pnotify/dist/pnotify.css',
    'node_modules/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.css',
    'node_modules/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.css',
    'node_modules/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.css',
    'node_modules/gentelella/vendors/iCheck/skins/flat/green.css',
], 'public/css/app.css');
mix.styles([
    'resources/assets/themes/default/css/login.css'
], 'public/default/css/login.css');
mix.styles([
    'node_modules/gentelella/build/css/custom.min.css',
], 'public/default/css/theme.css');

// JS Management
mix.scripts([
    'public/js/app.js',
    'node_modules/gentelella/vendors/pnotify/dist/pnotify.js',
    'node_modules/gentelella/vendors/datatables.net/js/jquery.dataTables.js',
    'node_modules/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.js',
    'node_modules/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.js',
    'node_modules/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js',
    'node_modules/gentelella/vendors/datatables.net-scroller/js/dataTables.scroller.js',
    'node_modules/gentelella/vendors/iCheck/icheck.js',
    'github_modules/bootstrapFormHelpers/dist/js/bootstrap-formhelpers.js'
], 'public/js/app.js');
mix.scripts([
    'node_modules/gentelella/build/js/custom.js',
    'resources/assets/themes/default/js/custom.js',
], 'public/default/js/theme.js');