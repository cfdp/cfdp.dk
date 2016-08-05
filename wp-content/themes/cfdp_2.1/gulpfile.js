'use strict';

var gulp = require('gulp'),
    sass = require('gulp-sass'),
    browserSync = require('browser-sync').create();

// Static Server + watching scss/html files
gulp.task('serve', ['sassfiles', 'stylecss'], function() {

  browserSync.init({
    proxy: "cfdp.dev",
    notify: false
  });

  gulp.watch(["sass/*.scss", '!sass/style.scss'], ['sassfiles']);
  gulp.watch(['sass/style.scss'], ['stylecss']);
  gulp.watch(["*.php"]).on('change', browserSync.reload);
});

// Compile sass into CSS & auto-inject into browsers
gulp.task('sassfiles', function() {
  return gulp.src(['sass/*.scss', '!sass/style.scss'])
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest("css"))
    .pipe(browserSync.stream());
});

gulp.task('stylecss', function() {
  return gulp.src("sass/style.scss")
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest("./"))
    .pipe(browserSync.stream());
});

gulp.task('default', ['serve']);