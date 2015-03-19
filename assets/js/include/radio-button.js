// The radio buttons work by using a hidden input (that is a sibling of the radio buttons) that is updated whenever a
// non-disabled radio button is checked or unchecked.

$(function () {
	// Setup the default value for the radio buttons' hidden input
	$(".radio-button-holder").each(function () {
		updateRadioButtonsHiddenInputValue(this);
	});

	// Setup the behaviour when an element is clicked
	$(".radio-button:not(.disabled)").click(function () {
		toggleRadioButton(this);
	});

	// Setup the behaviour when space or enter is pressed
	$(".radio-button").keypress(function (e) {
		switch (e.keyCode || e.which) {
			case 32:
				toggleRadioButton(e.target);
				break;
			case 13:
				var form = $(e.target).closest('form');
				form.submit();
				break;
		}
	});

	setupRadioButtonTabbing();
});

function updateRadioButtonsHiddenInputValue(parent) {
	var valueOfFirstSelectedRadioButton = $(parent).find(".selected").first().attr("data-value");
	var radioButtonsHiddenInput = $(parent).find("input");
	radioButtonsHiddenInput.val(valueOfFirstSelectedRadioButton);
}

function toggleRadioButton(radioButtonElement) {
	// Change the radio buttons so only the selected one has the selected class
	$(radioButtonElement).parent().find(".radio-button").removeClass("selected");
	$(radioButtonElement).addClass("selected");

	updateRadioButtonsHiddenInputValue($(radioButtonElement).parent());
}

function setupRadioButtonTabbing() {
	$(".radio-button:not(.disabled)").each(function () {
		$(this).attr("tabIndex", 0);
	});
}