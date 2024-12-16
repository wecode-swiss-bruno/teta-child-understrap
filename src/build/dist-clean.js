/* eslint-disable no-console, eslint-comments/disable-enable-pair */

'use strict';

/**
 * External dependencies
 */
const { promises: fs } = require( 'fs' );
const path = require( 'path' );

async function cleanDist() {
	const distPath = path.join( '..', '..', '..', 'teta-dist' );
	try {
		await fs.rm( distPath, { recursive: true, force: true } );
		console.log( 'Successfully cleaned dist directory' );
	} catch ( error ) {
		if ( error.code !== 'ENOENT' ) {
			console.error( 'Error cleaning dist directory:', error );
		}
	}
}

cleanDist().catch( console.error );
