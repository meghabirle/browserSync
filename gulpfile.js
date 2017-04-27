/* global -$ */
'use strict';
// generated on 2017-04-21 using generator-modern-frontend 0.2.9
// var fs = require('fs');
// var path = require('path');

var gulp = require('gulp');
var $ = require('gulp-load-plugins')();
var browserSync = require('browser-sync');
var reload = browserSync.reload;
// var minify = require('gulp-minify');
var concat = require('gulp-concat');
var minify = require('gulp-minify');

// var through2 = require('through2');
// var browserify = require('browserify');
/*var rjs = require('gulp-requirejs');*/

var isDevelopment = (process.env.ENVIRONMENT !== "production");

gulp.task('stylesheet', function () {
  return gulp.src('css/**/*.css')
    .pipe(concat('styles.css'))
    .pipe($.if(isDevelopment, $.sourcemaps.init()))
    .on('error', function (error) {
      console.log(error.stack);
      this.emit('end');
    })
    .pipe($.postcss([
      require('autoprefixer-core')({browsers: ['last 1 version']})
    ]))
    .pipe($.if(isDevelopment, $.sourcemaps.write()))
    .pipe(minify())
    .pipe(gulp.dest('build/css'))
    .pipe(reload({stream: true}));
});

gulp.task('javascript', function () {
  return gulp.src('js/**/*.js')
    /*.pipe(through2.obj(function (file, enc, next){ // workaround for https://github.com/babel/babelify/issues/46
      browserify({
        entries: file.path,
        debug: isDevelopment
      }).bundle(function(err, res){
        if (err) { return next(err); }

        file.contents = res;
        next(null, file);
      });
    }))
    .on('error', function (error) {
      console.log(error.stack);
      this.emit('end');
    })  
    .pipe($.if(isDevelopment, $.sourcemaps.init({loadMaps: true})))*/

    .pipe($.if(isDevelopment, $.sourcemaps.write()))
    .pipe(minify())
    .pipe(gulp.dest('build/js'));
});

gulp.task('serve', ['stylesheet', 'javascript'], function () {
  browserSync.init({
    proxy: "http://localhost/my-maid"
});
  // watch for changes
   
   gulp.watch([
     'application/views/**/*.php'
   ]).on('change', reload);
   gulp.watch(['css/*.css'], ['stylesheet']).on('change', reload);
   gulp.watch('js/**/*.{js,jsx}', ['javascript']).on('change', reload);
   
});

gulp.task('default', ['watch','stylesheet','javascript','browser-sync'], function () {
  // gulp.start('/');
});
