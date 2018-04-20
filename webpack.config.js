// webpack.config.js
var Encore = require('@symfony/webpack-encore');

Encore
// the project directory where all compiled assets will be stored
    .setOutputPath('public/build/')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .addEntry('/js/admin-schedule', ["babel-polyfill", './assets/js/admin-schedule.js'])
    .addEntry('/js/schedule', ["babel-polyfill", './assets/js/schedule.js'])
    .addEntry('/js/courses-list-table', ["babel-polyfill", './assets/js/courses-list-table.js'])
    .addEntry('/js/question', ["babel-polyfill", './assets/js/question.js'])
    .addEntry('/js/comment-input', ["babel-polyfill", './assets/js/comment-input.js'])
    .addEntry('/js/question-list', ["babel-polyfill", './assets/js/question-list.js'])
    .addEntry('/js/question-view-more', ["babel-polyfill", './assets/js/question-view-more.js'])
    .addEntry('/js/question-comments-list', ["babel-polyfill", './assets/js/question-comments-list.js'])
    .addEntry('/js/comment', ["babel-polyfill", './assets/js/comment.js'])
    .addEntry('/js/api-client', ["babel-polyfill", './assets/js/api-client.js'])
    .addEntry('/js/api', ["babel-polyfill", './assets/js/api.js'])
    // will create public/build/app.js and public/build/app.css
    .addStyleEntry('/css/style', `./assets/sass/style.scss`)

    // allow sass/scss files to be processed
    .enableSassLoader()

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    .enableSourceMaps(!Encore.isProduction())

    .enableReactPreset()
    .configureBabel((config) => {
        config.presets.push('stage-3');
        config.plugins.push('transform-class-properties');
    })


    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // show OS notifications when builds finish/fail
    //.enableBuildNotifications()

// create hashed filenames (e.g. app.abc123.css)
// .enableVersioning()
;

// export the final configuration
module.exports = Encore.getWebpackConfig();