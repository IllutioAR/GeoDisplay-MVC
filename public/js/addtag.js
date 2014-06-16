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

function submit_form(){
	uploading = true;
	$("#form").submit();
}

$("#next").click(function(){
	next();
});
$("#save").click(function(){
	submit_form();
});
$("#back").click(function(){
	back();
});

//Botones para seleccionar archivos
function selectFile(e, btn){
	
}

$("#btn-video, #btn-audio, #btn-image").click(function(e){
	e.preventDefault();
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