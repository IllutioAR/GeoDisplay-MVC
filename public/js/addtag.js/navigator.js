$(document).ready(function() {
	var state = 1;

	$("#back").click(function(){
		state--;
		if (state === 0){
			window.location.href = "index.php";
		}
		$( "#" + (state+1) ).hide();
		$( "#" + state ).show(200);
		setMenuText();
	});

	$("#next").click(function(){
		state++; 
		if(state === 3){
			//SUBMIT FORM
			
		}else if(state === 4){
			// SUBMIT MULTIMEDIA
			/*
				Los archivos se suben automáticamente al seleccionarlos,
				al dar click aquí sólo se valida que los archivos se hayan subido completamente
				y se cambia el status del tag a activo.
				(Falta implementar una restricción que no permita activar tags sin video)
			*/
		}
		$( "#" + (state-1) ).hide();
		$( "#" + state ).show(200);
		setMenuText();
	});

	function setMenuText(){
		//Código...
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
});