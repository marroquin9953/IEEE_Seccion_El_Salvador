function init(){
    $("#mnt_editprofile").on("submit",function(e){
        editprofile(e);
    });
}

$(document).ready(function(){

    $.ajax({
        url:"controller/usuario.php?op=mostrar",
        type:"GET",
        contentType:false,
        processData: false,
        success:function(data){
            data=JSON.parse(data);
            $('#usu_nom_edit').val(data.usu_nom);
            $('#usu_email_edit').val(data.usu_email);
            $('#usu_descrip_edit').val(data.usu_descrip);
            $('#usu_web_edit').val(data.usu_web);
            $('#usu_facebook_edit').val(data.usu_facebook);
            $('#usu_instagram_edit').val(data.usu_instagram);
            $('#usu_youtube_edit').val(data.usu_youtube);
            $('#usu_github_edit').val(data.usu_github);
            $('#vistaprevia').attr('src', data.usu_img);
        }
    })

});

function editprofile(e){
    e.preventDefault();
    var formData = new FormData($("#mnt_editprofile")[0]);

    var file = $('#usu_img')[0].files[0];
    if(file){
        formData.append("file", file);
    }

    $.ajax({
        url:"controller/usuario.php?op=update",
        type:"POST",
        data:formData,
        contentType:false,
        processData: false,
        success:function(data){

            Swal.fire({
                title: "Excelente!",
                text: "Perfil actualizado!",
                icon: "success"
            });

        }
    })
}

document.getElementById('usu_img').addEventListener('change',function() {
    var input = this;
    if(input.files && input.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
            document.getElementById('vistaprevia').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
});

$(document).on("click","#btncambiarpass", function(){
    var pass = $("#txtpass").val();
    var newpass = $("#txtpassnew").val();

    if (pass.length == 0 || newpass.length == 0){
        Swal.fire({
            title: "Error!",
            text: "Campos Vacios!",
            icon: "error"
        });
    }else if (newpass.length < 6 ){
        Swal.fire({
            title: "Error!",
            text: "La nueva contraseña debe tener al menos 6 caracteres!",
            icon: "error"
        });
    }else{
        if(pass == newpass){
            $.ajax({
                url: "controller/usuario.php?op=password",
                method: "POST",
                data: { usu_pass : newpass },
                success: function(data){
                    Swal.fire({
                        title: "Excelente!",
                        text: "Contraseña Actualizada!",
                        icon: "success"
                    });
                }
            });
        }else{
            Swal.fire({
                title: "Error!",
                text: "Las contraseñas no coinciden!",
                icon: "error"
            });
        }
    }
});

$(document).on("click","#bnteliminarcuenta", function(){
    $.ajax({
        url: "controller/usuario.php?op=eliminar",
        method: "POST",
        success: function(data){
            location.reload();
        }
    });
});

init();