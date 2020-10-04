$(document).ready(function() {

    $('.file-show-link').on('click',function(e){
        e.preventDefault();
        //var history_id = $(this).data('hid');
        //var image_id = $(this).data('iid');
        var image_url = $(this).data('url');
        console.log(image_url);
        $('.show-image').attr('src',image_url);
        $('#imageModal').modal('show');
    });

    $('body').on('click','.btn-remove-edit',function(){
        if(confirm('¿Seguro que desea quitar esta imagen?')){
            $(this).parent('.file-unity-edit').remove();
        };
    })

    /***********************************************************************
     * Comment buttons
     ***********************************************************************/

     $('.btn-edit').on('click', function(event) { 
        
        var div = $(this).closest('.detail-description');
        var id = div.find('.timeline-item').data('detailid');
        var date = div.prev().find('.detail-date').data('date');
        var time = div.find('.detail-time').data('time');
        var description = div.find('.detail-description-span').html();

        var files = []
        div.find('.detail-file').each(function( index ){
            var item = {
                id: $(this).data('id'),
                name: $(this).data('name')
            }
            files.push(item);
        });
        
        var detail = {
            id: id,
            date: date,
            time: time,
            description: description,
            files : files
        }
        //console.log(detail);
        showEditModal(detail);

     });

     function showEditModal(detail){
        console.log(detail);

        $('#editDetailModal').find('input[name="detail_id"]').val(detail.id);
        $('#editDetailModal').find('input[name="date"]').val(detail.date+" "+detail.time);
        $('#editDetailModal').find('textarea[name="description"]').html(detail.description);
            
        $('#editDetailModal .archive-list').empty();
        $('#editDetailModal .file-array').empty();
        for (i = 0; i < detail.files.length; i++) { 
            var input = '<div class="file-unity-edit" data-id="'+detail.files[i].id+'"><i class="glyphicon glyphicon-remove btn-remove-edit"></i>'+detail.files[i].name;
            input+='<input type="hidden" name="old_files_id[]" value="'+detail.files[i].id+'">'; 
            input+='</div>'; 
            var f = $(input);
            $('#editDetailModal .archive-list').append(f);
        }
        
        $('#editDetailModal').modal('show');
     }

     $('#editDetailModal .btn-save-detail').on('click', function(e){
        
        var text = $('#editDetailModal textarea[name="description"]').val().trim().length;

        if (text == 0){
            $('#editDetailModal textarea[name="description"]').parent('.form-group').addClass('has-error');
            return false;
        } else {
            return true;
        }
        
     });
});