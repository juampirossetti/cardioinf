function formValidation(){
    var description = $('body').find('#detailForm textarea');
    if (description.val().trim().length == 0){
        description.parent('.form-group').addClass('has-error');
        return false;
    }
    
    return true;
}
