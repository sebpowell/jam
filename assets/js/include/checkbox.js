// The checkboxes work by using a hidden input (that is a sibling of the checkboxes) that is updated whenever a
// non-disabled checkbox is checked or unchecked.

$(function () {
	// Setup the default value for the checkboxes' hidden input
	$(".checkbox-holder").each(function () {
		updateCheckboxHiddenInputValue(this);
	});

	// Setup the behaviour when an element is clicked
	$(".checkbox:not(.disabled)").click(function () {
		toggleCheckBox(this);
	});

	// Setup the behaviour when space or enter is pressed
	$(".checkbox").keypress(function (e) {
		switch (e.keyCode || e.which) {
			case 32:
				toggleCheckBox(e.target);
				break;
			case 13:
				var form = $(e.target).closest('form');
				form.submit();
				break;
		}
	});

	setupCheckboxTabbing();
});

function updateCheckboxHiddenInputValue(parent) {
	var checkedBoxesArray = [];
	$(parent).find(".checkbox.selected").each(function () {
		var selectedCheckboxValue = $(this).attr("data-value");
		checkedBoxesArray.push(selectedCheckboxValue);
	});

	var checkboxHiddenInput = $(parent).find("input");
	checkboxHiddenInput.val(JSON.stringify(checkedBoxesArray));
}

function toggleCheckBox(checkBoxElement) {
	$(checkBoxElement).toggleClass("selected");
	updateCheckboxHiddenInputValue($(checkBoxElement).parent());
}

function setupCheckboxTabbing() {
	$(".checkbox:not(.disabled)").each(function () {
		$(this).attr("tabIndex", 0);
	});
}