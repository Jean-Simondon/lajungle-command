'use strict';

var gulp = require('gulp'),
plugins = require('gulp-load-plugins')({ camelize: true }),
del = require('del'),
babel = require('gulp-babel'),
browserSync = require('browser-sync');

// Styles
gulp.task('styles', function () {
	return gulp.src('resources/assets/sass/*.scss')
	.pipe(plugins.sass({outputStyle: 'compressed'}).on('error', plugins.sass.logError))
	.pipe(gulp.dest('resources/assets/css/'))
	.pipe(plugins.notify({ message: 'Styles task complete' }));
});

// Plugins
gulp.task('plugins', function() {
    return gulp.src([
        'resources/assets/js/vendor/what-input/dist/what-input.min.js',
        'resources/assets/js/vendor/enquire/dist/enquire.min.js',
        'resources/assets/js/vendor/slick-carousel/slick/slick.min.js',
        'resources/assets/js/vendor/modaal/dist/js/modaal.min.js',
        'resources/assets/js/vendor/matchHeight/dist/jquery.matchHeight-min.js',
        'resources/assets/js/vendor/jquery.easing/js/jquery.easing.min.js',
		'resources/assets/js/vendor/jssocials/dist/jssocials.min.js',
		'resources/assets/js/vendor/gsap/dist/gsap.min.js',
		'resources/assets/js/vendor/gsap/dist/ScrollTrigger.min.js',
    ])
	.pipe(plugins.concat('plugins.js'))
	.pipe(gulp.dest('resources/assets/js/build'))
	.pipe(plugins.rename({ suffix: '.min' }))
    .pipe(plugins.uglify().on('error', function(e){
        console.log(e);
     }))
	.pipe(gulp.dest('resources/assets/js'))
	.pipe(plugins.notify({ message: 'Plugins task complete' }));
});

// Scripts
gulp.task('scripts', function() {
	return gulp.src(['resources/assets/js/src/*.js'])
	//.pipe(plugins.jshint('.jshintrc'))
	//.pipe(plugins.jshint.reporter('default'))
	.pipe(plugins.concat('main.js'))
	.pipe(gulp.dest('resources/assets/js/build'))
    .pipe(plugins.rename({ suffix: '.min' }))
    .pipe(babel({presets: ['@babel/env']}))
    .pipe(plugins.uglify().on('error', function(e){
        console.log(e);
     }))
	.pipe(gulp.dest('resources/assets/js'))
	.pipe(plugins.notify({ message: 'Scripts task complete' }));
});

// Ajout de bouton dans la barre d'outils des champs RTE
gulp.task('tinymce', function () {
	return gulp.src(['resources/assets/js/tinymce/*.js'])
		// .pipe(plugins.jshint('.jshintrc'))
		// .pipe(plugins.jshint.reporter('default'))
		.pipe(plugins.concat('tinymce.js'))
		.pipe(gulp.dest('resources/assets/js/build'))
		.pipe(plugins.rename({
			suffix: '.min'
		}))
		.pipe(plugins.uglify())
		.pipe(gulp.dest('resources/assets/js'))
		.pipe(plugins.notify({
			message: 'Scripts task complete'
		}));
});

// Default
gulp.task('default', ['clean', 'styles', 'scripts', 'plugins', 'tinymce'], function() {});

// Watch
gulp.task('watch', ['styles', 'scripts', 'plugins', 'tinymce'], function() {
	browserSync.init({
		notify: false,
		proxy: "https://dci.lan",
		files: ['resources/assets/css/', 'resources/assets/js/src/*.js']
	});
	gulp.watch('resources/assets/sass/**/*.scss', ['styles', 'watch']);
	gulp.watch('resources/assets/js/src/*.js', ['scripts', 'watch']);
});
