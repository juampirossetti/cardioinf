$(document).ready(function() {

    function deleteHistory(id){
        return $.ajax({
            url: '/api/detail/'+id,
            data: {
                api_token : localStorage.getItem('api_token')
            },
            type: "DELETE"
        });
    }

    $('.btn-add-file').on('click',function(){
        var file = $('<div class="file-unity"><i class="glyphicon glyphicon-remove btn-remove"></i><input type="file" name="file[]" class="file-input" accept="image/x-png,image/jpeg"></div>');
        $(this).closest('.form-group').find('.file-array').append(file);
    });

    $('body').on('click','.btn-remove',function(){
        if(confirm('¿Seguro que desea eliminar esta imagen?')){
            $(this).closest('.file-unity').remove();
        };
    });

    function showSuccessModal(){
        $('#successModal').modal('show');
    }

    function showErrorModal(){
        $('#errorModal').modal('show');
    }

    $('body').on('click','.btn-delete-detail',function(){
        if(confirm('¿Seguro que desea eliminar este detalle junto con todas las imágenes?')){
            var button = $(this);
            
            id = $(this).data('id');

            deleteHistory(id).then(function(json){
                button.closest('li.detail-description').prev().remove(); 
                button.closest('li.detail-description').remove(); 
                showSuccessModal();
            }, function(reason){
                console.log(reason);
                showErrorModal();
            });
        };
    });

    $('.datepicker').datetimepicker({   
        timepicker: true,
        format: 'd-m-Y H:i',
        defaultDate: new Date(),
        defaultTime: new Date(),
        lang: 'es'        
        }
    );

    function init_date(){
        var date = moment().toObject();
        
        var date_str = ('0' + date.date).slice(-2) +'-'+('0' + (date.months+1)).slice(-2) +'-'+date.years;
        var time_str = ('0' + date.hours).slice(-2) + ':' + ('0' + date.minutes).slice(-2);

        $('input.datetime-input').val(date_str + ' '+time_str);
    }

    init_date();
});