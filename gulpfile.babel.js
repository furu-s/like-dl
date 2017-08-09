import gulp from 'gulp';
import webpack from 'gulp-webpack';
import webpackConfig from './webpack.config.js';

gulp.task('start', () => {
    gulp.watch('src/index.js', ['webpack']);
});

gulp.task('webpack', () => {
    return gulp.src('src/index.js')
       .pipe(webpack(webpackConfig))
       .pipe(gulp.dest('dist/'));
});