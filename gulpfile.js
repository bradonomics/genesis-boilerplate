//* Project name
var projectName = "geneplate";


//* Plugins
var gulp         = require('gulp'),
    sass         = require('gulp-sass'),
    prefix       = require('gulp-autoprefixer'),
    minifycss    = require('gulp-cssnano'),
    concat       = require('gulp-concat'),
    uglify       = require('gulp-uglify'),
    rename       = require('gulp-rename'),
    browserSync  = require('browser-sync');

//* Sass Options
var sassOptions = {
  errLogToConsole: true,
  outputStyle: 'expanded'
};


/*  Setup new WordPress project type this in the terminal:
 *  1. `npm init`
 *  2. `npm install --save-dev gulp gulp-sass gulp-autoprefixer gulp-cssnano gulp-concat gulp-uglify gulp-rename browser-sync`
 */

/*  Setup new PSD to HTML/CSS project type this in the terminal:
 *  `npm install --save-dev gulp gulp-sass gulp-autoprefixer gulp-cssnano browser-sync`
 *  NOTE: If you need to work on JavaScript during the PSD extraction, use the "WordPress project" setup above.
 */


//* Styles
gulp.task('css', function () {
  return gulp.src('./dev/scss/*.*')
    .pipe(sass(sassOptions).on('error', sass.logError))
    .pipe(prefix())
    .pipe(minifycss())
    .pipe(gulp.dest('./'));
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
    .pipe(gulp.dest('./js'));
});

gulp.task('themejs', function() {
  return gulp.src('./dev/js/*.js')
    .pipe(concat('main.js'))
    .pipe(uglify())
    .pipe(rename({
      basename: "theme",
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
    proxy: "localhost/" + projectName
  });
});


//* Browser Sync for Sass
gulp.task('watch', ['css'], function() {
  browserSync.init({
    server: "./"
  });
  gulp.watch("./dev/scss/*.*", ['css', browserSync.reload]);
  gulp.watch("./*.html").on('change', browserSync.reload);
});


// Watch Task (default)
gulp.task('default', ['css', 'themejs', 'browser-sync'], function() {
  gulp.watch('./dev/scss/*.*', ['css', browserSync.reload]);
  gulp.watch('./dev/js/*.js', ['themejs', browserSync.reload]);
});
