$(function(){
	for (i = new Date(2013, 0, 1).getFullYear(); i >= 2005; i--) {
		$("#year").append($("<option />").val(i).html(i));
	}

	$("#target").submit(function(event) {
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
				alert("Oops! Something went wrong: " + xhr.status + " " + xhr.statusText);
			}	
		});
	});

});
