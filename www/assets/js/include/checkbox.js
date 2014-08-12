// This behaviour ensures that the custom - alternative, non-standard -
// checkboxes work as expected. There is a hidden input element located within
// parent element of every checkbox whose value gets updated as checkboxes
// are being checked and unchecked. It is important to note that there is
// one and only one input for a specific group of checkboxes and its value
// represents a JSON object.
$(document).ready(function(){

	$(".checkbox").click(function() {

		// This gets the value of the checkbox div that has been selected.
		var checkboxValue = $(this).attr("data-value");

		// This pinpoints the input element located within parent element.
		var checkboxInput = $(this).parent().find("input");

		// This gets the value of the hidden input element located within parent
		// element. It parses JSON so this variable now represents an array.
		var checkboxInputValue = JSON.parse(checkboxInput.val());

		// If the checkbox div is disabled, return false and do nothing else.
		if ($(this).hasClass("disabled")) {
			return false;
		}

		// If the checkbox div is currently selected, pop out the value from
		// input's value.
		if ($(this).hasClass("selected")) {

			// Checks if the value is in the very array from which it is to be
			// popped out.
			if ($.inArray(checkboxValue, checkboxInputValue) !== (-1)) {
				var indexOfValue = checkboxInputValue.indexOf(checkboxValue);
				checkboxInputValue.splice(indexOfValue, 1);
			}
		}
		else {

			// Checks if the value is not already included in the very array it
			// is to be pushed into, in order to prevent repetitions.
			if ($.inArray(checkboxValue, checkboxInputValue) == (-1)) {
				checkboxInputValue.push(checkboxValue);
			}
		}

		// Toggles the .selected class. It is essential that this happens after
		// injection / deletion is executed, because otherwise the whole
		// functionality would be flawed.
		$(this).toggleClass("selected");

		// Updates the value of the input located within parent element.
		checkboxInput.val(JSON.stringify(checkboxInputValue));
	});

});