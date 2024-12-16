const { src, dest, series, parallel } = require('gulp');
const replace = require('gulp-replace');
const fs = require('fs').promises;
const path = require('path');

// Task to get next version number
async function getNextVersion() {
    try {
        const distStylePath = path.join('..', 'teta-dist', 'style.css');
        const content = await fs.readFile(distStylePath, 'utf8');
        const versionMatch = content.match(/Version:\s*(\d+\.\d+\.\d+)/);
        
        if (versionMatch) {
            const [major, minor, patch] = versionMatch[1].split('.').map(Number);
            return `${major}.${minor}.${patch + 1}`;
        }
    } catch (error) {
        console.log('No previous version found, starting from 1.0.1');
        return '1.0.1';
    }
    return '1.0.1';
}

// Task to update version in dev theme
function updateDevVersion() {
    return src('./style.css')
        .pipe(replace(/Version:.*/, `Version: ${getNextVersion()}`))
        .pipe(dest('./'));
}

// Task to create dist version with modified theme info
function createDistVersion() {
    return src('./style.css')
        .pipe(replace(/Theme Name:.*/, 'Theme Name: Teta Theme DIST'))
        .pipe(replace(/Theme URI:.*/, 'Theme URI: https://wecode.swiss'))
        .pipe(replace(/Author:.*/, 'Author: Wecode'))
        .pipe(replace(/Author URI:.*/, 'Author URI: https://wecode.swiss'))
        .pipe(replace(/Version:.*/, `Version: ${getNextVersion()}`))
        .pipe(dest('../teta-dist/'));
}

// Task to modify style.css (this was the missing task)
function modifyStyleCSS() {
    return src('./style.css')
        .pipe(replace(/Version:.*/, `Version: ${getNextVersion()}`))
        .pipe(dest('./'));
}

// Export individual tasks
exports.updateDevVersion = updateDevVersion;
exports.createDistVersion = createDistVersion;
exports.modifyStyleCSS = modifyStyleCSS;

// Export default task that runs everything in series
exports.default = series(updateDevVersion, createDistVersion);

// Export build task as an alias for the default task
exports.build = exports.default; 