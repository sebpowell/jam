/*
 * Init Gulp dependencies
 */
var gulp =
	require("gulp"),
	connect = require("gulp-connect-php");

/*
 * Gulp tasks
 */
gulp.task("start-php", function() {
	connect.server({
		port: 8001
	});
});

gulp.task("default", ["start-php"]);