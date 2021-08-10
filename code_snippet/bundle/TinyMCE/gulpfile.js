
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
