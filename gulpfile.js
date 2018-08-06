const elixir = require('laravel-elixir');

require('laravel-elixir-webpack-official');

require('laravel-elixir-vue-2');

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

Elixir.webpack.mergeConfig({
    module: {
        loaders: [
            // ...
            { test: 'jquery', loader: 'expose?$!expose?jQuery' },
            { test: /\.js/, loader: 'imports?define=>false'}
        ]
    }
});

elixir(mix => {

    // App Themes
    mix.sass('app_silver-brown.scss')
        .sass('app_yellow-blu.scss')
        .sass('app_cream-green.scss')
        .sass('app_sun-red.scss');
    
    // App Js
    mix.webpack('app.js');

    
    // Login CSS
    mix.sass('login.scss');

    // Login JS
    mix.webpack('login.js');
    
    // Set Browser Sync    
    mix.browserSync({
        proxy: 'passwordbag.dev'
    });
});
