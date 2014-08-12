// This behaviour ensures that the custom - alternative, non-standard -
// radio buttons work as expected. There is a hidden input element located
// within parent element of every radio button, whose value gets updated
// depending on the currently selected radio button.
$(document).ready(function(){

	$(".radio-button").click(function() {

		// This gets the value of the radio button div that has been selected.
		var radioButtonValue = $(this).attr("data-value");

		// This pinpoints the input element located within parent element.
		var radioButtonInput = $(this).parent().find("input");

		// If the radio button div is disabled, return false and do nothing.
		if ($(this).hasClass("disabled")) {
			return false;
		}

		// This resets the current value of the input located within parent.
		// element
		radioButtonInput.val("");

		// This adds the .selected class only to the one selected radio button.
		$(this).parent().find(".radio-button").removeClass("selected")
		$(this).addClass("selected");

		// Updates the value of the input located within parent element.
		radioButtonInput.val(radioButtonValue);
	});

});