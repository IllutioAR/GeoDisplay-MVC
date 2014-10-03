$(document).ready(function() {
	var imgWidth = $("#photo").width();
	var imgHeight = $("#photo").height();
	var ContainerWidth = $("#photosection").width();
	var ContainerHeight = $("#photosection").height();
	$("#photoContainer").width(ContainerWidth);
	if (imgWidth > imgHeight) {
		if (imgHeight < ContainerWidth) {
			$("#photo").width(ContainerWidth);
		}else{
			$("#photo").height(ContainerWidth);
			$("#photo").width(ContainerWidth);
		};
	}
	else if (imgWidth < imgHeight) {
		$("#photoContainer").height(ContainerWidth);
		$("#photo").height(ContainerWidth);
	}
	else{
		$("#photoContainer").height(ContainerWidth);
		if ($("#photo").width() < $("#photoContainer").height()) {
			var imgWidth = $("#photo").width();
			var imgHeight = $("#photo").height();
			var relation = $("#photoContainer").height() - $("#photo").width();
			$("#photo").width(imgWidth + relation);
			$("#photo").height(imgHeight + relation);
		};
	}

	$("#change-logo").on("click", function(){
		$("#select-logo").trigger("click");
	});

	$("#select-logo").on("change", function(){		

		var fileInput = document.getElementById('select-logo');
		var file = fileInput.files[0];
		var formData = new FormData();
		formData.append("logo", file);
		
		var xhr = new XMLHttpRequest();
		
		// Add any event handlers here...
		xhr.open('POST', "ajax/change_logo.php", true);
		xhr.send(formData);
		xhr.onreadystatechange=function(){
			if(xhr.readyState == 4 && xhr.status == 200){
				console.log("done: "+xhr.responseText);
				location.reload();
			}else{
				console.log("error");
			}
		}

	});

	$("#change-language").on("click", function(e){
		$(this).attr("disabled", "disabled");
		var data = {"language" : $("#language").val() };
    	$.ajax({
            data:  data,
            url:   'ajax/change_language.php',
            type:  'post',
            success: function(response){
            	console.log(response);
                location.reload();
            }
        });
	});
});