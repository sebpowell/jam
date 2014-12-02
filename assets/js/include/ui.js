$(document).ready(function () {

	// Do not remove this bit, as it fixes transition bugs.
	$("body").removeClass("preload");

	$("#mc-embedded-subscribe-form").submit(function (e) {
		var $this = $(this);

		if (e) e.preventDefault();

		$.ajax({
			type: "GET",
			url: "http://london.us9.list-manage.com/subscribe/post-json?u=7f799244738e8b8558a646378&id=6c81011ad7&c=?",
			data: $this.serialize(),
			cache: false,
			async: true,
			dataType: 'json',
			contentType: "application/json; charset=utf-8",
			error: function (err) {
				$(".alert.error").removeClass("hide").html(data.msg);
				alert("Could not connect to the registration server. Please try again later.");
			},
			success: function (data) {
				if (data.result != "success") {
					$(".alert.warning").removeClass("hide").html(data.msg);
				} else {
					$(".alert.success").removeClass("hide").html(data.msg);
				}
			}
		});
	});

});