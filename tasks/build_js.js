const { src, dest } = require("gulp");
const uglify = require("gulp-uglify-es").default;
const concat = require("gulp-concat");
const map = require("gulp-sourcemaps");
const babel = require("gulp-babel");

module.exports = function build_js() {
  return src(["src/js/_main.js", "src/js/*.js"])
    .pipe(map.init())
    .pipe(uglify())
    .pipe(
      babel({
        presets: ["@babel/preset-env"],
      })
    )
    .pipe(concat("main.min.js"))
    .pipe(dest("build/js/"));
};
