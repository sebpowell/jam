var validateData = {
	empty: function(val) {
		return val !== '' && val !== false && val !== null;
	},
	email: function(val) {
		return (/^("([ !\x23-\x5B\x5D-\x7E]*|\\[ -~])+"|[-a-z0-9!#$%&'*+\/=?^_`{|}~]+(\.[-a-z0-9!#$%&'*+\/=?^_`{|}~]+)*)@([0-9a-z\u00C0-\u02FF\u0370-\u1EFF]([-0-9a-z\u00C0-\u02FF\u0370-\u1EFF]{0,61}[0-9a-z\u00C0-\u02FF\u0370-\u1EFF])?\.)+[a-z\u00C0-\u02FF\u0370-\u1EFF][-0-9a-z\u00C0-\u02FF\u0370-\u1EFF]{0,17}[a-z\u00C0-\u02FF\u0370-\u1EFF]$/i).test(val);
	},
	int: function(val) {
		return (/^-?[0-9]+$/).test(val);
	},
	password: function(val) {
		return (/^.*(?=.{6,})(?=.*\d)(?=.*[a-žA-Ž]).*$/).test(val);
	}
};

/**
 * Checks whether input is undefined
 * @param {mixed} i
 * @returns {Boolean}
 */
function isUndefined(i) {
	return (typeof i === 'undefined');
}

/**
 * Checks single form rule
 * @param {string} r
 * @param {string} val
 * @returns {Boolean}
 */
function isValid(r, val) {
	return (validateData[r](val));
}

/**
 * Validates according to rule data from inputs
 * @param {string} val
 * @param {json} dataRule
 * @returns {string}
 */
function validate(val, dataRule) {
	var rule = $.parseJSON(dataRule);

	if (!isUndefined(rule["password"])) {
		if (isValid("empty", val) && !isValid("password", val)) {

			return rule["password"];
		}
	}
	else if (!isUndefined(rule["int"]) || !isUndefined(rule["numeric"])) {
		if (isValid("empty", val) && !isValid("int", val)) {

			return rule["int"];
		}
	}
	else if (!isUndefined(rule["email"])) {
		if (isValid("empty", val) && !isValid("email", val)) {

			return rule["email"];
		}
	}
}

function clearForm(form) {
	$(form).find("input[type=text]").val("");
	$(form).find("select").val("");
	var filesInput = $(form).find('input[type=file]');
	filesInput.replaceWith(filesInput.clone());
	return form;
}

$(document).ready(function() {

	/**
	 * Validates each form
	 */
	$("button").click(function() {
		var form = $(this).parent();
		var flashMessage = $(form).find(".flash-message");
		var inputs = form.find(":input");
		var r;

		flashMessage.addClass('show');

		inputs.each(function() {
			var dataRule = $(this).attr("data-rule");
			var required = $(this).attr("required");

			if ($(this).attr("type") === 'file' && !isUndefined(required)) {
				if ($(this)[0].files.length < 1) {
					r = 'Please choose a file.';
					return false;
				}
			}

			var val = $(this).val();

			if (!isUndefined(required)) {
				if (!isValid("empty", val)) {
					r = "Please, fill out all required inputs.";
					return false;
				}
				else if (!isUndefined(dataRule) && !isUndefined(validate(val, dataRule))) {
					r = validate(val, dataRule);
					return false;
				}
			}
			else if (!isUndefined(dataRule) && !isUndefined(validate(val, dataRule))) {
				r = validate(val, dataRule);
				return false;
			}
		});

		if (!isUndefined(r)) {
			flashMessage.html('<div class="alert warning"><p>' + r + '</p></div>');
			return false;
		}

		flashMessage.html("");
	});

});