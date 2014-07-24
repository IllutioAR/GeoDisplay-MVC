$( document ).ready(function() {
	$("button").click(function(){
		$(this).html("Eliminado...");
		$(this).attr("disabled", "disabled");

		var id = $(this).attr("id");
		$(this).removeAttr("id");
		if (typeof(id) === 'undefined' || id == null){
			alert("Error elimiando el archivo");
		};

		$.ajax({
			data:  {"id" : id},
			url:   'ajax/delete_file.php',
			type:  'post',
			success:  function (response){
				console.log("Servidor: " + response);
				location.reload();
			},
			error: function(){
				alert("Error elimiando el archivo");
			}
		});
	});
});