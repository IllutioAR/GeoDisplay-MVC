$(document).ready(function() {

	$("i").click(function(){
		action = $(this).attr("id");
		id = $(this).parent().parent().parent().attr("gif-id");
		if(action == "delete"){
			if( confirm("¿Eliminar gif?") ){
				delete_gif(id);
			}
		}
	});

	function getURLParameter(name) {
		return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null
	}

	function delete_gif(id){
		var data = {"id" : id};
		$.ajax({
			data:  data,
			url:   'ajax/delete_gif.php',
			type:  'post',
			beforeSend: function (){
				console.log("Procesando...");
			},
			success:  function (response){
				console.log(response);
				location.reload();
			}
		});
	}
});