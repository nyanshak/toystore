function validateAccountDetails() {
	var emptyFields = [];

	var submitForm = true;
	if ($("#name").val() === '') {
		emptyFields.push("Name");
	}

	if ($("#email").val() === '') {
		emptyFields.push("Email");
	}

	if ($("#billingaddress").val() === '') {
		emptyFields.push("Shipping Address");
	}

	if ($("#shippingaddress").val() === '') {
		emptyFields.push("Billing Address");
	}

	if (emptyFields.length > 0) {
		popupText = emptyFields.join([separator = ", "]) + " cannot be empty.";
		alert(popupText);
		submitForm = false;
	}
	
	if ($("#password-result").hasClass("weak")) {
		alert("Weak password. Please choose a stronger password.");
		submitForm = false;
	}

	return submitForm;
}

