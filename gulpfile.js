var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir.config.sourcemaps = false;

elixir(function(mix) {
    mix.less([
        '../vendor/bootstrap/less/bootstrap.less',
        'elements.less',
        'core.less',
        'components.less',
        'icons.less',
        'pages.less',
        'menu.less',
        'responsive.less',
        'animate.css',
        'app.less'
    ], 'public/css/app.css');

    mix.styles([
        '../plugins/custombox/dist/custombox.min.css',
        '../plugins/editstrap-3.1.0/editstrap.css',
        '../plugins/bootstrap-colorselector-0.2.0/css/bootstrap-colorselector.css',
        '../plugins/sweetalert/dist/sweetalert.css',
        '../plugins/select2/select2.css',
        '../plugins/switchery/dist/switchery.min.css',
        '../plugins/notifications/notification.css',
        '../plugins/jquery.steps/demo/css/jquery.steps.css',
        '../plugins/clockpicker/dist/bootstrap-clockpicker.min.css',
        '../plugins/dropzone/dist/dropzone.css',
        '../plugins/magnific-popup/dist/magnific-popup.css',
        '../plugins/morris/morris.css'
    ], 'public/css/vendor.css');

    mix.scripts([
        'jquery.min.js',
        'bootstrap.min.js',
        'detect.js',
        'fastclick.js',
        'jquery.slimscroll.js',
        'modernizr.min.js',
        'waves.js',
        'typeahead.js',
        '../plugins/custombox/dist/custombox.min.js',
        '../plugins/custombox/dist/legacy.min.js',
        '../plugins/pjax/jquery.pjax.js',
        '../plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js',
        '../plugins/bootstrap-colorselector-0.2.0/js/bootstrap-colorselector.js',
        '../plugins/sweetalert/dist/sweetalert.min.js',
        '../plugins/select2/select2.js',
        '../plugins/switchery/dist/switchery.min.js',
        '../plugins/jquery.steps/build/jquery.steps.min.js',
        '../plugins/clockpicker/dist/bootstrap-clockpicker.min.js',
        '../plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
        '../plugins/waypoints/lib/jquery.waypoints.js',
        '../plugins/raphael/raphael-min.js',
        '../plugins/morris/morris.min.js',
        '../plugins/counterup/jquery.counterup.min.js',
        '../plugins/moment/min/moment.min.js',
        '../plugins/notifications/notify.min.js',
        '../plugins/notifications/notify-metro.js',
        '../plugins/magnific-popup/dist/jquery.magnific-popup.min.js',
        '../plugins/editstrap-3.1.0/editstrap.js',
        '../plugins/dropzone/dist/dropzone.js',
        'jquery.sweetalert.js',
        'jquery.wizard.init.js',
        'app.js'
    ], 'public/js/app.js');

    mix.copy('resources/assets/fonts', 'public/fonts');
    mix.copy('resources/assets/images/agsquare.png', 'public/img/agsquare.png');
    mix.copy('resources/assets/plugins/x-editable/dist/jquery-editable/img/clear.png', 'public/img/clear.png');
    mix.copy('resources/assets/plugins/x-editable/dist/jquery-editable/img/loading.gif', 'public/img/loading.gif');
    mix.copy('resources/assets/plugins/select2/select2x2.png', 'public/img/select2x2.png');
    mix.copy('resources/assets/plugins/select2/select2.png', 'public/img/select2.png');
    mix.copy('resources/assets/plugins/select2/select2-spinner.gif', 'public/img/select2-spinner.gif');
});
