function init(){
    $("#mnt_comentario_pregunta").on("submit",function(e){
        comentariopregunta(e);
    });

    $("#mnt_respuesta").on("submit",function(e){
        publicarrespuesta(e);
    });
}

document.addEventListener("DOMContentLoaded", function () {
    new window.stacksEditor.StacksEditor(
        document.querySelector("#respuesta-container"),
        "",
        {}
    );
});

$(document).ready(function(){
    var pre_id = $('#pre_id').val();
    listar_comentario_pregunta(pre_id);
    listarrespuesta(pre_id);

    $(document).on('submit','.mnt_comentario_respuesta',function(e){
        e.preventDefault();

        var form = this;

        var respd_detalle = $(form).find("#respd_detalle").val();
        if (respd_detalle.length > 0){

            var formData = $(this).serialize();
            $.ajax({
                url: "controller/comentario.php?op=insert_comentario_respuesta",
                type: "POST",
                data: formData,
                success:function(data){
                    console.log(data);

                    $(form).find("#respd_detalle").val('');
                    listarrespuesta(pre_id);

                    Swal.fire({
                        title: "Excelente!",
                        text: "Comentario Agregado!",
                        icon: "success"
                    });
                }
            });

        }else{
            Swal.fire({
                title: "Error!",
                text: "El campo 'Comentario' no puede estar vacío.",
                icon: "error"
            });
        }
    });
});

function comentariopregunta(e){
    e.preventDefault();

    var pred_detalle = $("#pred_detalle").val();
    if (pred_detalle.length > 0){

        var formData = new FormData($("#mnt_comentario_pregunta")[0]);
        $.ajax({
            url:"controller/comentario.php?op=insert_comentario_pregunta",
            type:"POST",
            data:formData,
            contentType:false,
            processData:false,
            success:function(data){
                listar_comentario_pregunta(data);

                $("#pred_detalle").val('');

                Swal.fire({
                    title: "Excelente!",
                    text: "Comentario Agregado!",
                    icon: "success"
                });
            }
        });

    }else{
        Swal.fire({
            title: "Error!",
            text: "El campo 'Comentario' no puede estar vacío.",
            icon: "error"
        });
    }
};

function listar_comentario_pregunta(pre_id){
    $.ajax({
        url:"controller/comentario.php?op=comentario_preguntas",
        type:"POST",
        data:{ pre_id : pre_id },
        success:function(data){
            $("#list_comentario_preguntas").html(data);
        }
    });
}

function publicarrespuesta(e){
    e.preventDefault();

    var respDetalle = document.querySelector('.ProseMirror').innerHTML.trim();
    if(!respDetalle || respDetalle == '<p><br class="ProseMirror-trailingBreak"></p>'){
        Swal.fire({
            title: "Error!",
            text: "El campo 'Detalle' no puede estar vacío.",
            icon: "error"
        });
        return;
    }

    var formData = new FormData();
    formData.append("pre_id" , $('#pre_id').val());
    formData.append("resp_detalle" , document.querySelector('.ProseMirror').innerHTML);

    $.ajax({
        url:"controller/respuesta.php?op=insert",
        type:"POST",
        data:formData,
        contentType:false,
        processData:false,
        success:function(data){
            document.querySelector('.ProseMirror').innerHTML = '';

            listarrespuesta($('#pre_id').val());

            Swal.fire({
                title: "Excelente!",
                text: "Respuesta Agregada!",
                icon: "success"
            });
        }
    });
}

function listarrespuesta(pre_id){
    $.ajax({
        url:"controller/respuesta.php?op=listar",
        type:"POST",
        data:{pre_id : pre_id},
        success:function(data){
            $("#listpregunta").html(data);
        }
    });
}


init();