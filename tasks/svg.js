const { src, dest } = require("gulp");
const changed = require("gulp-changed");

const bs = require("browser-sync");

module.exports = function svg() {
  return src("src/assets/img/**/*.svg")
    .pipe(changed("build/img"))
    .pipe(dest("build/img/"))
    .pipe(bs.stream());
};
