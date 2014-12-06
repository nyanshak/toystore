$(document).ready(function() {
	$("a").click(function() {
		var clicked = $(this);
		var $order = document.getElementById('orderId').value;
		var $quantObj = $(this).prev();
		var $quantEl = $quantObj.attr('Id');
		var $quant = document.getElementById($quantEl).value;
		var $prodObj = $(this).next();
		var $prodEl = $prodObj.attr('Id');
		var $productId = document.getElementById($prodEl).value;
		if (!/^[1-9]+[0-9]*$/.test($quant)) {
			alert("Incorrect quantity! Please enter a valid number");
		} else {
			$.ajax({
				url: "/php/UpdateQuant.php",
				data: {
					orderId: $order,
					qty: $quant,
					productId: $productId,
				},
				type: "post",
				dataType: "json",
				success: function(data) {
					console.log(data);
					// Reply indicates if user is not logged in so we need to alert user to login
					if (data["success"] === true) {
						alert(data["reply"]);
					} else {
						alert(data["reply"]);
					}
				},
				error: function(xhr) {
					console.log("Oops! Something went wrong: " + xhr.status + " " + xhr.statusText);
				}
			});
		}
	});
});
