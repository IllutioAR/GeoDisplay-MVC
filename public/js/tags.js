$("i").click(function(){
	action = $(this).attr("id");
	id = $(this).parent().attr("tag-id");
	if(action == "disable"){
		disable_tag(id);
	}
	else if(action == "clone"){
		clone_tag(id);
	}
	else if(action == "edit"){
		edit_tag(id);
	}
	else if(action == "delete"){
		delete_tag(id);
	}
});

function disable_tag(id){
	var data = {"id" : id};
	$.ajax({
        data:  data,
        url:   'ajax/enable_tag.php',
        type:  'post',
        beforeSend: function (){
            console.log("Procesando, espere por favor...");
        },
        success:  function (response){
            console.log("Servidor: " + response);
            location.reload();
        }
    });
}

function clone_tag(id){
	var data = {"id" : id};
	$.ajax({
        data:  data,
        url:   'ajax/clone_tag.php',
        type:  'post',
        beforeSend: function (){
            console.log("Procesando, espere por favor...");
        },
        success:  function (response){
            console.log("Servidor: " + response);
            location.reload();
        }
    });
}

function edit_tag(id){
	window.location.href = "edit_tag.php?tag=" + id;
}

function delete_tag(id){
	var data = {"id" : id};
	$.ajax({
        data:  data,
        url:   'ajax/delete_tag.php',
        type:  'post',
        beforeSend: function (){
            console.log("Procesando, espere por favor...");
        },
        success:  function (response){
            console.log("Servidor: " + response);
            location.reload();
        }
    });
}