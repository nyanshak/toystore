$(function() {
	fillLeftSidebar();	
});

function fillLeftSidebar() {
	$.ajax({
		url: "/php/categories.php",
		type: "get",
		dataType: "json",
		success: function(data) {
			if(!data["success"]) {
				console.log(data["error"]);
			} else {
				console.log(data);

				var content = "<h1 class=\"myForm\">Edit Categories</h1>";
				
				content += "<form method=\"post\" name=\"changeCategory\" class=\"myForm\">";
				content += "<label><input type=\"text\" name=\"name\" value=\"New Category\" /></label>";
				content += "<label><input type=\"submit\" value=\"Add New Category\" /></label>";
				content += "</form>";
				for (var i = 0; i < data.categories.length; i++) {
					var current = data.categories[i];
					content += "<form method=\"post\" name=\"changeCategory\" id=\"" + current.Id + "\" + class=\"myForm\">";
					content += "<input type=\"hidden\" name=\"categoryId\" value=\"" + current.Id + "\" />";
					content += "<label><input type=\"text\" name=\"name\" value=\"" + current.Name + "\" /></label>";
					content += "<label><input type=\"submit\" value=\"submit changes\" /></label>";
					content += "</form>";
				}

				$("#MainContent").html(content);
			}
		},
		error: function(xhr) {
			console.log("Oops! Something went wrong: " + xhr.status + " " + xhr.statusText);
		}
	});
}
