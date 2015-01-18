//Script para la selección de archivos
$(document)
    .on('change', '.btn-file :file', function() {
        var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

$(document).ready( function() {
    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        var input = $(this).parents('.input-group').find(':text'), label;
        if(input.length) {
            if(label != ""){
                input.val(label);
            }
            else{
                input.val("Select a file...");
            }
        }
    });
    
    $("#previewCanvas").click(function(e){
        $("input[type='file']").trigger("click");
    });
});   