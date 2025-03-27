function init(){
    $("#mnt_askquestion").on("submit",function(e){
        askquestion(e);
    });
}

document.addEventListener("DOMContentLoaded", function () {
    new window.stacksEditor.StacksEditor(
        document.querySelector("#editor-container"),
        "",
        {}
    );
});

$(document).ready(function(){

});

function askquestion(e){
    e.preventDefault();

    var notifiedValue = $("#notifiedMe").prop("checked");

    var agreeValue = $("#youAgreeCheckBox").prop("checked");
    if(agreeValue){
        var tagsInput = $('#eti_id').val();
        var tagsArray = tagsInput.split(',').map(function(tag){
            return tag.trim();
        });

        var preDetalle = document.querySelector('.ProseMirror').innerHTML.trim();
        if(!preDetalle || preDetalle == '<p><br class="ProseMirror-trailingBreak"></p>'){
            Swal.fire({
                title: "Error!",
                text: "El campo 'Detalle' no puede estar vacío.",
                icon: "error"
            });
            return;
        }

        var formData = new FormData();
        formData.append("pre_titulo" , $('#pre_titulo').val());
        formData.append("cat_id" , $('#cat_id').val());
        formData.append("pre_detalle" , document.querySelector('.ProseMirror').innerHTML);
        formData.append("pre_alerta" , notifiedValue);

        for(var i=0 ; i<tagsArray.length ; i++){
            formData.append("tags[]",tagsArray[i]);
        }

        $.ajax({
            url:"controller/pregunta.php?op=insert",
            type:"POST",
            data:formData,
            contentType:false,
            processData:false,
            success:function(data){
                console.log(data);

                limpiaraskquestion();

                Swal.fire({
                    title: "Excelente!",
                    text: "Pregunta Generada!",
                    icon: "success"
                });
            }
        });
    }else{
        Swal.fire({
            title: "Advertencia!",
            text: "El usuario no ha aceptado la Política de Privacidad.",
            icon: "warning"
        });
    }
}

function limpiaraskquestion(){

    $('#pre_titulo').val('');

    var selectizeInputTags = $('#eti_id')[0].selectize;
    if(selectizeInputTags){
        selectizeInputTags.clear();
    }

    var selectizeCatID = $('#cat_id')[0].selectize;
    if(selectizeCatID){
        selectizeCatID.clear();
    }

    document.querySelector('.ProseMirror').innerHTML = '';

    $("#notifiedMe").prop("checked",false);
    $("#youAgreeCheckBox").prop("checked",false);
}

init();
