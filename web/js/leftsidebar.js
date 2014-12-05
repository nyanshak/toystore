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
				var content = "<h1>Categories</h1><ul>";
				
				for (var i = 0; i < data.categories.length; i++) {
					var current = data.categories[i];
					content += '<li><a href="/?category=' + current.Name + '">' + current.Name + '</a></li>';
				}

				content += "</ul>";
				$("#LeftSidebar").html(content);
			}
		},
		error: function(xhr) {
			console.log("Oops! Something went wrong: " + xhr.status + " " + xhr.statusText);
		}
	});
}
