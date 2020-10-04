$(document).ready(function() {
    
    var getTurn = function(){
        return $('#turnpicker option:selected').text();
    }

    // ------------------------------------------------//
    // From Timepicker - Logic
    // ------------------------------------------------//
    var fromTimepickerLogic = function (ct) {
        if(getTurn() == 'Tarde') {
            this.setOptions({
                minTime: '13:00',
                maxTime: $('#untiltimepicker').val() ? $('#untiltimepicker').val() : '21:01'
            });
        } else {
            this.setOptions({
                minTime: '07:00',
                maxTime: $('#untiltimepicker').val() ? $('#untiltimepicker').val() : '13:01'
            });
        }
    };
    
    $('#fromtimepicker').datetimepicker({   
        datepicker:false,
        format:'H:i',
        step: 15,
        onShow: fromTimepickerLogic
        }
    );

    // ------------------------------------------------//
    // Until Timepicker - Logic
    // ------------------------------------------------//
    var untilTimepickerLogic = function (ct) {
        if(getTurn() == 'Tarde') {
            this.setOptions({
                minTime: $('#fromtimepicker').val() ? $('#fromtimepicker').val() : '13:00',
                maxTime: '21:01'
            });
        } else {
            this.setOptions({
                minTime: $('#fromtimepicker').val() ? $('#fromtimepicker').val() : '07:00',
                maxTime: '13:01'
            });
        }
    };

    $('#untiltimepicker').datetimepicker({   
        datepicker:false,
        format:'H:i',
        step: 15,
        onShow: untilTimepickerLogic
        }
    );

    // ------------------------------------------------//
    // Delta between times timepicker
    // ------------------------------------------------//
    $('#deltatimepicker').datetimepicker({   
        datepicker:false,
        format:'H:i',
        step:5,
        minTime: '00:10',
        maxTime: '01:00',
        onGenerate:function( ct ){
            $(this).addClass('hidden-disabled')
        },
    });

    // ------------------------------------------------//
    // Others
    // ------------------------------------------------//
    var resetTimepickers = function(){
        $('#untiltimepicker').datetimepicker('reset');
        $('#untiltimepicker').val('');
        $('#fromtimepicker').datetimepicker('reset');
        $('#fromtimepicker').val('');
        
    }
    $('#turnpicker').change(function() {
        resetTimepickers();
    });
});