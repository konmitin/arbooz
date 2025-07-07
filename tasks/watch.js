const { watch, parallel, series } = require("gulp");

module.exports = function watching() {
  watch("src/**/*.html", parallel("html"));
  watch("src/**/*.php", parallel("php"));
  watch("src/scss/**/*.scss", parallel("style"));
  watch("src/components/**/*.scss", parallel("style"));
  watch("src/components/**/*.js", parallel("dev_js"));
  watch("src/js/**/*.js", parallel("dev_js"));
  watch("src/assets/**/*.json", parallel("html"));
  watch("src/assets/img/**/*.+(png|jpg|jpeg|gif|svg|ico)", parallel("rastr"));
  watch("build/img/**/*.+(png|jpg|jpeg)", parallel("webp"));
  watch("src/assets/fonts/**/*.ttf", series("ttf"));
};
