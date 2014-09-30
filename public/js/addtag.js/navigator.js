$(document).ready(function() {
	var state = 1;

	$("#back").click(function(){
		state--;
		if (state === 0){
			window.location.href = "index.php";
		}
		$( "#" + (state+1) ).hide();
		$( "#" + state ).show(200);
		//setMenuText();
	});

	$("#next").click(function(){
		var flag = true;
		if(state === 1){
			flag = validateCoordinates();
		}
		else if(state === 2){
			flag = validateTextFields();
		}else if(state === 3){
			flag = validateMediaFiles();
		}

		if (flag){
			state++; 
			$( "#" + (state-1) ).hide();
			$( "#" + state ).show(200);
			//setMenuText();	
		}
	});

	/*
	function setMenuText(){
		var back;
		var next;
		if( state === 1){
			back = '<i class="fa fa-arrow-left" data-original-title="" title=""></i> Mis lugares';
			next = 'Información <i class="fa fa-arrow-right" data-original-title="" title=""></i>';
		}else if( state === 2 ){
			back = '<i class="fa fa-arrow-left" data-original-title="" title=""></i> Mapa';
			next = 'Multimedia <i class="fa fa-arrow-right" data-original-title="" title=""></i>';
		}else if( state === 3){
			back = '<i class="fa fa-arrow-left" data-original-title="" title=""></i> Información';
			next = 'Publicar <i class="fa fa-cloud-upload" data-original-title="" title=""></i>';
		}
		$( "#back" ).html( back );
		$( "#next" ).html( next );
	}
	*/

	function validateCoordinates(){
		flag = true;
		var latitude = $("#latitude");
		var longitude = $("#longitude");

		//Valida los elementos numéricos
		if( !isNumeric(latitude.val()) ){
			latitude.addClass("error-input");
			flag = false;
		}
		else{
			latitude.removeClass("error-input");
		}
		if( !isNumeric(longitude.val()) ){
			longitude.addClass("error-input");
			flag = false;
		}else{
			longitude.removeClass("error-input");
		}
		return flag;
	}

	function validateTextFields(){
		flag = true;
		var name = $("#name");
		var description = $("#description");

		if( name.val() == 0 ){
			name.addClass("error-input");
			flag = false;
		}else{
			name.removeClass("error-input");
		}
		if( description.val() == 0 ){
			description.addClass("error-input");
			flag = false;
		}else{
			description.removeClass("error-input");
		}
		return flag;
	}

	function validateMediaFiles(){
		flag = true;
		var image;
		var video;
		var audio;

		$("#form").submit();
		return flag;
		// SUBMIT MULTIMEDIA
		/*
			Los archivos se suben automáticamente al seleccionarlos,
			al dar click aquí sólo se valida que los archivos se hayan subido completamente
			y se cambia el status del tag a activo.
			(Falta implementar una restricción que no permita activar tags sin video)
		*/
	}

	function isNumeric(n) {
		return !isNaN(parseFloat(n)) && isFinite(n);
	}

});