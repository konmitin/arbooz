const { src, dest } = require("gulp");
const uglify = require("gulp-uglify-es").default;
const concat = require("gulp-concat");
const map = require("gulp-sourcemaps");
const bs = require("browser-sync");
const multiDest = require("gulp-multi-dest");

module.exports = function components_js() {
  return src(["src/components/**/*.js"])
    .pipe(uglify())
    .pipe(concat("main.min.js"))
    .pipe(dest("build/js/"))
    .pipe(bs.stream());
};
