$(document).ready(function() {
	var state = 1;
	var uploading = false;

	$("input").on("keypress", function(e){
		if(e.keyCode == 13){
			$("#add-point").trigger("click");
			e.preventDefault();
		}
	});

	$("#back").click(function(){
		state--;
		if (state === 0){
			window.location.href = "gif.php"; 
		}
		$( "#" + (state+1) ).hide();
		$( "#" + state ).show(200);
	});

	$("#next").click(function(){
		var flag = true;
		if(state === 1){
			flag = validateMap();
		}
		else if(state === 2){
			flag = validateImage();
			if (flag){
				if (!uploading) {
					uploading = true;
					$("#form").submit();
					disableButton();
				}else{

				}
			}
			else{
				//alert("Completa los campos");
			}
			return;
		}

		if(flag){
			state++; 
			$( "#" + (state-1) ).hide();
			$( "#" + state ).show();
			if(state == 2){
				google.maps.event.trigger(map, "resize");
	    		map.setCenter(initialLocation);
			}
		}
	});

	function validateMap(){
		var flag = true;
		var latitude = $("#latitude");
		var longitude = $("#longitude");


		if( latitude.val() == "" ){
			latitude.addClass("error-input");
			flag =  false;
		}
		else{
			latitude.removeClass("error-input");
		}
		if( longitude.val() == "" ){
			longitude.addClass("error-input");
			flag =  false;
		}
		else{
			longitude.removeClass("error-input");
		}
		return flag;
	}

	function validateImage(){
		var flag = true;
		var name = $("#name");
		if( name.val() == "" ){
			name.addClass("error-input");
			flag =  false;
		}
		else{
			name.removeClass("error-input");
		}
		
		if( $("#gif_image").val().split('.').pop() != "gif" ){
			$("#file-selector-gif").addClass("error-input");
			flag = false;
			alert("La imagen de ser un gif");
		}else{
			$("#file-selector-gif").removeClass("error-input");
		}
		return flag;
	}

	function disableButton(){
		$("#next").html("<span>Creando...</span>");
	}

});