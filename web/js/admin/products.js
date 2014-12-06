$(function() {
	fillLeftSidebar();	
});

function fillLeftSidebar() {
	$.ajax({
		url: "/php/products.php",
		type: "get",
		dataType: "json",
		success: function(data) {
			if(!data["success"]) {
				console.log(data["error"]);
			} else {
				console.log(data);

				var content = "<h1 class=\"myForm\">Edit Products</h1>";
				
				// Allow adding new product
				content += "<form method=\"post\" name=\"changeProduct\" class=\"myForm\">";
				content += "<img name=\"pictureNew\">";
				content += "<label><span>Name</span><input type=\"text\" name=\"name\" value=\"New Product Name\" /></label>";
				content += "<label><span>Description</span><input type=\"text\" name=\"description\" value=\"New Product Description\" /></label>";
				content += "<label><span>Price</span><input type=\"number\" name=\"price\" value=\"0\" /></label>";
				content += "<label><span>Inventory</span><input type=\"number\" name=\"inventory\" value=\"0\" /></label>";
				content += "<label><span>Picture</span><input type=\"url\" name=\"picture\" pid=\"New\" value=\"http://www.privaledge.net/pricing-strategy/wp-content/uploads/2013/09/13986273-new-product.jpg\" /></label>";
				content += "<label><input type=\"submit\" value=\"Add New Product\" /></label>";
				content += "</form>";
				for (var i = 0; i < data.products.length; i++) {
					var current = data.products[i];
					content += "<form method=\"post\" name=\"changeProduct\" id=\"" + current.Id + "\" class=\"myForm\">";
					content += "<img name=\"picture" + current.Id + "\" value=\"" + current.Picture + "\">";
					content += "<input type=\"hidden\" name=\"productId\" value=\"" + current.Id + "\" />";
					content += "<label><span>Name</span><input type=\"text\" name=\"name\" value=\"" + current.Name + "\" /></label>";
					content += "<label><span>Description</span><input type=\"text\" name=\"description\" value=\"" + current.Description + "\" /></label>";
					content += "<label><span>Price</span><input type=\"number\" name=\"price\" value=\"" + current.Price + "\" /></label>";
					content += "<label><span>Inventory</span><input type=\"number\" name=\"inventory\" value=\"" + current.Inventory + "\" /></label>";
					content += "<label><span>Picture</span><input type=\"url\" name=\"picture\" pid=\"" + current.Id + "\" value=\"" + current.Picture + "\" /></label>";
					content += "<label><input type=\"submit\" value=\"Change Product\" /></label>";
					content += "</form>";
				}

				$("#MainContent").html(content);
				$("[name='picture']").change(function() {
					var url = $(this).val();
					var pid = $(this).attr("pid");

					$("[name=picture" + pid + "]").attr("src", url);
					
				});
			}
		},
		error: function(xhr) {
			console.log("Oops! Something went wrong: " + xhr.status + " " + xhr.statusText);
		}
	});
}
