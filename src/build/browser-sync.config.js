module.exports = {
    proxy: "teta.wecode.local",
    port: 3000,
    https: true,
    open: false,
    notify: false,
    // Amélioration de la configuration des fichiers à surveiller
    files: [
        './css/*.css',
        './js/*.js',
        './**/*.php',
        './**/*.scss',
        './img/**/*',
        '!./node_modules/**/*',
        '!./src/**/*.scss'  // Exclure les fichiers source SCSS
    ],
    // Ajouter ces options pour améliorer la réactivité
    watchEvents: ['change', 'add', 'unlink', 'addDir', 'unlinkDir'],
    ignore: [
        'node_modules/**/*',
        'src/sass/**/*.scss'  // Ignorer les fichiers SCSS sources
    ],
    reloadDelay: 0,
    reloadDebounce: 0,
    injectChanges: true
};