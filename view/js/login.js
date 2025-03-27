function init(){
    $("#mnt_login").on("submit",function(e){
        login(e);
    });

    $("#mnt_register").on("submit",function(e){
        register(e);
    });
}

$(document).ready(function(){
    $("#msg_login").hide();
    $("#msg_register").hide();
});

function login(e){
    e.preventDefault();
    var formData = new FormData($("#mnt_login")[0]);
    $.ajax({
        url:"controller/usuario.php?op=login",
        type:"POST",
        data:formData,
        contentType:false,
        processData: false,
        success:function(datos){
            if(datos==0){
                $("#msg_login").show();
            }else{
                location.reload();
            }
        }
    })
}

function register(e){
    e.preventDefault();
    var formData = new FormData($("#mnt_register")[0]);
    $.ajax({
        url:"controller/usuario.php?op=insert",
        type:"POST",
        data:formData,
        contentType:false,
        processData: false,
        success:function(datos){
            console.log(datos);
            if(datos==1){
                window.location.href = "index.php";
            }else if(datos==0){
                $("#msg_register").show();
            }
        }
    })
}

function mostrarModal(){
    $('#loginModal').modal('show');
}

function startGoogleSignIn(){
    const auth = gapi.auth2.getAuthInstance();
    auth.signIn();
}

function handleCredentialResponse(response){

    $.ajax({
        type:'POST',
        url:'controller/usuario.php?op=registrargoogle',
        contentType:'application/json',
        headers:{"Content-Type": "application/json"},
        data: JSON.stringify({
            request_type :'user_auth',
            credential: response.credential
        }),
        success: function(datos){
            console.log(datos);
            if(datos==0){
                $("#msg_login").show();
            }else{
                location.reload();
            }
        }
    })

    /* const credencialToken = response.credential;
    const decodedToken = JSON.parse(atob(credencialToken.split('.')[1]));
    console.log(decodedToken); */
}

init();