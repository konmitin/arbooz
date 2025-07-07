const gulp = require("gulp");

const requireDir = require("require-dir");
const tasks = requireDir("./tasks");

// import gulp from "gulp";

// import requireDir from "require-dir";
// const tasks = requireDir('./tasks');

// exports.del = tasks.del;
exports.style = tasks.style;
exports.build_js = tasks.build_js;
exports.dev_js = tasks.dev_js;
exports.libs_js = tasks.libs_js;
exports.components_js = tasks.components_js;
// exports.files_js = tasks.files_js;
exports.html = tasks.html;
exports.php = tasks.php;
exports.rastr = tasks.rastr;
exports.svg = tasks.svg;
exports.webp = tasks.webp;
exports.ttf = tasks.ttf;
exports.bs_html = tasks.bs_html;
exports.bs_php = tasks.bs_php;
exports.watch = tasks.watch;

exports.default = gulp.parallel(
  exports.style,
  exports.dev_js,
  exports.components_js,
  exports.rastr,
  exports.svg,
  exports.webp,
  exports.ttf,
  exports.html,
  exports.bs_html,
  exports.watch
);

exports.dev_php = gulp.parallel(
  // exports.del,
  exports.style,
  // exports.files_js,
  exports.dev_js,
  exports.libs_js,
  exports.rastr,
  exports.svg,
  exports.webp,
  exports.ttf,
  exports.php,
  exports.bs_php,
  exports.watch
);

exports.build = gulp.parallel(
  exports.style,
  exports.build_js,
  exports.rastr,
  exports.svg,
  exports.ttf,
  exports.html,
  exports.php
);
