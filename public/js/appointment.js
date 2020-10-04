$(document).ready(function() {

    // ------------------------------------------------//
    // Time Timepicker - Logic
    // ------------------------------------------------//
    //$.datetimepicker.setLocale('es');

    $('#timepicker').datetimepicker({   
        datepicker:false,
        format:'H:i',
        step: 10,
        minTime: '06:00',
        maxTime: '21:01',
        onGenerate:function( ct ){
            $(this).addClass('hidden-disabled')
        }
        }
    );

    $('#datepicker').datetimepicker({   
        timepicker: false,
        format: 'Y-m-d',
        minDate: 0,
        lang: 'es'        
        }
    );
});