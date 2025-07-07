const { src, dest } = require("gulp");
const clean = require("gulp-dest-clean");

module.exports = function del(cb) {
  return clean("build/*");
};
