const { src, dest } = require("gulp");

module.exports = function files_js() {
  return src(["src/.htaccess"]).pipe(dest("build/"));
};
