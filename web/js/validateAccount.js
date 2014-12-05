var emailMessage = "available", originalEmail = "";

function validateAccountDetails() {
	var emptyFields = [];

	var submitForm = true;
	if ($("#name").val() === '') {
		emptyFields.push("Name");
	}

	if ($("#email").val() === '') {
		emptyFields.push("Email");
	} else if (emailMessage !== "available") {
		if ($("#email").val() !== originalEmail) {
			alert(originalEmail);
			submitForm = false;
		}
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

function validateNewAccountDetails() {
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

	if (emailMessage !== "available") {
		alert(emailMessage);
		submitForm = false;
	}

	return submitForm;
}

$(function (){
	originalEmail = $("#email").val();
	$("#email").change(function() {
		var val = $("#email").val();
		if (val !== "") 
			$.ajax({
				url: "/php/checkemail.php",
				type: "post",
				data: {Email: val},
				dataType: "json",
				success: function(data) {
					if (!data["success"]) {
						console.log(data["message"]);
					} else {
						console.log(data["message"]);
						if (data["message"] !== "available") {
							emailMessage = data["message"];
						} else {
							emailMessage = "available";
						}
					}
				}
			});
	});
});
