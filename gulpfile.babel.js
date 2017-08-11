import gulp from 'gulp';
import webpack from 'gulp-webpack';
import webpackConfig from './webpack.config.js';

gulp.task('start', () => {
    gulp.watch('public/src/**/*.*', ['webpack']);
});

gulp.task('webpack', () => {
    return gulp.src('public/src/index.jsx')
       .pipe(webpack(webpackConfig))
       .pipe(gulp.dest('js/'));
});
