var state = 1;

function next(){
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