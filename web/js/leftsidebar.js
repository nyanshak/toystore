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
					content += '<li><a href="/php/browse.php?category=' + current.Id + '">' + current.Name + '</a></li>';
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
/*
	$("#LeftSidebar").submit(function(event) {
		event.preventDefault();
		var year = $("#year").val();
		$("#PageHeader").html("Top Baby Names of " + year);
		
		var fData = {"action": "test"};
		fData = $(this).serialize() + "&" + $.param(fData);
		$.ajax({
			url: "php/babynames.php",
			type: "post",
			dataType: "json",
			data: fData,
			success: function(data) {
				if(!data["success"]) {
					alert(data["error"]);
				} else {

					var content = "<h2>Boys</h2><table><tr><th>Ranking</th><th>Name</Name>";
					for (var i = 0; i < data.males.length; i++) {
						var current = data.males[i];
						content += "<tr><td>" + current["ranking"] + "</td><td>" + current["name"] + "</td>";
					}
					content += "</table>";
					var div = $("#MaleNames");
					div.html(content);

					content = "<h2>Girls</h2><table><tr><th>Ranking</th><th>Name</Name>";
					for (var i = 0; i < data.females.length; i++) {
						var current = data.females[i];
						content += "<tr><td>" + current["ranking"] + "</td><td>" + current["name"] + "</td>";
					}
					content += "</table>";
					var div = $("#FemaleNames");
					div.html(content);
				}
				
			},
			error: function(xhr) {
			}	
		});
	});

});
*/
