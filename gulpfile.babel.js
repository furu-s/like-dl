import gulp from 'gulp';
import sass from 'gulp-sass'
import webpack from 'gulp-webpack';
import webpackConfig from './webpack.config.js';

gulp.task('start', () => {
  gulp.watch('public/src/**/*.*', ['webpack']);
  gulp.watch('public/sass/**/*.scss', ['sass']);
});

gulp.task('sass', () => {
  return gulp.src('public/sass/**/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('css/'));
});

gulp.task('webpack', () => {
  return gulp.src('public/src/index.jsx')
   .pipe(webpack(webpackConfig))
   .pipe(gulp.dest('js/'));
});
