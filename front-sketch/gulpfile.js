'use strict';
 
const gulp = require('gulp'),
      sass = require('gulp-sass'),
      livereload = require('gulp-livereload');
 
gulp.task('sass', function () {
  return gulp.src('./sass/**/*.scss')
    .pipe(sass.sync().on('error', sass.logError))
    .pipe(gulp.dest('./css'))
    .pipe(livereload());
});

gulp.task('html', function() {
  gulp.src('./*.html')
    .pipe(livereload());
});
 
gulp.task('watch', function () {
  livereload.listen();
  gulp.watch('sass/**/*.scss', ['sass']);
  gulp.watch('./*.html', ['html']);
});

gulp.task('default', ['sass']);