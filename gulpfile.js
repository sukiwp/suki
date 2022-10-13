/**
 * Load libraries
 */

// Main gulp library
const gulp = require( 'gulp' );

// CSS libraries
const sass = require( 'gulp-sass' )( require( 'sass' ) );
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
const named = require( 'vinyl-named' );
const replace = require( 'gulp-replace' );
const rename = require( 'gulp-rename' );
const path = require( 'path' );
const del = require( 'del' );

/**
 * Configurations
 */

const config = {
	scripts: {
		src: 'src/scripts/*.*',
		dest: 'assets/scripts',
		watch: 'src/scripts/**/*.*',
	},
	js: {
		src: [ 'assets/js/**/*.js', '!assets/js/**/*.min.js' ],
		dest: 'assets/js',
	},
	css: {
		src: 'src/sass/**/*.scss',
		srcRTL: [
			'assets/css/**/*.css',
			'!assets/css/**/*-rtl.css',
			'!assets/css/**/*.min.css',
		],
		srcMinify: [ 'assets/css/**/*.css', '!assets/css/**/*.min.css' ],
		dest: 'assets/css',
		watch: 'src/sass/**/*.scss',
	},
	pot: {
		src: [
			'**/*.php', // all php files
			'!src/**/*', // ignore source files
			'!**/*.asset.php', // ignore assets PHP file.
			'!node_modules/**/*', // ignore node modules
			'!vendor/**/*', // ignore composer packages
			// Init file will be added in the pot task
		],
		dest: 'languages',
	},
	zip: {
		src: [
			'**/*', // all project files

			'!**/.*', // ignore all dotfiles
			'!**/_*', // ignore all partial files
			'!**/{Thumbs.db,.DS_Store}', // ignore OS files

			'!src/**', // ignore all source files
			'!README.md', // ignore readme.md

			'!*phpcs.xml*', // ignore phpcs.xml (all variants)
			'!*.config.js', // ignore all config.js files

			'!node_modules/**', // ignore node_modules
			'!{package.json,package-lock.json,yarn.lock}', // ignore npm/yarn files
			'!{gulp*,gulp**/*}', // ignore anything that starts with gulp

			'!vendor/**', // ignore composer packages
			'!{composer.json,composer.lock}', // ignore composer files
		],
		dest: 'zip',
	},
};

/**
 * Copy project info from package.json to project main file and `readme.txt` file.
 */

// Copy project info to main file.
const copyInfoToMainFile = () => {
	const packageInfo = require( './package.json' );

	const infoFile = packageInfo.additionalInfo.initFile;

	return gulp
		.src( infoFile )
		.pipe(
			replace(
				new RegExp(
					/^((\s*?\*\s*?)?(?:Plugin|Theme) Name:)[^\r\n]*?$/,
					'm'
				),
				'$1 ' + packageInfo.additionalInfo.title
			)
		)
		.pipe(
			replace(
				new RegExp(
					/^((\s*?\*\s*?)?(?:Plugin|Theme) URI:)[^\r\n]*?$/,
					'm'
				),
				'$1 ' + packageInfo.homepage
			)
		)
		.pipe(
			replace(
				new RegExp( /^((\s*?\*\s*?)?Author:)[^\r\n]*?$/, 'm' ),
				'$1 ' + packageInfo.author.name
			)
		)
		.pipe(
			replace(
				new RegExp( /^((\s*?\*\s*?)?Author URI:)[^\r\n]*?$/, 'm' ),
				'$1 ' + packageInfo.author.url
			)
		)
		.pipe(
			replace(
				new RegExp( /^((\s*?\*\s*?)?Description:)[^\r\n]*?$/, 'm' ),
				'$1 ' + packageInfo.description
			)
		)
		.pipe(
			replace(
				new RegExp( /^((\s*?\*\s*?)?Version:)[^\r\n]*?$/, 'm' ),
				'$1 ' + packageInfo.version
			)
		)
		.pipe(
			replace(
				new RegExp(
					/^((\s*?\*\s*?)?Requires at least:)[^\r\n]*?$/,
					'm'
				),
				'$1 ' + packageInfo.additionalInfo.requiresWPVersion
			)
		)
		.pipe(
			replace(
				new RegExp( /^((\s*?\*\s*?)?Tested up to:)[^\r\n]*?$/, 'm' ),
				'$1 ' + packageInfo.additionalInfo.testedWPVersion
			)
		)
		.pipe(
			replace(
				new RegExp( /^((\s*?\*\s*?)?Requires PHP:)[^\r\n]*?$/, 'm' ),
				'$1 ' + packageInfo.additionalInfo.requiresPHPVersion
			)
		)
		.pipe(
			replace(
				new RegExp( /^((\s*?\*\s*?)?Tags:)[^\r\n]*?$/, 'm' ),
				'$1 ' + packageInfo.keywords.join( ', ' )
			)
		)
		.pipe(
			replace(
				new RegExp( /^((\s*?\*\s*?)?Text Domain:)[^\r\n]*?$/, 'm' ),
				'$1 ' + packageInfo.name
			)
		)
		.pipe(
			replace(
				new RegExp(
					'([\'"]' +
						packageInfo.name
							.toUpperCase()
							.split( '-' )
							.join( '_' ) +
						'_VERSION[\'"]),s*[\'"].*?[\'"]',
					'm'
				),
				"$1, '" + packageInfo.version + "'"
			)
		)
		.pipe( gulp.dest( path.dirname( infoFile ) ) );
};

// Copy project info to `readme.txt` file.
const copyInfoToReadmeFile = () => {
	const packageInfo = require( './package.json' );

	const readmeFile = 'readme.txt';

	return gulp
		.src( readmeFile )
		.pipe(
			replace(
				new RegExp( /^(===).*(===)$/, 'm' ),
				'$1 ' + packageInfo.additionalInfo.title + ' $2'
			)
		)
		.pipe(
			replace(
				new RegExp( /^(Contributors:).*?$/, 'm' ),
				'$1 ' + packageInfo.additionalInfo.authorSlug
			)
		)
		.pipe(
			replace(
				new RegExp( /^(Stable tag:).*?$/, 'm' ),
				'$1 ' + packageInfo.version
			)
		)
		.pipe(
			replace(
				new RegExp( /^(Requires at least:).*?$/, 'm' ),
				'$1 ' + packageInfo.additionalInfo.requiresWPVersion
			)
		)
		.pipe(
			replace(
				new RegExp( /^(Tested up to:).*?$/, 'm' ),
				'$1 ' + packageInfo.additionalInfo.testedWPVersion
			)
		)
		.pipe(
			replace(
				new RegExp( /^(Requires PHP:).*?$/, 'm' ),
				'$1 ' + packageInfo.additionalInfo.requiresPHPVersion
			)
		)
		.pipe(
			replace(
				new RegExp( /^(Tags:).*?$/, 'm' ),
				'$1 ' + packageInfo.keywords.join( ', ' )
			)
		)
		.pipe( gulp.dest( path.dirname( readmeFile ) ) );
};

const copyInfo = gulp.series( copyInfoToMainFile, copyInfoToReadmeFile );

/**
 * Compile ES6 JS files.
 */

const buildScripts = () => {
	// Load default configuration from @wordpress/scripts package.
	const wpWebpackConfig = require( '@wordpress/scripts/config/webpack.config' );

	// Remove default entry configuration, we will use our own configuration instead.
	delete wpWebpackConfig.entry;

	return gulp
		.src( config.scripts.src )
		.pipe( named() )
		.pipe( webpack( wpWebpackConfig ) )
		.pipe( gulp.dest( config.scripts.dest ) );
};

/**
 * Build JS files.
 */

const buildJS = () => {
	return gulp
		.src( config.js.src )
		.pipe( terser() )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( gulp.dest( config.js.dest ) );
};

/**
 * Build CSS files.
 */

const compileSass = () => {
	return gulp
		.src( config.css.src )
		.pipe(
			sass( {
				outputStyle: 'expanded',
				indentType: 'tab',
				indentWidth: 1,
			} ).on( 'error', sass.logError )
		)
		.pipe( autoprefixer( { cascade: false } ) )
		.pipe( gulp.dest( config.css.dest ) );
};

const generateRTLCSS = () => {
	return gulp
		.src( config.css.srcRTL )
		.pipe( rtlcss() )
		.pipe( rename( { suffix: '-rtl' } ) )
		.pipe( gulp.dest( config.css.dest ) );
};

const minifyCSS = () => {
	return gulp
		.src( config.css.srcMinify )
		.pipe( mmq() )
		.pipe( cleanCSS() )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( gulp.dest( config.css.dest ) );
};

const buildCSS = gulp.series( compileSass, generateRTLCSS, minifyCSS );

/**
 * Build .pot file.
 */

const buildPOT = () => {
	const packageInfo = require( './package.json' );

	return gulp
		.src( [
			config.pot.src,
			packageInfo.additionalInfo.initFile, // init file.
		] )
		.pipe(
			wpPot( {
				domain: packageInfo.name,
				package: packageInfo.title,
				metadataFile: packageInfo.additionalInfo.initFile,
			} )
		)
		.pipe( gulp.dest( config.pot.dest + '/' + packageInfo.name + '.pot' ) );
};

/**
 * Run all build tasks in sequence.
 */

const buildAll = gulp.series(
	copyInfo,
	buildScripts,
	buildJS,
	buildCSS,
	buildPOT
);

/**
 * Compress production files into a zip file.
 */

const zipFiles = () => {
	const packageInfo = require( './package.json' );

	// Add timestamp to dev build.
	if ( packageInfo.version.endsWith( 'dev' ) ) {
		packageInfo.version = packageInfo.version.replace(
			'dev',
			'dev-' + Date.now()
		);
	}

	return gulp
		.src( config.zip.src, { buffer: false, base: './../' } )
		.pipe( zip( packageInfo.name + '-' + packageInfo.version + '.zip' ) )
		.pipe( gulp.dest( config.zip.dest ) );
};

/**
 * Watch any change on the files and then run the particular tasks.
 */

const watchChanges = () => {
	/**
	 * Package.json
	 */
	gulp.watch( './package.json', copyInfo );

	/**
	 * Scripts
	 */
	gulp.watch( config.scripts.watch || config.scripts.src, buildScripts ).on(
		'unlink',
		( deletedFile ) => {
			const basename = path.basename(
				deletedFile,
				path.extname( deletedFile )
			);

			const mirrorDeleteGlob =
				path.join( config.scripts.dest, basename ) + '.*';

			del( mirrorDeleteGlob );
		}
	);

	/**
	 * JS
	 */
	gulp.watch( config.js.watch || config.js.src, buildJS ).on(
		'unlink',
		( deletedFile ) => {
			const basename = path.basename(
				deletedFile,
				path.extname( deletedFile )
			);

			const mirrorDeleteGlob =
				path.join( config.js.dest, basename ) + '?(.min).js';

			del( mirrorDeleteGlob );
		}
	);

	/**
	 * CSS
	 */
	gulp.watch( config.css.watch || config.css.src, buildCSS ).on(
		'unlink',
		( deletedFile ) => {
			const basename = path.basename(
				deletedFile,
				path.extname( deletedFile )
			);

			const mirrorDeleteGlob =
				path.join( config.css.dest, basename ) + '?(-rtl)?(.min).css';

			del( mirrorDeleteGlob );
		}
	);

	/**
	 * POT
	 */
	gulp.watch( config.pot.watch || config.pot.src, buildPOT );
};

/**
 * Export tasks
 */

exports.info = copyInfo;

exports.scripts = buildScripts;

exports.js = buildJS;

exports.css = buildCSS;

exports.pot = buildPOT;

exports.build = buildAll;

exports.watch = watchChanges;

exports.default = gulp.series( buildAll, watchChanges );

exports.zip = gulp.series( buildAll, zipFiles );
