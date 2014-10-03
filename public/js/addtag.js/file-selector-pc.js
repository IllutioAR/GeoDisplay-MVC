$(document).ready(function() {
	$("form").on("click", "#video-select-pc, #audio-select-pc, #image-select-pc", function(e){
		e.preventDefault();
		var type = $(this).attr("id").replace("-select-pc", "");
		$( "#" + type ).trigger("click");
	});

	$("form").on("click", ".drag-area",function(){
		var type = $(this).attr("gd-type");
		$( "#" + type ).trigger("click");
	});

	$("form").on("change", "#video, #audio, #image",function(){
		//Llamar función validar archivo	bool:validateFile(String type){}
		if( $(this).val().length > 0 ){
			var fd = new FormData();
			fd.append( $(this).attr("id"), $(this)[0].files[0] );
			type = $(this).attr("id");
			uploadFile(fd, type);

			//console.debug("Subiendo archivo " + $(this).val());
		}
	});

	//Drag and Drop...
	var obj = $(".drag-area");
	
	obj.on('dragenter', function(e){
		e.stopPropagation();
		e.preventDefault();
	});

	obj.on('dragover', function(e){
		e.stopPropagation();
		e.preventDefault();
	});
	
	obj.parent().on('drop', ".drag-area",function(e){
		e.preventDefault();
		var files = e.originalEvent.dataTransfer.files;
		if(files.length === 1){
			//Send dropped files to Server
			handleFileUpload(files[0], $(this).attr("gd-type") );
		}
		else{
			alert("Arrastra sólo una archivo.");
		}
	});

	$(document).on('dragenter', function(e){
		e.stopPropagation();
		e.preventDefault();
	});

	$(document).on('dragover', function(e){
		e.stopPropagation();
		e.preventDefault();
	});

	$(document).on('drop', function(e){
		e.stopPropagation();
		e.preventDefault();
	});

	//Al dar enter en la búsqueda de google maps hace un trigger de los botones multimedia
	$("#map-search").on("keydown", function(e){
		if( e.keyCode == 13 ){
			e.preventDefault();	
		}
	});

	function handleFileUpload(file, type){
		var fd = new FormData();
		fd.append(type, file);
		uploadFile(fd, type);
	}

	function uploadFile(fd, type){
		var element = $("[class='drag-area'][gd-type='"+type+"']").parent();
		element.empty();

		var html_string = '<div class="preview-upload-progress">'+
						  '<input name="DEFAULT-id" id="DEFAULT-id" type="text" style="display:none"> '+
							'<div class="parent-container">'+
								'<div class="child-container">'+
									'<div id="upload-progress-text" class="text-xl">'+
										'0%'+
									'</div>'+
								'</div>'+
							'</div>'+
						   '</div>'+
						   '<div class="button-area">'+
							'<div class="progress" gd-type="DEFAULT">'+
								'<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">'+
									'<span class="sr-only">0%</span>'+
								'</div>'+
							'</div>'+
							'<button id="DEFAULT-cancel-upload" class="btn btn-default">Cancelar subida</button>'+
						  '</div>';

		html_string = html_string.split("DEFAULT").join(type);
		element.html(html_string);

		var progress_bar = $(".progress[gd-type="+type+"]").children();
		var progress_txt = $(element).find("#upload-progress-text")

		var uploadURL ="ajax/upload_file.php?type="+type;
		var extraData ={};
		var jqXHR=$.ajax({
			xhr: function() {
				var xhrobj = $.ajaxSettings.xhr();
				if (xhrobj.upload) {
					xhrobj.upload.addEventListener('progress', function(event) {
						var percent = 0;
						var position = event.loaded || event.position;
						var total = event.total;
						if (event.lengthComputable) {
							percent = Math.ceil(position / total * 100);
							//console.debug(percent);
							progress_bar.css("width", percent+"%");
							progress_txt.html(percent+"%");
						}
					}, false);
				}
				return xhrobj;
			},
			url: uploadURL,
			type: "POST",
			contentType:false,
			processData: false,
			cache: false,
			data: fd,
			success: function(data){
				$(".progress[gd-type="+type+"]").children().css("width", "100%");
				$(".progress[gd-type="+type+"]").children().addClass("progress-bar-success");
				$(".progress[gd-type="+type+"]").children().removeClass("progress-bar-striped");
				if(data.indexOf("success") > -1){
					var id = data.replace("success", "");
					$("#"+type+"-id").val(id);	
				}
				else{
					console.log("error");
				}
				//SHOW FILE PREVIEW

				//console.debug(data);
			},
			error: function(){
				console.debug("Error");
			}
		});
		$(element).on("click", "#"+type+"-cancel-upload", function(e){
			e.preventDefault();
			jqXHR.abort();
			console.debug("Cancelando...");
			cancelUploadPreview(type);
		});
	}

	function cancelUploadPreview(type){
		var html_string = '<input name="DEFAULT" id="DEFAULT" type="file" style="display:none"><div class="drag-area" gd-type="DEFAULT"><div class="parent-container"><div class="child-container"><div><i class="fa fa-ICON_TYPE icon-lg" data-original-title="" title=""></i></div><div class="text-lg">Arrastra un DEFAULT aquí</div>';
		
		if (type == "image"){
			html_string += '<div>.jpg .png (Max 5MB)</div>';
		}
		else if(type == "video"){
			html_string += '<div>.mp4 .3gp (Max 30MB)</div>';
		}
		else if(type == "audio"){
			html_string += '<div>.mp3 (Max 10MB)</div>';
		}

		html_string += '</div></div></div><div class="button-area"><button id="DEFAULT-select-pc" class="btn btn-default">Subir desde PC</button><button id="DEFAULT-select-cloud" class="btn btn-default">Seleccionar desde GeoDisplay</button></div>';
		html_string = html_string.split("DEFAULT").join(type);

		if(type == "video"){
			html_string = html_string.replace("ICON_TYPE", "film");
		}
		else if(type == "audio"){
			html_string = html_string.replace("ICON_TYPE", "music");
		}
		else if(type == "image"){
			html_string = html_string.replace("ICON_TYPE", "picture-o");
		}

		var element = $("#"+type+"-cancel-upload").parent().parent();
		element.empty();
		element.append(html_string);
	}

});