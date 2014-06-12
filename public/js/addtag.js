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