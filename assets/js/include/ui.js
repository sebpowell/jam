smoothScroll.init();

$(document).ready(function () {

	// Do not remove this bit, as it fixes transition bugs.
	$("body").removeClass("preload");

	$(".navigation-toggle").click(function() {
		$(this).toggleClass("close-navigation");
		$(".nav-links").toggleClass("show");
		$(".modal-backdrop").toggleClass("is-visible");
		$("#wrapper, #top-nav").toggleClass("show-nav");
	});

	function openModal(timeout, contentUrl) {
		$.get("/assets/content/modals/" + contentUrl, function (data) {
			$("#loadModalContent").html(data);

			$(".modal").toggleClass("is-hidden");
			setTimeout(function () {
				$(".modal").toggleClass("show");
			}, timeout);
		});
	}

	function closeModal(timeout) {
		$(".modal").toggleClass("show");
		setTimeout(function () {
			$(".modal").toggleClass("is-hidden");
		}, timeout);
	}

	$(".toggle-speaker-bio").click(function() {
		var filename = $(this).attr("id") + ".html";

		openModal(50, filename);
	});

	$(".toggle-our-story").click(function () {
		openModal(50, "manifesto.html");
	});

	$(".modal, .close-modal").click(function () {
		closeModal(450);
	});

	$(".modal-content").click(function (e) {
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

	// This function removes or adds the Book Tickets button when scrolling
	var displayBookTickets = function () {
		var scrollTop = $("body").scrollTop();

		if (scrollTop > (100)) {
			$("#bookTickets").addClass("active");
		} else {
			$("#bookTickets").removeClass("active");
		}
	};

	displayBookTickets();

	var sectionOurStoryOffset = $("#sectionStory").offset().top;
	var sectionSpeakersOffset = $("#sectionSpeakers").offset().top;
	var sectionTopicsOffset = $("#sectionTopics").offset().top;

	function activateNavItem(section) {
		var navItemId = "#navItem" + section;

		$("#top-nav li").removeClass("active");
		$("#top-nav li" + navItemId).addClass("active");
	}

	$(document).scroll(function () {
		displayBookTickets();

		// @TODO The +80 is a small hack, sorry. This whole section is very badly written, but
		// I don't have time to make it prettier. To revisit.
		var offset = $(this).scrollTop() + 80;

		if (offset > sectionTopicsOffset) {
			activateNavItem("Topics");
			return false;
		}

		if (offset > sectionSpeakersOffset) {
			activateNavItem("Speakers");
			return false;
		}

		if (offset > sectionOurStoryOffset) {
			activateNavItem("Story");
			return false;
		} else {
			$("#top-nav li").removeClass("active");
		}
	});

	//$("#top-nav li").click(function() {
	//	$(this).addClass("active");
	//});

});