/*-------------------------------------
|
| Gulp
| a. Mitch Gohman
| v. 1.0.0
| d. 2016.12.10
|
-------------------------------------*/
/*-------------------------------------
| Config
-------------------------------------*/
// Assets e.g. css, js, images and fonts
var cssDir = 'public_html/wp-content/themes/my-theme/assets/css/';
var jsDir = 'public_html/wp-content/themes/my-theme/assets/js/';

// Which Git Server (e.g. production || staging)
var remoteRepo = 'staging';

/*-------------------------------------
| Sass Minification
| https://github.com/dlmanning/gulp-sass
| same options as node-sass
| https://github.com/sass/node-sass#options
-------------------------------------*/
var sassOptions = {
	errLogToConsole: true,
	outputStyle: 'expanded'
};

/*-------------------------------------
| Install Dependencies - NPM

npm install gulp  --save-dev
npm install gulp-watch --save-dev
npm install gulp-sass  --save-dev
npm install gulp-autoprefixer  --save-dev
npm install gulp-sourcemaps  --save-dev
npm install gulp-if  --save-dev
npm install gulp-uglify  --save-dev
npm install gulp-cssnano  --save-dev
npm install run-sequence  --save-dev
npm install gulp-rename  --save-dev
npm install gulp-git  --save-dev
npm install yargs  --save-dev
npm install gulp-plumber --save-dev
npm install gulp-connect-php --save-dev

-------------------------------------*/

/*-------------------------------------
| Dependencies
-------------------------------------*/
// What would life be without this one?
var gulp = require('gulp');

// repeating tasks
var gulpWatch = require('gulp-watch');

// CSS
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var cssnano = require('gulp-cssnano');

// JS
var uglify = require('gulp-uglify');
var plumber = require('gulp-plumber'); //does soemthing with the js in the minification process.

// GIT
var git = require('gulp-git');

// Webserver
var connect = require('gulp-connect-php');

// Shared
var sourcemaps = require('gulp-sourcemaps');
var gulpIf = require('gulp-if'); //conditions
var runSequence = require('run-sequence'); //run several gulp commands in a sequence
var rename = require('gulp-rename'); // rename a string/filename

//capture argument flags and use in gulp commands (e.g. -m, -al) :: converts to argv obj var (e.g. argv.m, argv.al)
var argv = require('yargs').argv;

/*-------------------------------------
| Convert SCSS to CSS, Sourcemaps, Autoprefixer, and Minify (uglify)
| More on this :: https://www.sitepoint.com/simple-gulpy-workflow-sass/
-------------------------------------*/
gulp.task('sassy', function(){
	// return gulp.src(config.app + config.assets + '/css/styles.scss') // Get source files with gulp.src
	return gulp
		.src(cssDir + '**/*.scss') // Glob to get all files ending with .scss
	    .pipe(sourcemaps.init()) //Start before others - got to initialize it so it includes all dependencies...
		.pipe( sass( sassOptions ).on('error', sass.logError) ) // Converts Sass to CSS with gulp-sass
		.pipe( autoprefixer({
			browsers: ['last 2 versions'],
			cascade: false
		}) )
		.pipe(gulpIf(['*.css','!*.map'], cssnano())) //minification
        .pipe(rename({suffix: '.min'}))
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(cssDir)); // Outputs the file in the destination folder
});

/*-------------------------------------
| Convert js to minified version with sourcemap
|
| exclued js https://codedump.io/share/ieThfYNgAtmG/1/how-do-i-exclude-only-minjs-files-in-gulp-task-while-staying-in-same-directory
-------------------------------------*/
gulp.task('jsmin', function(){
	return gulp
		.src([jsDir + "*.js", "!" + jsDir + "*.min.js"]) //only unminified js files.
		.pipe(sourcemaps.init())
		.pipe(plumber())
		.pipe(gulp.dest(jsDir)) // save .js
		.pipe(uglify({ preserveComments: 'license' }))
		.pipe(rename({ extname: '.min.js' }))
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(jsDir)); // save .min.js
});

/*-------------------------------------
| Gulp Git
-------------------------------------*/
gulp.task('init', function() {
	console.log(argv.m);
});

gulp.task('add', function() {
	console.log('adding...');
	return gulp.src('.')
		.pipe(git.add());
});

gulp.task('commit', function() {
	console.log('commiting');
	if (argv.m)
	{
		return gulp.src('.')
			.pipe(git.commit(argv.m));
	}
});

gulp.task('push', function(){
	console.log('pushing...');
	git.push(remoteRepo, 'master', {args: " -u"}, function (err) {
		if (err) throw err;
	});
});

gulp.task('gitsend', function() {
	runSequence('add', 'commit', 'push');
});

/*-------------------------------------
| Webserver
-------------------------------------*/
gulp.task('serve', function() {
	connect.server({
		base: './public_html',
		port: 8000,
		hostname: 'localhost',
		open: true
	});
});

/*-------------------------------------
| Looping - repeating task using .watch.
-------------------------------------*/
gulp.task('watch', function() {
	gulp.watch(cssDir + '**/*.scss', ['sassy']);
	gulp.watch(jsDir + '*.js', ['jsmin']);
});

/*-------------------------------------
| Default
| if you name a task default, the gulp command will execute that command
| 	e.g. $ gulp vs $ gulp nameOfTaskToRun
-------------------------------------*/
gulp.task('default', ['sassy', 'jsmin', 'serve', 'watch'], function() {
	// console.log('done');
});

