const mix = require('laravel-mix');
mix.setResourceRoot('./');
mix.js('client/js/main.js', 'dist/js/main.js');

mix.webpackConfig({
    devtool: "source-map"
});
