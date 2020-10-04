
jQuery(document).ready(function() {
	
    /*
        Fullscreen background
    */
    $.backstretch(ASSET_URL + "auth/img/backgrounds/1.jpg");
    console.log(ASSET_URL);
    /*
        Login form validation
    */
    $('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on('focus', function() {
    	$(this).removeClass('input-error');
    });
    
    /*
        Registration form validation
    */
    $('.registration-form input[type="text"], .registration-form textarea').on('focus', function() {
    	$(this).removeClass('input-error');
    });    
    
});
