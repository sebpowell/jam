$(document).ready(function () {

	// Do not remove this bit, as it fixes transition bugs.
	$("body").removeClass("preload");

	$("#theme-switch").click(function () {
		$("body").toggleClass("dark");

		var originalText = $(this).html();

		if (originalText == "Dark Theme") {
			$(this).html("Light Theme");
		} else {
			$(this).html("Dark Theme");
		}
	});

});