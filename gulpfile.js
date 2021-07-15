'use strict';

/**
 * Define configurations
 */

const info = require( './package.json' );

const config = {
	init: info.data.initFile,
	src: {
		scss: [ './assets/scss/**/*.scss' ],
		css: [ './assets/css/**/*.css', '!./assets/css/vendors/*' ],
		js: [ './assets/js/**/*.js', '!./assets/js/vendors/*' ],
		pot: [ './**/*.php', '!./__build/**/*.php', '!./__bak/**/*.php' ],
		build: [
			'./**/*',

			// Exclude OS files
			'!**/Thumbs.db',
			'!**/.DS_Store',
			'!./.DS_Store',

			// Exclude SCSS files
			'!**/scss/**',

			// Exclude development folders and files
			'!./.gitignore',
			'!./composer.json',
			'!./composer.lock',
			'!./vendor/**',
			'!./package*.json',
			'!./node_modules/**',
			'!./gulpfile.js',
			'!./*phpcs.xml*',
			'!./README.md',
			'!./LICENSE.md',
			'!./__**/**',
		],
	},
	dest: {
		scss: './assets/scss',
		css: './assets/css',
		js: './assets/js',
		icons: './assets/icons',
		pot: './languages',
		build: './__build/' + info.name,
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
const cleanCSS      = require( 'gulp-clean-css' );
const mmq           = require( 'gulp-merge-media-queries' );
const rtlcss        = require( 'gulp-rtlcss' );

// JS
const terser        = require( 'gulp-terser' );

// Translation
const wpPot         = require( 'gulp-wp-pot' );

// Others
const fs            = require( 'fs' );
const del           = require( 'del' );
const rename        = require( 'gulp-rename' );
const replace       = require( 'gulp-replace' );
const watch         = require( 'gulp-watch' );
const zip           = require( 'gulp-zip' );

/**
 * Task: Change plugin / theme info based on package.json values.
 */
gulp.task( 'init_file', function() {
	var info = JSON.parse( fs.readFileSync( './package.json' ) );

	return gulp.src( [ config.init ] )
		.pipe( replace( new RegExp( '((?:Plugin|Theme) Name: ).*' ), '$1' + info.title ) )
		.pipe( replace( new RegExp( '((?:Plugin|Theme) URI: ).*' ), '$1' + info.uri ) )
		.pipe( replace( new RegExp( '(Author: ).*' ), '$1' + info.author.name ) )
		.pipe( replace( new RegExp( '(Author URI: ).*' ), '$1' + info.author.url ) )
		.pipe( replace( new RegExp( '(Description: ).*' ), '$1' + info.description ) )
		.pipe( replace( new RegExp( '(Version: ).*' ), '$1' + info.version ) )
		.pipe( replace( new RegExp( '(Requires at least: ).*' ), '$1' + info.data.requiresWPVersion ) )
		.pipe( replace( new RegExp( '(Tested up to: ).*' ), '$1' + info.data.testedWPVersion ) )
		.pipe( replace( new RegExp( '(Requires PHP: ).*' ), '$1' + info.data.requiresPHPVersion ) )
		.pipe( replace( new RegExp( '(Tags: ).*' ), '$1' + info.keywords.join( ', ' ) ) )
		.pipe( replace( new RegExp( '(Text Domain: ).*' ), '$1' + info.name ) )

		.pipe( replace( new RegExp( '(\'' + info.name.toUpperCase().split( '-' ).join( '_' ) + '_VERSION\', \').*?(\'.*)' ), '$1' + info.version + '$2' ) )

		.pipe( gulp.dest( './' ) );
} );

/**
 * Task: Change info on readme.txt based on package.json values.
 */
gulp.task( 'readme_file', function() {
	var info = JSON.parse( fs.readFileSync( './package.json' ) );

	var contributors = info.contributors.map(function( contributor ) {
		return contributor.name;
	});

	return gulp.src( [ './readme.txt' ] )
		.pipe( replace( new RegExp( '(===).*(===)' ), '$1 ' + info.title + ' $2' ) )
		.pipe( replace( new RegExp( '(Contributors: ).*' ), '$1' + contributors.join( ', ' ) ) )
		.pipe( replace( new RegExp( '(Stable tag: ).*' ), '$1' + info.version ) )
		.pipe( replace( new RegExp( '(Requires at least: ).*' ), '$1' + info.data.requiresWPVersion ) )
		.pipe( replace( new RegExp( '(Tested up to: ).*' ), '$1' + info.data.testedWPVersion ) )
		.pipe( replace( new RegExp( '(Requires PHP: ).*' ), '$1' + info.data.requiresPHPVersion ) )
		.pipe( replace( new RegExp( '(Tags: ).*' ), '$1' + info.keywords.join( ', ' ) ) )

		.pipe( replace( new RegExp( '(\n\n).*(\n\n== Description ==)' ), '$1' + info.description + '$2' ) )

		.pipe( gulp.dest( './' ) );
} );

/**
 * Wrapper Task: Set theme info files.
 */
gulp.task( 'info', gulp.series( 'init_file', 'readme_file' ) );

/**
 * Task: Copy vendor assets.
 */
gulp.task( 'vendors', function( done ) {
	var info = JSON.parse( fs.readFileSync( './package.json' ) );

	// html5sortable
	gulp.src( './node_modules/html5sortable/dist/html5sortable?(.min).js' )
		.pipe( gulp.dest( config.dest.js + '/vendors' ) );

	// Change version
	gulp.src( './includes/class-suki-admin.php', { base: './' } )
		.pipe( replace( /(\$ver\['html5sortable'\] = )(?:.*)/g, '$1\'' + info.devDependencies['html5sortable'].replace( '^', '' ) + '\';' ) )
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

	fs.writeFile( './includes/lists/google-fonts.json', JSON.stringify( googleFonts ), function( error ) {
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
		.pipe( sass( {
			outputStyle: 'expanded',
			indentType: 'tab',
			indentWidth: 1,
		} )
		.on( 'error', sass.logError ) )
		.pipe( autoprefixer( { cascade: false } ) )
		.pipe( gulp.dest( config.dest.css ) );
} );

/**
 * Task: Make RTL CSS files.
 */
gulp.task( 'css_rtl', function() {
	var src = config.src.css.concat( [ '!./assets/css/**/*.min.css', '!./assets/css/**/*-rtl.css' ] );

	return gulp.src( src )
		.pipe( rtlcss() )
		.pipe( rename( { suffix: '-rtl' } ) )
		.pipe( gulp.dest( config.dest.css ) );
} );

/**
 * Task: Minify CSS files.
 */
gulp.task( 'css_min', function() {
	var src = config.src.css.concat( [ '!./assets/css/**/*.min.css' ] );

	return gulp.src( src )
		.pipe( mmq() )
		.pipe( cleanCSS() )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( gulp.dest( config.dest.css ) );
} );

/**
 * Task: Run group of tasks regarding CSS files in sequence.
 */
gulp.task( 'css', gulp.series( 'css_sass', 'css_rtl', 'css_min' ) );

/**
 * Task: Minify JS files.
 */
gulp.task( 'js', function() {
	var src = config.src.js.concat( [ '!./assets/js/**/*.min.js' ] );

	return gulp.src( src )
		.pipe( terser().on( 'error', function( error ) {
			console.error( error ); 
			this.emit( 'end' ); 
		} ) )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( gulp.dest( config.dest.js ) );
} );

/**
 * Task: Generate .pot file for translation.
 */
gulp.task( 'pot', function() {
	var info = JSON.parse( fs.readFileSync( './package.json' ) );

	return gulp.src( config.src.pot.concat( [ config.init ] ) )
		.pipe( wpPot( {
			domain: info.name,
			package: info.title,
			metadataFile: config.init,
		} ).on( 'error', function( error ) {
			console.error( error );
			this.emit( 'end' );
		} ) )
		.pipe( gulp.dest( config.dest.pot + '/' + info.name + '.pot' ) );
} );

/**
 * Task: Watch all files and copy to 'build' folder.
 */
gulp.task( 'watch', function() {
	watch( './package.json', function() {
		gulp.task( 'info' )();
	} );

	watch( config.src.pot, function() {
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

	return gulp.src( config.dest.build + '/**/*', { buffer: false, base: config.dest.build + '/../' } )
		.pipe( zip( info.name + '-' + info.version + '.zip' ) )
		.pipe( gulp.dest( config.dest.zip ) );
} );
