$(document).ready(function() {
    $('.send-email-btn').on('click', function(){
        $email = $(this).attr('email');
        url = '/management/mailbox/create?email='+$email;
        window.open(url, '_blank');
    });

});