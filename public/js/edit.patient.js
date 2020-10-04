$(document).ready(function() {

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    $('.btn-password').on('click', function(event) { 
        if(isEmail($('#user_email').val())){
            updateUser($('#user_email').val(), $('input[name="_id"]').val());
        }else{
            $('#emailModal #info-text').html('<span class="text-danger">Formato de email incorrecto. Por favor verifique e intente nuevamente.</span>');
            $('#emailModal').modal();
        }
    });

    var updateUser = function(user_email, patient_id){
        
        $.ajax({
            url: '/api/user/generatePassword',
            data: { 
                    api_token: localStorage.getItem('api_token'),
                    email : user_email,
                    patient_id : patient_id
                    },
            type: "POST",
            success: function (data) {
                console.log(data.password);
                $('#emailModal #info-text').html('<span class="text-success">Contraseña generada correctamente: ' + data.password + '</span>');
                $('#emailModal').modal();
            },
            error: function(jqXHR, textStatus, msg) {
                console.log(jqXHR.status);
                if(jqXHR.status == 422){
                    $('#emailModal #info-text').html('<span class="text-danger">Este email ya se encuentra en uso. Por favor seleccione uno nuevo.</span>');
                } else{
                    $('#emailModal #info-text').html('<span class="text-danger">Ocurrió un error al crear la cuenta. Intente más tarde.</span>');        
                }
                $('#emailModal').modal();
            }
        });
    }
});