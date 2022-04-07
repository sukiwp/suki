/**
 * Load libraries
 */

// Main gulp library
const gulp = require( 'gulp' );

// CSS libraries
const sass = require( 'gulp-sass' )( require( 'sass' ) );
const sourcemaps = require( 'gulp-sourcemaps' );
const autoprefixer = require( 'gulp-autoprefixer' );
const cleanCSS = require( 'gulp-clean-css' );
const mmq = require( 'gulp-merge-media-queries' );
const rtlcss = require( 'gulp-rtlcss' );

// JS libraries
const webpack = require( 'webpack-stream' );
const terser = require( 'gulp-terser' );

// Translation libraries
const wpPot = require( 'gulp-wp-pot' );

// Zip libraries
const zip = require( 'gulp-zip' );

// Others
const replace = require( 'gulp-replace' );
const rename = require( 'gulp-rename' );
const path = require( 'path' );

/**
 * Configurations
 */

const package = require( './package.json' );
const config = {
	scripts: {
		src: 'src/*.*',
		dest: 'build',
	},
	js: {
		src: [
			'assets/js/**/*.js',
			'!assets/js/**/*.min.js',
		],
		dest: 'assets/js',
	},
	css: {
		src: 'sass/**/*.scss',
		srcRTL: [
			'assets/**/*.css',
			'!assets/**/*-rtl.css',
			'!assets/**/*.min.css',
		],
		srcMinify: [
			'assets/**/*.css',
			'!assets/**/*.min.css',
		],
		dest: 'assets/css',
	},
	pot: {
		src: [
			'**/*.php', // all php files
			'**/scripts/*.js', // all php files
			'!src/**/*', // ignore source files
			'!**/*.assets.php',  // ignore assets PHP file.
			'!node_modules/**/*', // ignore node modules
			'!vendor/**/*', // ignore composer packages
		],
		dest: 'languages',
	},
	zip: {
		src: [
			'**/*', // all project files

			'!**/.*', // ignore all dotfiles
			'!**/_*', // ignore all partial files
			'!**/{Thumbs.db,.DS_Store}', // ignore OS files
			'!{node_modules,node_modules/**/*}', // ignore node_modules
			'!{package.json,package-lock.json,yarn.lock}', // ignore npm/yarn files
			'!{gulp*,gulp**/*}', // ignore anything that starts with gulp

			'!README.md', // ignore readme.md
			'!*phpcs.xml*', // ignore phpcs.xml (all variants)
			'!*.config.js', // ignore all config.js files
			'!{vendor,vendor/**/*}', // ignore composer packages
			'!{composer.json,composer.lock}', // ignore composer files
		],
		dest: 'zip',
	},
}

/**
 * Copy project info from package.json to project main file and `readme.txt` file.
 */

// Copy project info to main file.
const copyInfoToMainFile = ( cb ) => {
	const infoFile = package.additionalInfo.initFile;
	
	gulp
	.src( infoFile )
	.pipe( replace( new RegExp( /^((\s*?\*\s*?)?(?:Plugin|Theme) Name:)[^\r\n]*?$/, 'm' ), '$1 ' + package.additionalInfo.title ) )
	.pipe( replace( new RegExp( /^((\s*?\*\s*?)?(?:Plugin|Theme) URI:)[^\r\n]*?$/, 'm' ), '$1 ' + package.additionalInfo.uri ) )
	.pipe( replace( new RegExp( /^((\s*?\*\s*?)?Author:)[^\r\n]*?$/, 'm' ), '$1 ' + package.author.name ) )
	.pipe( replace( new RegExp( /^((\s*?\*\s*?)?Author URI:)[^\r\n]*?$/, 'm' ), '$1 ' + package.author.url ) )
	.pipe( replace( new RegExp( /^((\s*?\*\s*?)?Description:)[^\r\n]*?$/, 'm' ), '$1 ' + package.description ) )
	.pipe( replace( new RegExp( /^((\s*?\*\s*?)?Version:)[^\r\n]*?$/, 'm' ), '$1 ' + package.version ) )
	.pipe( replace( new RegExp( /^((\s*?\*\s*?)?Requires at least:)[^\r\n]*?$/, 'm' ), '$1 ' + package.additionalInfo.requiresWPVersion ) )
	.pipe( replace( new RegExp( /^((\s*?\*\s*?)?Tested up to:)[^\r\n]*?$/, 'm' ), '$1 ' + package.additionalInfo.testedWPVersion ) )
	.pipe( replace( new RegExp( /^((\s*?\*\s*?)?Requires PHP:)[^\r\n]*?$/, 'm' ), '$1 ' + package.additionalInfo.requiresPHPVersion ) )
	.pipe( replace( new RegExp( /^((\s*?\*\s*?)?Tags:)[^\r\n]*?$/, 'm' ), '$1 ' + package.keywords.join( ', ' ) ) )
	.pipe( replace( new RegExp( /^((\s*?\*\s*?)?Text Domain:)[^\r\n]*?$/, 'm' ), '$1 ' + package.name ) )
	.pipe( replace( new RegExp( '([\'"]' + package.name.toUpperCase().split( '-' ).join( '_' ) + '_VERSION[\'"]),\s*[\'"].*?[\'"]', 'm' ), '$1, \'' + package.version + '\'' ) )
	.pipe( gulp.dest( path.dirname( infoFile ) ) );
	
	cb();
}

// Copy project info to `readme.txt` file.
const copyInfoToReadmeFile = ( cb ) => {
	const readmeFile = 'readme.txt';

	gulp
	.src( readmeFile )
	.pipe( replace( new RegExp( /^(===).*(===)$/, 'm' ), '$1 ' + package.additionalInfo.title + ' $2' ) )
	.pipe( replace( new RegExp( /^(Contributors:).*?$/, 'm' ), '$1 ' + package.additionalInfo.authorSlug ) )
	.pipe( replace( new RegExp( /^(Stable tag:).*?$/, 'm' ), '$1 ' + package.version ) )
	.pipe( replace( new RegExp( /^(Requires at least:).*?$/, 'm' ), '$1 '  + package.additionalInfo.requiresWPVersion ) )
	.pipe( replace( new RegExp( /^(Tested up to:).*?$/, 'm' ), '$1 ' + package.additionalInfo.testedWPVersion ) )
	.pipe( replace( new RegExp( /^(Requires PHP:).*?$/, 'm' ), '$1 ' + package.additionalInfo.requiresPHPVersion ) )
	.pipe( replace( new RegExp( /^(Tags:).*?$/, 'm' ), '$1 ' + package.keywords.join( ', ' ) ) )
	.pipe( gulp.dest( path.dirname( readmeFile ) ) );

	cb();
}

/**
 * Compile ES6 JS files.
 */

const buildScripts = ( cb ) => {
	const wpWebpackConfig = require( '@wordpress/scripts/config/webpack.config' );

	// delete wpWebpackConfig.entry;
	// delete wpWebpackConfig.output;

	// gulp
	// .src( config.scripts.src )
	// .pipe( webpack( wpWebpackConfig ) )
	// .pipe( gulp.dest( config.scripts.dest ) )

	cb();
}

/**
 * Build JS files.
 */

const buildJS = ( cb ) => {
	gulp
	.src( config.js.src )
	.pipe( sourcemaps.init() )
	.pipe( terser() )
	.pipe( sourcemaps.write() )
	.pipe( rename( { suffix: '.min' } ) )
	.pipe( gulp.dest( config.js.dest ) );

	cb();
}

/**
 * Build CSS files.
 */

const compileSass = ( cb ) => {
	gulp
	.src( config.css.src )
	.pipe( sourcemaps.init() )
	.pipe( sass( {
		outputStyle: 'expanded',
		indentType: 'tab',
		indentWidth: 1,
	} ).on( 'error', sass.logError ) )
	.pipe( sourcemaps.write() )
	.pipe( autoprefixer( { cascade: false } ) )
	.pipe( gulp.dest( config.css.dest ) )

	cb();
}

const generateRTLCSS = ( cb ) => {
	gulp
	.src( config.css.srcRTL )
	.pipe( rtlcss() )
	.pipe( rename( { suffix: '-rtl' } ) )
	.pipe( gulp.dest( config.css.dest ) );

	cb();
}

const minifyCSS = ( cb ) => {
	gulp
	.src( config.css.srcMinify )
	.pipe( mmq() )
	.pipe( cleanCSS() )
	.pipe( rename( { suffix: '.min' } ) )
	.pipe( gulp.dest( config.css.dest ) );
}

const buildCSS = gulp.series( compileSass, generateRTLCSS, minifyCSS );

/**
 * Build .pot file.
 */

const buildPOT = ( cb ) => {
	gulp
	.src( config.src.pot.concat( [ config.init ] ) )
	.pipe( wpPot( {
		domain: package.name,
		package: package.title,
		metadataFile: package.additionalInfo.initFile,
	} ) )
	.pipe( gulp.dest( config.pot.dest + '/' + package.name + '.pot' ) );

	cb();
}

/**
 * Run all build tasks in sequence.
 */

const build = gulp.series( buildScripts, buildCSS, buildJS, buildPOT );

/**
 * Compress production files into a zip file.
 */
 
const zipFiles = ( cb ) => {
	 // Add timestamp to dev build.
	 if ( package.version.endsWith( 'dev' ) ) {
		 package.version = package.version.replace( 'dev', 'dev-' + Date.now() );
	 }
 
	 gulp
	 .src( config.zip.src )
	 .pipe( zip( package.name + '-' + package.version + '.zip' ) )
	 .pipe( gulp.dest( config.zip.dest ) );
 
	 cb();
}
 
/**
 * Watch any change on the files and then run the particular tasks.
 */

const watch = ( cb ) => {
	gulp.watch( 'package.json', 'info' );

	gulp.watch( config.scripts.src, 'scripts' );

	gulp.watch( config.js.src, 'js' );
	
	gulp.watch( config.css.src, 'css' );

	gulp.watch( config.pot.src, 'pot' );
}

/**
 * Export tasks
 */

exports.info = gulp.series( copyInfoToMainFile, copyInfoToReadmeFile );

exports.scripts = buildScripts;

exports.js = buildJS;

exports.css = buildCSS;

exports.pot = buildPOT;

exports.build = build;

exports.watch = watch;

exports.default = gulp.series( build, watch );

exports.zip = gulp.series( build, zipFiles );