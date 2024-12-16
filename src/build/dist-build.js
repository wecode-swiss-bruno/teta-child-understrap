const { promises: fs } = require("fs")
const path = require("path")
const { exec } = require('child_process');
const util = require('util');
const execPromise = util.promisify(exec);

async function copyDir(src, dest) {
    await fs.mkdir(dest, { recursive: true });
    let entries = await fs.readdir(src, { withFileTypes: true });
    let ignore = [
        'node_modules',
        'dist',
        'src',
        '.git',
        '.github',
        '.browserslistrc',
        '.editorconfig',
        '.gitattributes',
        '.gitignore',
        '.jscsrc',
        '.jshintignore',
        '.travis.yml',
        'composer.json',
        'composer.lock',
        'package.json',
        'package-lock.json',
        'phpcs.xml.dist',
        'readme.txt'
    ];

    // First update the dev version
    try {
        await execPromise('gulp updateDevVersion');
        console.log('Updated dev version successfully');
    } catch (error) {
        console.error('Error updating dev version:', error);
        return;
    }

    for (let entry of entries) {
        if (ignore.indexOf(entry.name) != -1) {
            continue;
        }
        let srcPath = path.join(src, entry.name);
        let destPath = path.join(dest, entry.name);

        if (entry.isDirectory()) {
            await copyDir(srcPath, destPath);
        } else {
            if (entry.name === 'style.css') {
                // Use gulp task for style.css
                try {
                    await execPromise('gulp createDistVersion');
                    console.log('Created dist version successfully');
                } catch (error) {
                    console.error('Error creating dist version:', error);
                }
            } else {
                // Copy other files normally
                await fs.copyFile(srcPath, destPath);
            }
        }
    }
}

copyDir('./', '../teta-dist').catch(console.error);
