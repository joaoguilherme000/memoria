const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));

function compileSass() {
  return gulp.src('scss/**/*.scss') // Modifique o padrão de seleção conforme necessário
             .pipe(sass().on('error', sass.logError))
             .pipe(gulp.dest('css'));
}

exports.default = compileSass;