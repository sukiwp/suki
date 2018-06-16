'use strict';

/**
 * Define configurations
 */

const config = {
	src: {
		scss: [ './assets/scss/**/*.scss' ],
		css: [ './assets/css/**/*.css', '!./assets/css/vendors/*' ],
		js: [ './assets/js/**/*.js', '!./assets/js/vendors/*' ],
		php: [ './**/*.php', '!./__build/**/*.php' ],
		build: [
			'./*',
			'./assets/css/**/*',
			'./assets/icons/**/*',
			'./assets/images/**/*',
			'./assets/js/**/*',
			'./inc/**/*',
			'./languages/**/*',
			'./page-templates/**/*',
			'./template-parts/**/*',

			// exclude files and folders
			'!**/Thumbs.db',
			'!**/.DS_Store',
			'!./.gitignore',
			'!./package*.json',
			'!./gulpfile.js',
			'!./node_modules',
			'!./README.md',
			'!./LICENSE.md',
			'!./__build',
		],
	},
	dest: {
		scss: './assets/scss',
		css: './assets/css',
		js: './assets/js',
		webfonts: './assets/webfonts',
		icons: './assets/icons',
		pot: './languages',
		build: './__build/suki',
		zip: './__build/zip',
	},
};

/**
 * Init Gulp and plugins
 */

const gulp          = require( 'gulp' );

// CSS
const sass          = require( 'gulp-sass' );
const autoprefixer  = require( 'gulp-autoprefixer' );
const uglifycss     = require( 'gulp-uglifycss' );
const sourcemaps    = require( 'gulp-sourcemaps' );
const mmq           = require( 'gulp-merge-media-queries' );
const rtlcss        = require( 'gulp-rtlcss' );

// JS
const uglify        = require( 'gulp-uglify' );

// Translation
const wpPot         = require( 'gulp-wp-pot' );

// Others
const request       = require( 'request' );
const fs            = require( 'fs' );
const del           = require( 'del' );
const sort          = require( 'gulp-sort' );
const rename        = require( 'gulp-rename' );
const replace       = require( 'gulp-replace' );
const watch         = require( 'gulp-watch' );
const zip           = require( 'gulp-zip' );
const sequence      = require( 'gulp-sequence' );

/**
 * Task: Change theme info (style.css file header) based on package.json values.
 */
gulp.task( 'style_css', function() {
	var info = JSON.parse( fs.readFileSync( './package.json' ) );

	// Change theme version on style.css
	return gulp.src( [ './style.css' ] )
		.pipe( replace( /(Theme Name: ).*/, '$1' + info.title ) )
		.pipe( replace( /(Theme URI: ).*/, '$1' + info.uri ) )
		.pipe( replace( /(Description: ).*/, '$1' + info.description ) )
		.pipe( replace( /(Version: ).*/, '$1' + info.version ) )
		.pipe( replace( /(Author: ).*/, '$1' + info.author.name ) )
		.pipe( replace( /(Author URI: ).*/, '$1' + info.author.url ) )
		.pipe( replace( /(Text Domain: ).*/, '$1' + info.name ) )
		.pipe( replace( /(Tags: ).*/, '$1' + info.keywords.join( ', ' ) ) )
		.pipe( gulp.dest( './' ) );
} );

/**
 * Task: Change info on readme.txt based on package.json values.
 */
gulp.task( 'readme_txt', function() {
	var info = JSON.parse( fs.readFileSync( './package.json' ) );

	// Change theme version on eadme.txt
	return gulp.src( [ './readme.txt' ] )
		.pipe( replace( /(===)[.\s]*(===)/, '$1 ' + info.title + ' $2' ) )

		.pipe( replace( /(Contributors: ).*/, '$1' + info.author.name.toLowerCase() ) )
		.pipe( replace( /(Tags: ).*/, '$1' + info.keywords.join( ', ' ) ) )

		.pipe( replace( /(Stable tag: ).*/, '$1' + info.version ) )

		.pipe( replace( /(== Description ==)[.\s]*(==)/, '$1\n\n' + info.description + '\n\n$2' ) )

		.pipe( gulp.dest( './' ) );
} );

/**
 * Wrapper Task: Set theme info files.
 */
gulp.task( 'info', gulp.series( 'style_css', 'readme_txt' ) );

/**
 * Task: Copy vendor assets.
 */
gulp.task( 'vendors', function( done ) {
	var info = JSON.parse( fs.readFileSync( './package.json' ) );

	/**
	 * Main page scripts
	 */

	// Normalize.css
	gulp.src( './node_modules/normalize.css/normalize.css' )
		.pipe( replace( /\/\*\!/, '/*' ) )
		.pipe( uglifycss( { uglyComments: true } ) )
		.pipe( rename( { prefix: '_', extname: '.scss' } ) )
		.pipe( gulp.dest( config.dest.scss ) );

	// classList Polyfill
	gulp.src( './node_modules/eligrey-classlist-js-polyfill/classList.min.js' )
		.pipe( gulp.dest( config.dest.js + '/vendor' ) );

	// Change version
	gulp.src( './inc/class-suki.php', { base: './' } )
		.pipe( replace( /(\$ver\['classlist-polyfill'\])(?:.*)/, '$1 = \'' + info.devDependencies['eligrey-classlist-js-polyfill'].replace( '^', '' ) + '\';' ) )
		.pipe( gulp.dest( './' ) );

	/**
	 * Admin page scripts
	 */

	// jQuery repeater
	gulp.src( './node_modules/jquery.repeater/jquery.repeater.min.js' )
		.pipe( gulp.dest( config.dest.js + '/vendor' ) );

	// Select2
	gulp.src( './node_modules/select2/dist/css/select2.min.css' )
		.pipe( gulp.dest( config.dest.css + '/vendor' ) );
	gulp.src( './node_modules/select2/dist/js/select2.min.js' )
		.pipe( gulp.dest( config.dest.js + '/vendor' ) );

	// Change version
	gulp.src( './inc/admin/class-suki-admin.php', { base: './' } )
		.pipe( replace( /(\$ver\['jquery.repeater'\])(?:.*)/, '$1 = \'' + info.devDependencies['jquery.repeater'].replace( '^', '' ) + '\';' ) )
		.pipe( replace( /(\$ver\['select2'\])(?:.*)/, '$1 = \'' + info.devDependencies['select2'].replace( '^', '' ) + '\';' ) )
		.pipe( gulp.dest( './' ) );

	/**
	 * Google Fonts JSON
	 */

	var rawGoogleFonts = JSON.parse( fs.readFileSync( './node_modules/google-fonts-complete/api-response.json' ) ),
		googleFonts = {};

	for ( var i = 0; i < rawGoogleFonts.length; i++ ) {
		var font = rawGoogleFonts[ i ];

		var fallback = font.category;
		if ( 'handwriting' === font.category ) {
			fallback = 'cursive';
		} else if ( 'display' === font.category ) {
			fallback = 'fantasy';
		}

		googleFonts[ font.family ] = '"' + font.family + '", ' + fallback;
	}

	fs.writeFile( './inc/list/google-fonts.json', JSON.stringify( googleFonts ), function( error ) {
		if ( error ) {
			console.log( error );
		}
	});

	done();
} );

/**
 * Task: Convert SASS to CSS files.
 */
gulp.task( 'css_sass', function() {
	return gulp.src( config.src.scss )
		.pipe( sourcemaps.init() )
		.pipe( sass( {
			outputStyle: 'expanded',
			indentType: 'tab',
			indentWidth: 1,
		} ).on( 'error', sass.logError ) )
		.pipe( autoprefixer( { cascade: false } ) )
		.pipe( sourcemaps.write( { includeContent: false } ) )
		.pipe( gulp.dest( config.dest.css ) );
} );

/**
 * Task: Minify CSS files.
 */
gulp.task( 'css_min', function() {
	var src = config.src.css.concat( [ '!./assets/css/**/*.min.css', '!./assets/css/**/*-rtl.css' ] );

	return gulp.src( src )
		.pipe( mmq() )
		.pipe( uglifycss() )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( gulp.dest( config.dest.css ) );
} );

/**
 * Task: Make RTL CSS files.
 */
gulp.task( 'css_rtl', function() {
	var src = config.src.css.concat( [ '!./assets/css/**/*-rtl.css' ] );

	return gulp.src( src )
		.pipe( rtlcss() )
		.pipe( rename( { suffix: '-rtl' } ) )
		.pipe( gulp.dest( config.dest.css ) );
} );

/**
 * Task: Run group of tasks regarding CSS files in sequence.
 */
gulp.task( 'css', gulp.series( 'css_sass', 'css_min', 'css_rtl' ) );

/**
 * Task: Minify JS files.
 */
gulp.task( 'js', function() {
	var src = config.src.js.concat( [ '!./assets/js/**/*.min.js' ] );

	return gulp.src( src )
		.pipe( uglify().on( 'error', function( u ) {
			console.log( u );
		} ) )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( gulp.dest( config.dest.js ) );
} );

/**
 * Task: Generate .pot file for translation.
 */
gulp.task( 'pot', function() {
	var info = JSON.parse( fs.readFileSync( './package.json' ) );

	return gulp.src( config.src.php )
		.pipe( sort() )
		.pipe( wpPot( {
			domain: info.name,
			destFile: 'suki.pot',
			package: info.title,
		} ) )
		.pipe( gulp.dest( config.dest.pot ) );
} );

/**
 * Task: Watch all files and copy to 'build' folder.
 */
gulp.task( 'watch', function() {
	watch( './package.json', function() {
		gulp.task( 'info' )();
	} );

	watch( config.src.php, function() {
		gulp.task( 'pot' )();
	} );

	watch( config.src.scss, function() {
		gulp.task( 'css' )();
	} );

	watch( config.src.js.concat( [ '!./assets/js/**/*.min.js' ] ), function( obj ) {
		gulp.task( 'js' )();
	} );

	watch( config.src.build, { base: './' }, function( obj ) {
		if ( 'unlink' === obj.event ) {
			del( config.dest.build + '/' + obj.relative, { force: true } );
		} else {
			gulp.src( obj.path, { base: './' } )
				.pipe( gulp.dest( config.dest.build ) );
		}
	} );
} );

/**
 * Task: Clean files in "__build" directory.
 */
gulp.task( 'clean', function() {
	return del( config.dest.build + '/*', { force: true } );
} );

/**
 * Task: Copy selected files from sources to "__build" directory.
 */
gulp.task( 'copy', function() {
	return gulp.src( config.src.build, { base: './' } )
		.pipe( gulp.dest( config.dest.build ) );
} );

/**
 * Wrapper Task: Build.
 */
gulp.task( 'build', gulp.series( 'pot', 'css', 'js', 'info', 'clean', 'copy' ) );

/**
 * Wrapper Task: Default task.
 */
gulp.task( 'default', gulp.series( 'build', 'watch' ) );

/**
 * Wrapper Task: Build to zip.
 */
gulp.task( 'zip', function() {
	var info = JSON.parse( fs.readFileSync( './package.json' ) );

	return gulp.src( config.dest.build + '/**/*', { buffer: false, base: config.dest.build } )
		.pipe( zip( info.name + '.zip' ) )
		.pipe( gulp.dest( config.dest.zip ) );
} );