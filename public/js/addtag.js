var state = 1;
var uploading = false;

function next(){
	if (uploading)
		return;
	state++;
	if (state == 2) {
		$("#next").hide();
		$("#save").show();
	}
	$("#" + (state-1) ).hide();
	$("#" + state ).show();
}

function back(){
	if (uploading)
		return;
	state--;
	if (state == 1){
		$("#save").hide();
		$("#next").show();
	}
	else if(state < 1){
		window.location.href = "index.php";
	}
	$("#" + (state+1) ).hide();
	$("#" + state ).show();
}

$("#next").click(function(){
	next();
});
$("#save").click(function(){
	uploading = true;
	var message = "Complete the following:\n";
	if( $("#latitude").val() == "" ){
		uploading = false;
		message += "- Latitude\n";
	}
	if( $("#longitude").val() == "" ){
		uploading = false;
		message += "- Longitude\n";
	}
	if( $("#name").val() == "" ){
		uploading = false;
		message += "- Name\n";
	}
	if( $("#description").val() == "" ){
		uploading = false;
		message += "- Description\n";
	}
	
	var filename = $("#video").val();
	if( filename != "" ){
		if( filename.split(".").pop() !== "mp4"){
			uploading = false;
			message += "- Video (Must be a mp4 file)";	
		}
	}
	
	else{
		uploading = false;
		message += "- Video";	
	}
	if (uploading){
		$("#form").submit();	
	}else{
		alert(message);
		return;
	}
	
});
$("#back").click(function(){
	back();
});

$("#btn-video, #btn-audio, #btn-image").click(function(e){
	e.preventDefault();
	if (uploading)
		return;
	media = $(this).attr("id").replace("btn-", "");
	$("input[name="+ media + "]").trigger("click");
});

$("input[type=file]").change(function(){
	media = $(this).attr("name");
	if($(this).val() == ""){
		$("#btn-" + media).html('<i class="fa fa-laptop"></i> Select file');
	}
	else{
		$("#btn-" + media).html( $(this).val() );
	}
});