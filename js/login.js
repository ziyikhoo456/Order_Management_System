$(document).ready(function() {
    $("#togglePassword").on('click', function(event) {
        console.log("password click");
        event.preventDefault();
        if($('#password').attr("type") == "text"){
            console.log("password text");
            $('#password').attr('type', 'password');
            $('#togglePassword i').addClass( "fa-eye" );
            $('#togglePassword i').removeClass( "fa-eye-slash" );
        }else if($('#password').attr("type") == "password"){
            console.log("password pass");
            console.log($('#togglePassword i'));
            $('#password').attr('type', 'text');
            $('#togglePassword i').removeClass( "fa-eye" );
            $('#togglePassword i').addClass( "fa-eye-slash" );
        }
    });
});