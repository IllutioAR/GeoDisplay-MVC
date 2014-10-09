$(document).ready(function() {
	var state = 1;

	$("form").bind("keypress", function(e){
		if(e.keyCode == 13){
			$("#next").trigger("click");
			e.preventDefault();
		}
	});

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
		if( !isNumeric(latitude.val()) || latitude.val() > 90 || latitude.val() < -90){
			latitude.addClass("error-input");
			flag = false;
		}
		else{
			latitude.removeClass("error-input");
		}
		if( !isNumeric(longitude.val())  || longitude.val() > 180 || longitude.val() < -180){
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
		var website = $("#website_url");
		var store = $("#purchase_url");
		var facebook = $("#facebook");
		var twitter = $("#twitter");
		
		//var expression = /[-a-zA-Z0-9@:%_\+.~#?&\/\/=]{2,256}\.[a-z]{4,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)?/gi;
		var expression = /([A-Za-z0-9]{1,20}\.)?[-a-zA-Z0-9:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9:%_\+.~#?&\/\/=]*)?/gi;
		//var exp = /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)/gi;
		var exp = /(https?:\/\/)([A-Za-z0-9]{1,20}\.)?[-a-zA-Z0-9:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9:%_\+.~#?&\/\/=]*)?/gi;;
		
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
		/**********Validation for URLs************************/

		if (website.val() != 0) {
			var value = website.val();
			if (expression.test(value)) {
				if ( exp.test(value) == false ){
					website.val("http://"+value);
				}
				website.removeClass("error-input");
			}
			else{
				website.addClass("error-input");
				flag = false;
			}
		}
		else{
			website.removeClass("error-input");
		}
		/************************************Store Validation*************************/
		if (store.val() != 0) {
			var value = store.val();
			if (expression.test(value)) {
				if ( exp.test(value) == false ){
					store.val("http://"+value);
				}
				store.removeClass("error-input");
			}
			else{
				store.addClass("error-input");
				flag = false;
			}
		}
		else{
			store.removeClass("error-input");
		}
		/************************************Facebook Validation*************************/
		if (facebook.val() != 0) {
			var expression = /([A-Za-z0-9]{1,20}\.)?(facebook|fb\.com)([-a-zA-Z0-9:%_\+.~#?&\/=]*)?/gi;
			var value = facebook.val();
			var exp = /(https?:\/\/)([A-Za-z0-9]{1,20}\.)?(facebook|fb\.com)([-a-zA-Z0-9:%_\+.~#?&\/=]*)?/gi;
			if ( expression.test(value) ) {
				if (exp.test(value) == false) {
					facebook.val('http://'+value);
				}
				facebook.removeClass("error-input");
			}
			else{
				facebook.addClass("error-input");
				flag = false;
			}
		}
		else{
			facebook.removeClass("error-input");
		}
		/************************************Twiter Validation*************************/
		if (store.val() != 0) {
			var value = store.val();
			if (expression.test(value)) {
				if ( exp.test(value) == false ){
					store.val("http://"+value);
				}
				store.removeClass("error-input");
			}
			else{
				store.addClass("error-input");
				flag = false;
			}
		}
		else{
			store.removeClass("error-input");
		}
			/************************************Facebook Validation*************************/
		if (twitter.val() != 0) {
			var value = twitter.val();

			var expression = /([A-Za-z0-9]{1,20}\.)?(twitter\.com)([-a-zA-Z0-9:%_\+.~#?&\/=]*)?/gi;
			var exp_at_user = /@(\w){1,15}/gi;
			var exp = /(https?:\/\/)([A-Za-z0-9]{1,20}\.)?(twitter\.com)([-a-zA-Z0-9:%_\+.~#?&\/=]*)?/gi;
			
			// twitter.com/username
			if ( expression.test(value) ) {
				if (exp.test(value) == false) {
					twitter.val('http://'+value);
				}
				twitter.removeClass("error-input");
			}
			// @username
			else if( exp_at_user.test(value) ){
				twitter.removeClass("error-input");
			}
			// fail
			else{
				twitter.addClass("error-input");
				flag = false;
			}
		}
		else{
			twitter.removeClass("error-input");
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