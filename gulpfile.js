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

	gulp.src("www/assets/css/include/screen.sass")
		.pipe(sass({
			loadPath: process.cwd() + "/www/assets/css/include",
			style: "nested"
		}))
		.pipe(autoprefixer("last 2 version", "> 1%"))
		.pipe(gulp.dest("www/assets/css"))
		.pipe(notify("SASS successfully compiled!"));

});

gulp.task("uglify", function() {

	gulp.src("www/assets/js/include/*.js")
		.pipe(concat("app.js"))
		.pipe(uglify("app.js"))
		.pipe(gulp.dest("www/assets/js"))
		.pipe(notify("JavaScript successfully compiled!"));

});

gulp.task("watch", function() {

	gulp.watch("www/assets/css/include/**/*.sass", ["sass"]);
	gulp.watch("www/assets/js/include/*.js", ["uglify"]);

});


/*
 * Default Gulp task
 */
gulp.task("default", function() {
	gulp.start("watch");
});