$(document).ready(function() {
	$("body").prepend($('<div id="debug-grid" style="height: ' + $("body").outerHeight() + 'px"></div>'));

	$("body").dblclick(function() {
		$("#debug-grid").toggleClass("show");
	});
});