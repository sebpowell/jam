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

	gulp.src("assets/css/include/screen.sass")
		.pipe(sass({
			loadPath: process.cwd() + "/assets/css/include",
			style: "nested"
		}))
		.pipe(autoprefixer("last 2 version", "> 1%"))
		.pipe(gulp.dest("assets/css"))
		.pipe(notify("SASS successfully compiled!"));

});

gulp.task("uglify", function() {

	gulp.src("assets/js/include/*.js")
		.pipe(concat("app.js"))
		.pipe(uglify("app.js"))
		.pipe(gulp.dest("assets/js"))
		.pipe(notify("JavaScript successfully compiled!"));

});

gulp.task("watch", function() {

	gulp.watch("assets/css/include/**/*.sass", ["sass"]);
	gulp.watch("assets/js/include/*.js", ["uglify"]);

});


/*
 * Default Gulp task
 */
gulp.task("default", function() {
	gulp.start("watch");
});