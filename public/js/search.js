//Script para el formulario de búsqueda
function search_tag(){
	var buscar = $("#search_tag").val().toLowerCase();
	$("[id*=tagInfo]").each(function(){
		if($(this).text().toLowerCase().indexOf(buscar) != -1) {
			$(this).fadeIn(100);
		}else{
			$(this).fadeOut(100);
		}
	});
}

$("#search_tag").keyup(function() {
	search_tag();
});
$("#search_button").click(function(e){
	e.preventDefault();
	search_tag();
});