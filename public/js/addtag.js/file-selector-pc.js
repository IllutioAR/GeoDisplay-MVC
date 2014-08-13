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

	//Drag and Drop...
	var obj = $(".drag-area");
	
	obj.on('dragenter', function(e){
		e.stopPropagation();
		e.preventDefault();
	});

	obj.on('dragover', function(e){
		e.stopPropagation();
		e.preventDefault();
	});
	
	obj.on('drop', function(e){
		e.preventDefault();
		var files = e.originalEvent.dataTransfer.files;
		if(files.length === 1){
			//Send dropped files to Server
			handleFileUpload(files,obj);
		}
		else{
			alert("Arrastra sólo una archivo.");
		}
	});

	$(document).on('dragenter', function(e){
	    e.stopPropagation();
	    e.preventDefault();
	});

	$(document).on('dragover', function(e){
		e.stopPropagation();
		e.preventDefault();
	});

	$(document).on('drop', function(e){
	    e.stopPropagation();
	    e.preventDefault();
	});

});