var state = 1;
var uploading = false;

function next(){
	if (uploading)
		return;
	state++;
	if (state == 2) {
		$("#next").hide();
		$("#save").show();
	}
	$("#" + (state-1) ).hide();
	$("#" + state ).show();
}

function back(){
	if (uploading)
		return;
	state--;
	if (state == 1){
		$("#save").hide();
		$("#next").show();
	}
	else if(state < 1){
		window.location.href = "index.php";
	}
	$("#" + (state+1) ).hide();
	$("#" + state ).show();
}

$("#next").click(function(){
	next();
});
$("#save").click(function(){
	uploading = true;
	var message = "Complete the following:\n";
	if( $("#latitude").val() == "" ){
		uploading = false;
		message += "- Latitude\n";
	}
	if( $("#longitude").val() == "" ){
		uploading = false;
		message += "- Longitude\n";
	}
	if( $("#name").val() == "" ){
		uploading = false;
		message += "- Name\n";
	}
	if( $("#description").val() == "" ){
		uploading = false;
		message += "- Description\n";
	}
	if( $("#image_id").length > 0 ){
		if( $("#image_id").val() == "" ){
			uploading = false;
			message += "- Image (Select an image)";	
		}
	}
	
	if (uploading){
		$("#form").submit();	
	}else{
		alert(message);
		return;
	}
	
});
$("#back").click(function(){
	back();
});

function eventos(){
	$("#btn-video, #btn-audio, #btn-image").click(function(e){
		e.preventDefault();
		if (uploading)
			return;
		var media = $(this).attr("id").replace("btn-", "");
		$("input[name="+ media + "]").trigger("click");
	});

	$("input[type=file]").change(function(){
		var media = $(this).attr("name");
		if($(this).val() == ""){
			$("#btn-" + media).html('<i class="fa fa-laptop"></i> Select file');
		}
		else{
			$("#btn-" + media).html( $(this).val() );
		}
	});	

	$("#btn-video-cloud, #btn-audio-cloud, #btn-image-cloud").click(function(e){
		e.preventDefault();
		var type = $(this).attr("id");
		var type = type.replace("btn-", "").replace("-cloud", "");

		var root = $(this).parent();
		var request = $.getJSON( "ajax/get_user_files.php?type=" + type, function(response) {
			var fileList = '<input name="DEFAULT_id" id="DEFAULT_id" type="text" style="display:none">' +
							'<p><strong>Select a DEFAULT:</strong></p>' +
							'<div class="file-list">';
			$.each( response["files"], function( i, item ) {
				fileList += '<div DEFAULT_id="' + item["id"] + '" class="file-details">' +
								'<div>' + item["name"] +'</div>' +
								'<div>' + item["size"] + 'MB</div>' +
								'<div>Uploaded: ' + item["created_at"] + '</div>' +
							'</div>'
			});
			fileList += '</div>';
			fileList = fileList.split("DEFAULT").join(type);
			root.empty();
			root.html(fileList);
			$("#close-"+ type +"-select").show();
			$(".file-details").click(function(){
				$(this).parent().children().each(function(){
					$(this).removeClass('selected');
				});
				$(this).attr("class", "selected");
				$("#" + type + "_id").val( $(this).attr(type + "_id") );
			});
		})

		request.fail(function() {
		    alert( "Error, please try again!" );
		});
	});
}

$("#close-video-select, #close-audio-select, #close-image-select").click(function(){
	var type = $(this).attr("type");
	$(this).hide();
	var html = '<input name="DEFAULT" id="DEFAULT" type="file" class="btn btn-default" style="display:none">' +
				'<button id="btn-DEFAULT" class="btn btn-default">' +
					'<i class="fa fa-laptop"></i>' +
					'Seleccionar desde equipo' +
				'</button>' +
				'<button id="btn-DEFAULT-cloud" class="btn btn-default">' +
					'<i class="fa fa-cloud"></i>' +
					'Seleccionar de multimedia' +
				'</button>';
	html = html.split("DEFAULT").join(type);
	$("#multimedia-" + type).children().html(html);
	eventos();

});
eventos();