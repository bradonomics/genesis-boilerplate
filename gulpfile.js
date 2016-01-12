//* Project name
// var projectName = geneplate;


//* Plugins
var gulp         = require('gulp'),
    sass         = require('gulp-ruby-sass'),
    prefix       = require('gulp-autoprefixer'),
    minifycss    = require('gulp-minify-css'),
    concat       = require('gulp-concat'),
    uglify       = require('gulp-uglify'),
    browserSync  = require('browser-sync');


//* Setup new project directories with "npm install --save-dev gulp gulp-ruby-sass gulp-autoprefixer gulp-minify-css gulp-concat gulp-uglify browser-sync"


//* Styles
gulp.task('css', function() {
  return sass('./dev/scss/*.scss')
    .on('error', function(err) {
      console.error('Error! Something went wrong compiling your SCSS files.', err.message);
    })
    .pipe(prefix())
    .pipe(minifycss())
    .pipe(gulp.dest('./'))
});


//* Scripts
gulp.task('vendorjs', function() {
  return gulp.src('./dev/js/vendor/*.js')
    .pipe(concat('vendor.js'))
    .pipe(uglify())
    .pipe(rename({
      basename: "vendor",
      suffix: '.min'
    }))
    .pipe(gulp.dest('./js/'));
});

gulp.task('themejs', function() {
  return gulp.src('./dev/js/*.js')
    .pipe(concat('main.js'))
    .pipe(uglify())
    .pipe(rename({
      basename: "main",
      suffix: '.min'
    }))
    .pipe(gulp.dest('./js'));
});


//* Browser Sync
gulp.task('browser-sync', function() {
  var files = [
    './*.php'
  ];
  browserSync.init(files, {
    // proxy: "local.dev/" + projectName
    proxy: "local.dev/geneplate"
  });
});


// Watch Task (default)
gulp.task('default', ['css', 'themejs', 'images', 'browser-sync'], function() {
  gulp.watch('./dev/images/*', ['images', browserSync.reload]);
  gulp.watch('./dev/scss/*.scss', ['css', browserSync.reload]);
  gulp.watch('./dev/js/*.js', ['themejs', browserSync.reload]);
});
