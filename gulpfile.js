var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');

gulp.task('minifyConfig', function() {
  gulp.src('config/config.js')
    .pipe(concat('config.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest('config'));
});
