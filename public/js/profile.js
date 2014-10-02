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
});