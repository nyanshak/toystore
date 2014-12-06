
$(document).ready(function() {
	var $updateQuantity=$(this).attr("update");

	$(this).attr('update').click(function() {
	
		var $order = $("#orderId").value;
		alert($order);
		var $quant = $(this).attr("quant").value;
		alert($quant);
	 
		
		if (!/^[1-9]+[0-9]*$/.test($quant)) {
			alert("Incorrect quantity! Please enter a valid number");
			$("#itemQuantity").val="";
		}
			
		 $.ajax({
			url: "/php/UpdateQuant.php",
			data: {
				orderId: $order,
				qty: $quant
			},
			type: "post",
			dataType: "json",
			success: function(data) {
				// Reply indicates if user is not logged in so we need to alert user to login
				if (data['reply'] == "success") {
					alert(data);
				} else {
					alert("Sorry! Something went Wrong. Try Again!");
				}
			},
			error: function(xhr) {
				console.log("Oops! Something went wrong: " + xhr.status + " " + xhr.statusText);
			}
		});
	});
});
