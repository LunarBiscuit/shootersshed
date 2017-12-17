'use strict';

var gulp = require('gulp'),
    sass = require('gulp-sass'),
    browserSync = require('browser-sync'),
    autoprefixer = require('gulp-autoprefixer'),
    uglify = require('gulp-uglify'),
    jshint = require('gulp-jshint'),
    header  = require('gulp-header'),
    rename = require('gulp-rename'),
    cssnano = require('gulp-cssnano'),
    pkg = require('./package.json'),
    tcfg = require('./template-config.json'),
    extReplace = require('gulp-ext-replace'),
    handlebars = require('gulp-compile-handlebars'),
    mainBowerFiles = require('main-bower-files'),
    using = require('gulp-using'),
    wiredep = require('wiredep').stream;



var banner = [
  '/*!\n' +
  ' * <%= pkg.name %>\n' +
  ' * <%= pkg.title %>\n' +
  ' * <%= pkg.url %>\n' +
  ' * @author <%= pkg.author %>\n' +
  ' * @version <%= pkg.version %>\n' +
  ' * Copyright ' + new Date().getFullYear() + '. <%= pkg.license %> licensed.\n' +
  ' */',
  '\n'
].join('');

gulp.task('css', function () {
    return gulp.src('src/scss/style.scss')
    .pipe(sass({errLogToConsole: true}))
    .pipe(autoprefixer('last 4 version'))
    .pipe(gulp.dest('dist/assets/css'))
    .pipe(cssnano())
    .pipe(rename({ suffix: '.min' }))
    .pipe(header(banner, { pkg : pkg }))
    .pipe(gulp.dest('dist/assets/css'))
    .pipe(browserSync.reload({stream:true}));
});

gulp.task('js',function(){
  gulp.src('src/js/scripts.js')
    .pipe(jshint('.jshintrc'))
    .pipe(jshint.reporter('default'))
    .pipe(header(banner, { pkg : pkg }))
    .pipe(gulp.dest('dist/assets/js'))
    .pipe(uglify())
    .pipe(header(banner, { pkg : pkg }))
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest('dist/assets/js'))
    .pipe(browserSync.reload({stream:true, once: true}));
});

gulp.task('bower', function()
{
    // TODO concat all the bower components into a single css and js file then push them across and inject after
    return gulp.src(mainBowerFiles())
      .pipe(gulp.dest('dist/assets/components'));
});

gulp.task('inject', function()
{

  // inject bower deps into index.handlebars OLD: 'src/pages/partials/*.handlebars'

	return gulp.src('dist/*.html')
		.pipe(using())
		.pipe(wiredep({
      directory: 'dist/assets/bower_components'
		}))
    .pipe(gulp.dest('dist'));

});

gulp.task('html', function(){

  // Build Handlebars into HTML
  var templateData = tcfg,
	options = {
		batch : ['./src/pages/partials'],
		helpers : {
			capitals : function(str){
				return str.toUpperCase();
			}
		}
	};

	return gulp.src('src/pages/*.handlebars')
		.pipe(handlebars(templateData, options))
		.pipe(extReplace('.html'))
		.pipe(gulp.dest('dist'));

});

gulp.task('build-html', ['html'], function()
{
    // Inject the deps
    return gulp.start('inject');
});

gulp.task('browser-sync', function() {
    browserSync.init(null, {
        server: {
            baseDir: 'dist'
        }
    });
});
gulp.task('bs-reload', function () {
    browserSync.reload();
});

gulp.task('default', ['css', 'js', 'build-html', 'browser-sync'], function () {
    gulp.watch('src/scss/*/*.scss', ['css']);
    gulp.watch('src/js/*.js', ['js']);
    gulp.watch('src/pages/**/*.handlebars', ['build-html']);
    gulp.watch('dist/*.html', ['bs-reload']);
    gulp.watch('dist/assets/css/*.css', ['bs-reload']);
});
