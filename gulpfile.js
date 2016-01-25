//* Project name
var projectName = "geneplate";


//* Plugins
var gulp         = require('gulp'),
    sass         = require('gulp-ruby-sass'),
    prefix       = require('gulp-autoprefixer'),
    minifycss    = require('gulp-cssnano'),
    concat       = require('gulp-concat'),
    uglify       = require('gulp-uglify'),
    rename       = require('gulp-rename'),
    browserSync  = require('browser-sync');


//* Setup new WordPress project with "npm install --save-dev gulp gulp-ruby-sass gulp-autoprefixer gulp-cssnano gulp-concat gulp-uglify gulp-rename browser-sync"

//* Setup new PSD to HTML/CSS project with "npm install --save-dev gulp gulp-ruby-sass gulp-autoprefixer gulp-cssnano browser-sync"
//* If you need to work on JavaScript during the PSD extraction, use the "WordPress project" setup above.


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
    proxy: "local.dev/" + projectName
  });
});


//* Browser Sync for Sass
gulp.task('watch', ['css'], function() {
  browserSync.init({
    server: "./"
  });
  gulp.watch("./dev/scss/*.scss", ['css', browserSync.reload]);
  gulp.watch("./*.html").on('change', browserSync.reload);
});


// Watch Task (default)
gulp.task('default', ['css', 'themejs', 'browser-sync'], function() {
  gulp.watch('./dev/scss/*.scss', ['css', browserSync.reload]);
  gulp.watch('./dev/js/*.js', ['themejs', browserSync.reload]);
});
