// Implementation of Gulp:
//
// sudo npm install gulp -g
// sudo npm install gulp
// sudo npm install gulp-ruby-sass gulp-autoprefixer gulp-uglify gulp-concat gulp-notify


/*
 * Init Gulp dependencies
 */
var gulp =
	require("gulp"),
	sass = require("gulp-ruby-sass"),
	autoprefixer = require("gulp-autoprefixer"),
	uglify = require("gulp-uglify"),
	concat = require("gulp-concat"),
	notify = require("gulp-notify");


/*
 * Gulp tasks
 */
gulp.task("sass", function() {

	gulp.src("css/include/screen.sass")
		.pipe(sass({
			loadPath: process.cwd() + "/css/include",
			style: "nested"
		}))
		.pipe(autoprefixer("last 2 version", "> 1%"))
		.pipe(gulp.dest("css"))
		.pipe(notify("SASS successfully compiled!"));

});

gulp.task("uglify", function() {

	gulp.src("js/include/*.js")
		.pipe(concat("app.js"))
		.pipe(uglify("app.js"))
		.pipe(gulp.dest("js"))
		.pipe(notify("JavaScript successfully compiled!"));

});

gulp.task("watch", function() {

	gulp.watch("css/include/**/*.sass", ["sass"]);
	gulp.watch("js/include/*.js", ["uglify"]);

});


/*
 * Default Gulp task
 */
gulp.task("default", function() {
	gulp.start("watch");
});
