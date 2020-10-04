$(document).ready(function() {
    /**************************************************************************
     * Date and Time pickers
     **************************************************************************/
    var options = { 
        twentyFour: true, //Display 24 hour format, defaults to false 
        title: 'Seleccione un horario', //The Wickedpicker's title, 
        minutesInterval: 5, //Change interval for minutes, defaults to 1 
    };
        
    $('.timepicker').each(function(){
      options.now = $(this).data('time');
      $(this).wickedpicker(options);    
    })
    

    $('#calendarForm').submit(function() {
      
      var global_empty_error = false;
      var global_error = false;
      var global_incompatible_error = false;

      var empty_error = false;
      var incompatible_error = false;
      $('table.calendar-time tbody tr').each(function() {
        empty_error = false;
        incompatible_error = false;
        var time1 = $(this).find('input[name^="calendar"]').first(); //hora inicio
        var time2 = $(this).find('input[name^="calendar"]').last(); //hora inicio
        
        if( isValidTime( time1.val() ) && 
            isValidTime( time2.val() ) && 
            greaterThan(time1.val(),time2.val()) ){
           //time1.closest('.form-group').addClass('has-error');
           //time2.closest('.form-group').addClass('has-error');
           global_incompatible_error = true;
           global_error = true;
           incompatible_error = true;
        } 

        if(!isValidTime( time1.val() ) ) {
          time1.closest('.form-group').addClass('has-error');
          global_empty_error = true;
          global_error = true;
          empty_error = true;
        } else {
          time1.closest('.form-group').removeClass('has-error');
        }

        if(!isValidTime( time2.val() ) ) {
          time2.closest('.form-group').addClass('has-error');
          global_empty_error = true;
          global_error = true;
          empty_error = true;
        } else {
          time2.closest('.form-group').addClass('has-error');
        }

        if(incompatible_error){
          time1.closest('.form-group').addClass('has-error');
          time2.closest('.form-group').addClass('has-error');
        } else {
          if(!empty_error){
            time1.closest('.form-group').removeClass('has-error');
            time2.closest('.form-group').removeClass('has-error');
          }
        } 
      });

      // //format errors
      // $('input[name^="calendar"]').each(function() {
      //   if(!isValidTime( $(this).val() ) ) {
      //     $(this).closest('.form-group').addClass('has-error');
      //     empty_error = true;
      //     error = true;
      //   } else {
      //     $(this).closest('.form-group').removeClass('has-error');
      //   }
      // });
      
      if(global_empty_error){
        $('.empty-time').show();
      } else {
        $('.empty-time').hide();
      }
      if(global_incompatible_error){
        $('.incompatible-time').show(); 
      } else {
        $('.incompatible-time').hide(); 
      }
      if(global_error){
        $('.calendar-error').show();
        return false;
      }
      //return false;    
    });

    function isValidTime(time) {
      time = time.replace(/\s/g,'');
      var valid = (time.search(/^\d{2}:\d{2}/) != -1) &&
            (time.substr(0,2) >= 0 && time.substr(0,2) <= 24) &&
            (time.substr(3,2) >= 0 && time.substr(3,2) <= 59);

      return valid;
    }

    function greaterThan(time1,time2){
      time1 = time1.replace(/\s/g,'');
      time2 = time2.replace(/\s/g,'');
      console.log(time1);
      console.log(time2);

      return time1 >= time2;
    }

});