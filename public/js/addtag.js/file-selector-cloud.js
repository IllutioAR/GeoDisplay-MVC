$(document).ready(function() {
	$("form").on("click", "#video-select-cloud, #audio-select-cloud, #image-select-cloud", function(e){
		e.preventDefault();
		var type = $(this).attr("id").replace("-select-cloud", "");
		$("#file-selector-cloud").modal();

		$("#select-cloud-file").attr("disabled", "");
		var root = $(".modal-body").children();
		
		root.empty();
		root.html("Cargando archivos...");

		var request = $.getJSON( "ajax/get_user_files.php?type=" + type, function(response) {
			var fileList = "";
			$.each( response["files"], function( i, item ) {
				fileList += '<div class="col-md-3">' +
								'<div class="file-wrapper" gd-id="' + item["id"] + '">' +
									'<div class="file-image">' +
										'<i class="fa fa-ICON icon-lg"></i>' +
									'</div>' +
									'<div class="file-name">' +
										item["name"] +
									'</div>' +
								'</div>' +
							'</div>';
							//item["size"]
							//item["created_at"]
			});
			if(type == "video"){
				fileList = fileList.split("fa-ICON").join("fa-film");
			}
			else if(type == "audio"){
				fileList = fileList.split("fa-ICON").join("fa-music");
			}
			else if(type == "image"){
				fileList = fileList.split("fa-ICON").join("fa-image");
			}
			root.empty();
			root.html(fileList);
			$(".file-wrapper").click(function(){
				$(this).parent().siblings().each(function (){
				    $(this).children().removeClass("file-wrapper-selected");
				});
				$(this).addClass("file-wrapper-selected");
				$("#select-cloud-file").removeAttr("disabled");
			});
		})

		request.fail(function() {
			$("#file-selector-cloud").modal("hide");
		    alert("Error miestra se cargaban los archivos,\n intenta otra vez.");
		});
	});

	$("#file-selector-cloud").on("click", "#select-cloud-file", function(){
		$("#file-selector-cloud").modal("hide");

		var id = $(".file-wrapper-selected").attr("gd-id");

		var request = $.getJSON( "ajax/get_file_by_id.php?id=" + id, function(response) {
			var file_path = "";
			var type = "";
			$.each( response["file"], function( i, item ) {
				file_path = "media/"+item["file_path"];
				type = item["type"];
			});
			var element = $("[class='drag-area'][gd-type='"+type+"']").parent();
			element.empty();
			if(type == "video"){
				element.prepend(
					'<div><video controls>'+
						'<source src="' + file_path + '" type="video/mp4">'+
						'Your browser does not support the video tag.'+
					'</video></div>' +
					'<div class="button-area">' +
						'<button id="video-cancel" class="btn btn-default">Cancelar selección</button>' +
					'</div>'
					);
			}
			else if(type == "audio"){
				element.prepend(
					'<audio controls>'+
						'<source src="'+file_path+'" type="audio/mpeg">'+
						'Your browser does not support the audio tag.'+
					'</audio>' +
					'<div class="button-area">' +
						'<button id="audio-cancel" class="btn btn-default">Cancelar selección</button>' +
					'</div>'
					);
			}
			else if(type == "image"){
				element.append(
					'<img src="'+file_path+'">' +
					'<div class="button-area">' +
						'<button id="image-cancel" class="btn btn-default">Cancelar selección</button>' +
					'</div>'
					);
			}
		})

		request.fail(function() {
			$("#file-selector-cloud").modal("hide");
		    alert("Error miestra se cargaban los archivos,\n intenta otra vez.");
		});

	});

	$("form").on("click", "#video-cancel, #audio-cancel, #image-cancel", function(e){
		e.preventDefault();
		var type = $(this).attr("id").replace("-cancel", "");

		var hmtl_string = '<input name="DEFAULT" id="DEFAULT" type="file" style="display:none"><div class="drag-area" gd-type="DEFAULT"><div class="parent-container"><div class="child-container"><div><i class="fa fa-ICON_TYPE icon-lg" data-original-title="" title=""></i></div><div class="text-lg">Arrastra un DEFAULT aquí</div></div></div></div><div class="button-area"><button id="DEFAULT-select-pc" class="btn btn-default">Subir desde PC</button><button id="DEFAULT-select-cloud" class="btn btn-default">DEFAULT en GeoDisplay</button></div>';
		html_string = hmtl_string.split("DEFAULT").join(type);

		if(type == "video"){
			html_string = html_string.replace("ICON_TYPE", "film");
		}
		else if(type == "audio"){
			html_string = html_string.replace("ICON_TYPE", "music");
		}
		else if(type == "image"){
			html_string = html_string.replace("ICON_TYPE", "picture-o");
		}

		var element = $(this).parent().parent();
		element.empty();
		element.append(html_string);
	});

});