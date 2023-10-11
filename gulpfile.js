const path = require("path");

require("dotenv").config({ path: ".env.development" });
const gulp = require("gulp");
const sass = require("gulp-sass")(require("sass"));
const autoprefixer = require("gulp-autoprefixer");
const browserSync = require("browser-sync").create();

function compilaSass() {
  return gulp
    .src("assets/css/scss/**/*.scss")
    .pipe(sass())
    .pipe(
      autoprefixer({
        cascade: false,
      })
    )
    .pipe(gulp.dest(path.join(__dirname, "assets", "css")))
    .pipe(browserSync.stream());
}

gulp.task("sass", compilaSass);

function browser() {
  const { URL_LOCAL } = process.env;
  if (URL_LOCAL) {
    browserSync.init({
      proxy: URL_LOCAL,
      open: false,
    });
  } else {
    console.log(
      'Você não forneceu a "URL_LOCAL", browser-sync não será iniciado!'
    );
  }
}

gulp.task("browser-sync", browser);

function watch() {
  compilaSass();
  gulp.watch("assets/css/scss/**/*.scss", compilaSass);
}

gulp.task("watch", watch);

gulp.task("default", gulp.parallel("watch", "browser-sync"));

process.on("exit", function () {
  gulp.removeAllListeners();
  browserSync.exit();
});
