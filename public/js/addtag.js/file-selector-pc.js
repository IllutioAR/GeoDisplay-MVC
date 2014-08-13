$(document).ready(function() {
	$(	"#video-select-pc,"+
		"#audio-select-pc,"+
		"#image-select-pc" ).click(function(e){
			e.preventDefault();
	});

	$( "#video-select-pc, #audio-select-pc, #image-select-pc" ).click(function(){
		var type = $(this).attr("id").replace("-select-pc", "");
		$( "#" + type ).trigger("click");
	});


	$(".drag-area").click(function(){
		var type = $(this).attr("gd-type");
		$( "#" + type ).trigger("click");
	});

	$("#video, #audio, #image").on("change", function(){
		if( $(this).val().length > 0 ){
			console.debug("subiendo archivo " + $(this).val());
			
		}
	});

	/*

	//Drag and Drop...
	$(".drag-area")

	*/
});