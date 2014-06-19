$( document ).ready(function() {
	$(".fa").tooltip();
	$("img").on("dragstart", function(e){
		e.preventDefault();
	});
});