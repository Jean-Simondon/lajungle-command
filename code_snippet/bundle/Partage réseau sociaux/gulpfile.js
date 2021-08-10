// Plugins
gulp.task('plugins', function() {
    return gulp.src([

		'resources/assets/js/vendor/jssocials/dist/jssocials.min.js',

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
