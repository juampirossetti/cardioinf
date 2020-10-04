$(window).load(function() {
    $('#newAppointmentModalForm').get(0).reset(); //clear form data on page load
});

$(document).ready(function() {
    $('.professional-select option:selected').prop("selected", false)
    $('.medicalstudy-select option:selected').prop("selected", false)
    /**************************************************************************
     * Getters
     **************************************************************************/
    var getProfessionalIdSelected = function() {
        
        return $('#professional_id option:selected').val();
    }

    $('#newAppointment').on('click', function(){
        $('#newAppointmentModal').modal('show');
    });

    $('.red').on('click', function(){
        $('.button-div').hide();
        $('.medicalstudy-select').show();
        $('.btn-submit').show();
    })

    $('.blue').on('click', function(){
        $('.button-div').hide();
        $('.professional-select').show();
        $('.btn-submit').show(); 
    });

    $('#newAppointmentModal').on('hidden.bs.modal', function () {
        $('.button-div').show();
        $('.professional-select').hide();
        $('.professional-select option:selected').prop("selected", false)
        $('.medicalstudy-select').hide();
        $('.medicalstudy-select option:selected').prop("selected", false)
        $('.btn-submit').hide();  
    });

    $('body').on('click','.delete-link',function(e){
        var confirm = window.confirm('¿Esta seguro que desea cancelar este turno?');
        if(confirm == true){
            var form = $(this).closest('.dropdown-menu').find('.delete-form').submit();
        } else {
            e.preventDefault();
        }
    });

    $('body').on('click','.insurance-information-link', function(){
        var insurance_id = $(this).data('in-id');
        
        var medical_study_id = $(this).data('ms-id');
        
        var insurance_name = $(this).data('in-name');

        var medical_study_name = $(this).data('ms-name');
        
        getInformationMsg(medical_study_id, insurance_id, medical_study_name, insurance_name);
    }); 

    var updateModalAndShow = function(message, medical_study_name, insurance_name){
        $('#modalInsurance').find('.medical-study-name').html(medical_study_name);
        $('#modalInsurance').find('.insurance-name').html(insurance_name);
        $('#modalInsurance').find('.insurance-information').html(message);
        
        $('#modalInsurance').modal();
    }
    var getInformationMsg = function(medical_study_id, insurance_id, medical_study_name, insurance_name){
        $.ajax({
            url: '/api/patients/indications',
            data: { 
                    api_token: localStorage.getItem('api_token'),
                    medical_study_id: medical_study_id,
                    insurance_id: insurance_id
                    },
            type: "POST",
            success: function (data) {
                updateModalAndShow(data.message, medical_study_name, insurance_name);
                
            },
            error: function (data) {
                updateModalAndShow('No hay ninguna indicación para este estudio.', 
                                    medical_study_name, insurance_name);
            }
        });  
    };

    // $('body').on('click','.voucher-link', function(){
    //     var id = $(this).data('id');
        
    //     downloadVoucher(id);
        
    // });

    // var downloadVoucher = function(id){
    //     $.ajax({
    //         url: '/api/voucher/'+ id + '/print',
    //         data: { 
    //                 api_token: localStorage.getItem('api_token'),
    //                 },
    //         type: "GET",
    //         success: function (data) {
    //             console.log(data);                
    //         },
    //         error: function (data) {
    //             alert('No se encuentra el comprobante');
    //         }
    //     });
    // }
});