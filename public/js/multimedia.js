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

	function search_tag(){
		var buscar = $("#search_file").val().toLowerCase();
		$("[id=file]").each(function(){
			if($(this).text().toLowerCase().indexOf(buscar) != -1) {
				$(this).fadeIn(100);
			}else{
				$(this).fadeOut(100);
			}
		});
	}

	$("#search_file").keyup(function() {
		search_tag();
	});
	$("#search_button").click(function(e){
		e.preventDefault();
		search_tag();
	});

	$("#video-upload, #audio-upload, #image-upload").click(function(){
		$("#file").trigger("click");
		var type = $(this).attr("id");
		type = type.replace("-upload", "");
		var action = $("#upload-file").attr("action");
		$("#upload-file").attr("action", action + "?type=" + type);
	});

	$("#file").on("change", function(){
		$("#upload-file").ajaxForm({
			beforeSubmit:function() {
				$("#file-upload-select").html("Uploading...");
				$("#file-upload-select").removeAttr("data-toggle");
			},
			beforeSend: function(e) {

			},
			uploadProgress: function(event, position, total, percentComplete) {
				$("#file-upload-select").html("Progress " + percentComplete + "%");
			},
			success: function(data) {
				var type = $("#upload-file").attr("action").replace("ajax/upload_file.php?type=", "")
				if(data == "success"){
					window.location.href = "multimedia.php?type=" + type + "&success=upload";
				}
				else{
					window.location.href = "multimedia.php?type=" + type + "&error";
				}				
			},
			error: function(){
				console.log("Error");
			}
		});
		$("#upload-file").submit();
	});


});