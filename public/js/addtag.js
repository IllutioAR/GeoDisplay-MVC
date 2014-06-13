var state = 1;
var uploading = false;

function next(){
	if (uploading)
		return;
	state++;
	console.log(state)
	if (state == 3) {
		$("#next").hide();
		$("#save").show();
	}
	if (state == 4) {
		//$("#form").submit();
		console.log("submit desde boton next???");
	}
	$("#" + (state-1) ).hide();
	$("#" + state ).show();
}

function back(){
	if (uploading)
		return;
	state--;
	console.log(state)
	if (state == 2){
		$("#save").hide();
		$("#next").show();
	}
	else if(state < 1){
		window.location.href = "index.html";
	}
	$("#" + (state+1) ).hide();
	$("#" + state ).show();
}

function submit_form(){
	uploading = true;
	$("#save").click(function(){
		$("#submit").trigger("click");
	});
	$("#form").submit();
	console.log("submit");
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

$("#btn-video").click(function(e){
		e.preventDefault();
		$("input[name=video]").trigger("click");
	});
	$("input[name=video]").change(function(){
		if($(this).val() == ""){
			$("#btn-video").html('<i class="fa fa-laptop"></i> Select file');
		}
		else{
			$("#btn-video").html($(this).val());
		}
	});

	$("#btn-audio").click(function(){
		e.preventDefault();
		$("input[name=audio]").trigger("click");
	});
	$("input[name=audio]").change(function(){
		if($(this).val() == ""){
			$("#btn-audio").html('<i class="fa fa-laptop"></i> Select file');
		}
		else{
			$("#btn-audio").html($(this).val());
		}
	});

	$("#btn-image").click(function(){
		e.preventDefault();
		$("input[name=image]").trigger("click");
	});
	$("input[name=image]").change(function(){
		if($(this).val() == ""){
			$("#btn-image").html('<i class="fa fa-laptop"></i> Select file');
		}
		else{
			$("#btn-image").html($(this).val());
		}
	});