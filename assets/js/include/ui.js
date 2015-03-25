$(document).ready(function () {

	// Do not remove this bit, as it fixes transition bugs.
	$("body").removeClass("preload");

	function openModal(timeout) {
		$(".modal").toggleClass("is-hidden");
		setTimeout(function() {
			$(".modal").toggleClass("show");
		}, timeout);
	}

	function closeModal(timeout) {
		$(".modal").toggleClass("show");
		setTimeout(function() {
			$(".modal").toggleClass("is-hidden");
		}, timeout);
	}

	$("#ourStory").click(function() {
		openModal(50);
	});

	$(".modal, .close-modal").click(function() {
		closeModal(450);
	});

	$(".modal-content").click(function(e) {
		e.stopPropagation();
	});

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
				$(".alert.error").addClass("active").html(data.msg);

				setTimeout(function () {
					$(".alert.error").removeClass("active");
				}, 2500);
			},
			success: function (data) {
				if (data.result != "success") {
					$(".alert.warning").addClass("active").html(data.msg);

					setTimeout(function () {
						$(".alert.warning").removeClass("active");
					}, 2500);
				} else {
					$(".alert.success").addClass("active").html(
						"Almost done! To confirm your suscription, please click the link in the email we've just sent you."
					);

					setTimeout(function () {
						$(".alert.success").removeClass("active");
					}, 2500);
				}
			}
		});
	});

	// This function removes or adds the .transparent class to main navigation
	// depending on its offset from the top of a page.
	var changeNavMain = function () {
		var scrollTop = $("#measureScroll").scrollTop();

		if (scrollTop > (100)) {
			$("#glyph").addClass("active");
		} else {
			$("#glyph").removeClass("active");
		}
	};

	changeNavMain();

	$("#measureScroll").scroll(function () {
		changeNavMain();
	});

});