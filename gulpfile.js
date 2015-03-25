var gulp = require("gulp"),
	sass = require("gulp-sass"),
	minifycss = require("gulp-minify-css"),
	rename = require("gulp-rename"),
	autoprefixer = require("gulp-autoprefixer"),
	uglify = require("gulp-uglify"),
	concat = require("gulp-concat"),
	plumber = require("gulp-plumber"),
	notify = require("gulp-notify"),
	connect = require("gulp-connect-php");

var onError = notify.onError({
	title: "Your SASS is broken!",
	subtitle: "<%= file %> did not compile!",
	message: "<%= error.message %>"
});

function compileSass (name, pathToSass) {
	gulp.src(pathToSass + "/" + name + ".sass")
		.pipe(plumber({
			errorHandler: onError
		}))
		.pipe(sass({
			loadPath: process.cwd() + pathToSass,
			style: "nested",
			indentedSyntax: true
		}))
		.pipe(autoprefixer({
			browsers: ["last 20 versions", "> 1%"],
			cascade: false
		}))
		.pipe(gulp.dest("assets/css"))
		.pipe(rename({suffix: ".min"}))
		.pipe(minifycss())
		.pipe(gulp.dest("assets/css"))
		.pipe(notify(name + " successfully compiled!"));
}

gulp.task("start-php", function() {
	connect.server({
		port: 8001
	});
});

gulp.task("alerts", function () {
	compileSass("alerts", "assets/css/_inc/alerts")
});

gulp.task("common", function () {
	compileSass("common", "assets/css/_inc/common")
});

gulp.task("forms", function () {
	compileSass("forms", "assets/css/_inc/forms")
});

gulp.task("labels", function () {
	compileSass("labels", "assets/css/_inc/labels")
});

gulp.task("litchi", function () {
	compileSass("litchi", "assets/css/_inc")
});

gulp.task("uglify", function () {
	gulp.src("assets/js/include/*.js")
		.pipe(concat("litchi.js"))
		.pipe(uglify("litchi.js"))
		.pipe(gulp.dest("assets/js"))
		.pipe(notify("JavaScript successfully compiled!"));
});

gulp.task("default", ["start-php"], function () {
	gulp.watch("assets/css/_inc/alerts/**/*.sass", ["alerts"]);
	gulp.watch("assets/css/_inc/common/**/*.sass", ["common"]);
	gulp.watch("assets/css/_inc/forms/**/*.sass", ["forms"]);
	gulp.watch("assets/css/_inc/labels/**/*.sass", ["labels"]);
	gulp.watch("assets/css/_inc/**/*.sass", ["litchi"]);

	gulp.watch("assets/js/include/*.js", ["uglify"]);
});