module.exports = {
    proxy: "http://teta.wecode.local",
    port: 3000,
    https: false,
    open: false,
    notify: false,
    middleware: function (req, res, next) {
        if (req.headers.host.indexOf(':3000') > -1) {
            return next();
        }
        res.setHeader('Access-Control-Allow-Origin', '*');
        next();
    },
    files: [
        './css/*.css',
        './js/*.js',
        './**/*.php',
        './**/*.scss',
        './img/**/*',
        '!./node_modules/**/*',
        '!./src/**/*.scss'
    ],
    watchEvents: ['change', 'add', 'unlink', 'addDir', 'unlinkDir'],
    ignore: [
        'node_modules/**/*',
        'src/sass/**/*.scss'
    ],
    reloadDelay: 0,
    reloadDebounce: 0,
    injectChanges: true,
    snippetOptions: {
        ignorePaths: ["wp-admin/**"]
    }
};