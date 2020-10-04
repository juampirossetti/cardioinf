$(document).ready(function() {
    var detectDevice = function(){
        if($(window).width() <= 992){
             return 'mobile';
        } else {
            return 'desktop';
        }
    }
     
    var device = detectDevice();

    $(".select2").select2();

    $('.control-down').click(function () {
        $(this).siblings('ul').animate({
            scrollTop: '+=100'
        }, 100);
    });

    $('.control-up').click(function () {
        $(this).siblings('ul').animate({
            scrollTop: '-=100'
        }, 100);
    });

    var paciente_original = $('#patient-text').html();

    function updateNombrePaciente(){
        name = '';
        if($('input[type=radio][name=appointment_owner][value="me"]').is(':checked')){ 
            //si el paciente es el usuario, entonces uso el nombre de usuario
            name = paciente_original;
        } else { 
            //si el paciente es otro utilizo la info de las casillas paciente
            name = $('#patient_name').val() + ' ' + $('#patient_surname').val();
        }

        $('#patient-text').html(name);
        $('input[name=patient_name]').val($('#patient_name').val());
        $('input[name=patient_surname]').val($('#patient_surname').val());
        
    }
    $('input[type=radio][name=appointment_owner]').change(function() {
        if (this.value == 'me') {
            $(this).closest('.patient-radio').find('.patient-information').hide();
            $('input[name=owner]').val("me");
        }
        else if (this.value == 'other') {
            $(this).closest('.patient-radio').find('.patient-information').show();   
            $('input[name=owner]').val("other");
        }
        updateNombrePaciente();
    });

    function init_radio(){
        if($('input[type=radio][name=appointment_owner][value="me"]').is(':checked')){
            $('.patient-information').hide();
            $('input[name=owner]').val("me");
        } else {
            $('.patient-information').show();
            $('input[name=owner]').val("other");
        }
        updateNombrePaciente();
    }

    init_radio();

    $('.patient-input').on('keyup', function(){
    updateNombrePaciente(); 
    });
    
    //$('.insurance-select').on('change',function(){
    //    /* Get the selected values */
    //    //$('.small-loader').fadeIn('slow');
    //    var name = $(this).find(":selected").text();
    //    var id = $(this).find(":selected").val();
        
    //    /* Set the name and the id in the correct fields */
    //    $('#insurance-text').text(name);
    //    $('input[name=insurance_id]').val(id);
    //});

    //$('.medical-study-select').on('change',function(){
    //    //$('.small-loader').fadeIn('slow');
        /* Get the selected values */
    //    var name = $(this).find(":selected").text();
    //    var id = $(this).find(":selected").val();
        
        /* Set the name and the id in the correct fields */
    //    $('#medical-study-text').text(name);
    //    $('input[name=medical_study_id]').val(id);
        //$('.loader').fadeIn('slow');
    //});

    var selected_time = null;

    $('.hour-list').on('click','a',function(){
        if ($(this).is(selected_time)){
            return;
        }
        selected_time = $(this);
        changeSelectedTimeStyles($(this));
        reserveAppointment($('input[name=date]').val() , $('input[name=time]').val());
        // Remove other active element
    });

    var changeSelectedTimeStyles = function(elem){
        $('.hour-list a').removeClass('active');
        
        //add active class to this element
        elem.addClass('active')

        //change time value in confirmation section
        var time = elem.text();
        var date = elem.closest('div').find('.title').text();
        $('#date-text').text(date+' '+time + ' hs.');
       
        //set date and time in the form
        var date_value = elem.closest('div').find('.date-value').val();
        console.log(date_value);
        $('input[name=date]').val(date_value);
        $('input[name=time]').val(time);
    }


    /**************************************************************************
     * Slider functions hide and show navigation
     **************************************************************************/

     var checkitem = function() {
        var $this;
        var elem = (device == 'mobile') ? '#mobile-carouselshow' : '#carouselshow';
        $this = $(elem);
        if ($(elem + " .carousel-inner .item:first").hasClass("active")) {
            $this.children(".left").hide();
            $this.children(".right").show();
        } else if ($(elem + " .carousel-inner .item:last").hasClass("active")) {
            $this.children(".right").hide();
            $this.children(".left").show();
        } else {
            $this.children(elem + " .carousel-control").show();
        }
    };

    checkitem();

    $("#carouselshow").on("slid.bs.carousel", "", checkitem);
    $("#mobile-carouselshow").on("slid.bs.carousel", "", checkitem);

    /**************************************************************************
    * Insurance Messages, Enabled and Disabled Appointments
    **************************************************************************/
    
    var insuranceEnabled = true;

    var showOrHideCarousel = function(){
        console.log('OS:' + insuranceEnabled);
        if(!insuranceEnabled || ($('#medical_study_id option:selected').val() == 'null' ||
           $('#insurance_id option:selected').val() == 'null')){
            $('.carousel-msg').hide();
            $('.unselect-professional').show();
            $('input[name=appointment_id]').val(null);
            $('input[name=date]').val(null);
            $('input[name=time]').val(null);
            $('#date-text').text('Seleccionar');
            console.log('')
            // $('.loader').fadeOut('slow');
            //$('#patient-loading-msg').hide();
        } else {
            getAppointments(getDateToday(), getEndDate(), getProfessionalID(),getMedicalStudyID());
            $('.carousel-msg').hide();
            //$('#patient-loading-msg').show();
            $('.appointments-carousel').show();
            initCalendar();
        }
     }
    
    $('#medical_study_id').on('change',function(){
        insuranceEnabled = true;
        //$('.loader').fadeIn('slow'); 
        /* Get the selected values */
        var name = $(this).find(":selected").text();
        var id = $(this).find(":selected").val();
        
        /* Set the name and the id in the correct fields */
        $('#medical-study-text').text(name);
        $('input[name=medical_study_id]').val(id);
        
        getInsurancesForMs();

        getMessageForInsurance();
        // $('.loader').fadeOut('slow');
        //showOrHideCarousel();        
    });

    var getInsurancesForMs = function(){
        $.ajax({
            url: '/api/insurances/getAvailables',
            data: { 
                    api_token: localStorage.getItem('api_token'),
                    medical_study_id: getMedicalStudyID(),
                    patient_enabled: true
                    },
            type: "GET",
            success: function (data) {
                console.log('Cargando turnos');
                populateInsurancesList(data);
            },
            error: function (data) {
                alert('El sistema no puede procesar su turno actualmente. Por favor intente nuevamente más tarde.')
            }
        });
    }

    var populateInsurancesList = function(insurances){
        console.log('aca');
        $('.insurance-select option').not(":eq(0)").each(function(){
            console.log($(this));
            $(this).remove();
        });

        $.each(insurances, function (i, item) {
            var newOption = new Option(item.name, item.id, false, false);
            $('.select2.insurance-select').append(newOption);
        });
        $('.select2.insurance-select').val("null").trigger('change');
        //insuranceEnabled = false;
        getMessageForInsurance();
        showOrHideCarousel();

    }

    $('#insurance_id').on('change',function(){
        
        insuranceEnabled = true;
        
        //$('.loader').fadeIn('slow'); 
        var name = $(this).find(":selected").text();
        var id = $(this).find(":selected").val();
        /* Set the name and the id in the correct fields */
        $('#insurance-text').text(name);
        $('input[name=insurance_id]').val(id);
        getMessageForInsurance(); 
        // $('.loader').fadeOut('slow');    
    });

    var showInsuranceMessage = function(message){
        $('#insurance-message').hide();
        $('#insurance-message').removeClass('callout-info callout-danger');        
        if(message != null){
            if(insuranceEnabled == false){
                $('#insurance-message').addClass('callout-danger');
                $('#insurance-message h4').html('<i class="icon fa fa-warning"></i>  '+ message);
            }else{
                $('#insurance-message').addClass('callout-info');
                $('#insurance-message h4').html('<i class="icon fa fa-info"></i>  ' + message);
            }
            $('#insurance-message').show();
        }
    }

    var getMessageForInsurance = function(){
        console.log('Cargando Mensajes para obra social');
        $.ajax({
            url: '/api/patients/indications',
            data: { 
                    api_token: localStorage.getItem('api_token'),
                    medical_study_id: getMedicalStudyID(),
                    insurance_id: getInsuranceID()
                    },
            type: "POST",
            success: function (data) {
                console.log('Cargando turnos');
                insuranceEnabled = data.enabled_appointment;
                showInsuranceMessage(data.message);
                showOrHideCarousel();
            },
            error: function (data) {
                //console.log('Actualmente el sistema no puede mostrar los turnos. Intente nuevamente más tarde');
                showInsuranceMessage(null);
                showOrHideCarousel();
            }
        });  
    }

/*    
    var getMessageForInsurance = function(){
        console.log('Cargando Mensajes para obra social');
        $.ajax({
            url: '/api/patients/professionals/' + getProfessionalID() +'/insurances/' + getInsuranceID(),
            data: { 
                    api_token: localStorage.getItem('api_token'),
                    },
            type: "POST",
            success: function (data) {
                console.log('Cargando turnos');
                insuranceEnabled = data.enabled_appointment;
                showInsuranceMessage(data.message);
                showOrHideCarousel();
            },
            error: function (data) {
                console.log('Actualmente el sistema no puede mostrar los turnos. Intente nuevamente más tarde');
                showInsuranceMessage(null);
                showOrHideCarousel();
            }
        });  
    }
*/

     
    var getProfessionalID = function(){
        return $('input[name="professional_id"]').val();
    }

    var getMedicalStudyID = function(){
        return $('#medical_study_id option:selected').val();
    }

    var getInsuranceID = function(){
        return $('#insurance_id option:selected').val();
    }

    var getDateToday = function(){
        var date = new Date();

        return date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate();
    }

    var getEndDate = function(){
        var date = new Date()
        date.setDate(date.getDate() + 60); //le agregamos 60 dias a la fecha
        return date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate();    
    }

    /**************************************************************************
     * Get appointments list
     **************************************************************************/

    var getAppointments = function(start_date, end_date, professional_id, medical_study_id) {
        //$('.loader').fadeIn('slow');
        console.log(getProfessionalID());
        $.ajax({
            url: '/api/patients/appointments',
            data: { 
                    api_token: localStorage.getItem('api_token'),
                    start : start_date,
                    end : end_date,
                    professional_id: professional_id, 
                    medical_study_id : medical_study_id,
                    status : 0 },
            type: "POST",
            success: function (data) {
                console.log('Cargando turnos');
                populateAppointmentsList(data);
            },
            error: function (data) {
                console.log('Actualmente el sistema no puede mostrar los turnos. Intente nuevamente más tarde');
            }
        });  
     }

     /**************************************************************************
     * Populate appointments list
     **************************************************************************/

     var populateAppointmentsList = function(data) {
        //console.log('loader');
        $('.appointments-carousel').hide();
        $('.loader').fadeIn('slow');
        $('.no-appointments').remove();
        $('.appointment-item').remove();
        
        var c = 0;
        var day_items = $('.'+device+' .day-item');
        for (var key in data) {
            var day_item = $(day_items.get(c));
            //actualizar día
            day_item.find('.title').html(formatDate(key, 1));
            day_item.find('.date-value').val(key);
            //actualizar lista de turnos
            var scrollable_menu = day_item.find('.scrollable-menu');
            if(data[key].length == 0){ //si no hay turno mostrar mensaje
                $('<div class="no-appointments">Ningún turno disponible para este día</div>').appendTo(scrollable_menu);
            } else { //si hay turnos los cargo
                for(var i = 0; i < data[key].length; i++){
                    $('<li class="appointment-item"><a href="javascript:void(0);">'+ data[key][i]+'</a></li>').appendTo(scrollable_menu);
                }
            }
            c++;
        }
        $('.appointments-carousel').show();
        $('.loader').fadeOut('slow');
     }

     var formatDate = function(date, format = 0) {
        var monthNames = [
            "Enero", "Febrero", "Marzo",
            "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre",
            "Noviembre", "Diciembre"
        ];

        var dayNames = [
            "Domingo", "Lunes", "Martes", 
            "Miércoles", "Jueves", "Viernes", 
            "Sábado"
        ]

        var dmy = date.split("-");

        var d = new Date(dmy[0], dmy[1] - 1, dmy[2]);

        var dayIndex = d.getDay();
        var day = d.getDate();
        
        var monthIndex = d.getMonth();
        var year = d.getFullYear();

        if (format == 0) {
            return dayNames[dayIndex] +' '+ day + ' de ' + monthNames[monthIndex] + ' de ' + year;
        }

        if(format == 1){
            return dayNames[dayIndex] +' '+ day + '-' + (monthIndex+1) + '-' + year;
        }

        return '';
    }


    /**************************************************************************
     * Reserve Appointment
     **************************************************************************/
    
    var reserveAppointment = function(date, time) {
        // var date = $('input[name=date]').val();
        // var time = $('input[name=time]').val();
        var professional_id = $('input[name=professional_id]').val();

        console.log('reserva de turno');
        $.ajax({
            url: '/api/reservations',
            data: { 
                    api_token: localStorage.getItem('api_token'),
                    date : date,
                    time : time,
                    professional_id: professional_id,
                    medical_study_id : getMedicalStudyID()
                },
            type: "POST",
            success: function (data) {
                console.log('Turno reservado correctamente');
                if(data.data != null){
                    $('input[name=appointment_id]').val(data.data.id);
                }
            },
            error: function (data) {
                console.log('No se pudo reservar el turno. Intente nuevamente más tarde');
                $('.carousel-ms').hide();
                //$('#patient-error-msg').show();
                alert('El turno seleccionado fue recientemente otorgado. Por favor seleccione otro horario.');
                //actualizacion de los turnos
                getAppointments(getDateToday(), getEndDate(), getProfessionalID(),getMedicalStudyID());
            }
        });  
     }

     //reserveAppointment(null, null);
     
     /**************************************************************************
     * Timer
     **************************************************************************/

    var showModalEndOfTime = function(){
        alert('El tiempo de reserva ha finalizado. Por favor gestione nuevamente su turno.');
        window.location.replace('/patient/professionals');
    }

    var interval_init = function(){
        timer2 = $('#timer').html();
        interval = setInterval(function() {
            var timer = timer2.split(':');
            //by parsing integer, I avoid all extra string processing
            var minutes = parseInt(timer[0], 10);
            var seconds = parseInt(timer[1], 10);
            --seconds;
            minutes = (seconds < 0) ? --minutes : minutes;
          
            seconds = (seconds < 0) ? 59 : seconds;
            seconds = (seconds < 10) ? '0' + seconds : seconds;
            //minutes = (minutes < 10) ?  minutes : minutes;
            if (minutes < 0){
                showModalEndOfTime();
                clearInterval(interval);
            } else {
                $('#timer').html(minutes + ':' + seconds);
            }
            timer2 = minutes + ':' + seconds;
        }, 1000);
    };

    interval_init();
    
    getMessageForInsurance();
    
    var init = function(){
        $('.'+device).show();

        /* Get the selected values */
        var insurance = $('.insurance-select').find(":selected").text();
        var medical_study = $('.medical-study-select').find(":selected").text();
        
        /* Set the name and the id in the correct fields */
        $('#insurance-text').text(insurance);
        $('#medical-study-text').text(medical_study);
    };
    
    init();

    /**************************************************************************
     * Show calendar
     **************************************************************************/
    
    var dates = [];
    
    var initCalendar = function(){
        dates = [
            "2017/12/16, Disponibilidad media, media-disponibility",
            "2017/12/23, Disponibilidad baja, low-disponibility",
        ];

        initCalendarWithColor(dates);
        $.ajax({
            url: '/api/appointments/disponibility',
            data: { 
                    api_token: localStorage.getItem('api_token'),
                    professional_id : getProfessionalID(),
                    medical_study_id: getMedicalStudyID()
                    },
            type: "GET",
            success: function (data) {
                console.log('Cargando turnos');
                console.log(data);
                initCalendarWithColor(data);
            },
            error: function (data) {
                console.log('Actualmente el sistema no puede mostrar los turnos. Intente nuevamente más tarde');
                initCalendarWithColor(null)
            }
        });  
    }

    var initCalendarWithColor = function(dates){
        $('#carouselshow').carousel(0);
        
        var today = new Date();
        min_date = dates[0].substr(0,10);
        max_date = dates[dates.length-1].substr(0,10);

        $('.datepicker').datetimepicker({   
            minDate: min_date,
            maxDate: max_date,
            value: today,
            closeOnDateSelect: true,
            defaultSelect: false,
            timepicker: false,
            format: 'Y-m-d',
            minDate: 0,
            lang: 'es',
            highlightedDates: dates,
            onSelectDate:function(date){
                moveCarousel(date);
            }       
        });
    }

    var moveCarousel = function(date){
        var today = new Date();
        var timeDiff = Math.abs(date.getTime() - today.getTime());
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
        /* Carousel de a 3 dias */
        var carousel_index = Math.floor(diffDays / 3);
        $('#carouselshow').carousel(carousel_index);
        $('.datepicker').datetimepicker({
            value: date,
        });
        /* Carousel individual (mobile) */
        $('#mobile-carouselshow').carousel(diffDays);

    }

    function checkPatientName(){
        if($('#patient_name').val().trim() == "" || $('#patient_surname').val().trim() == ""){
            alert('El nombre y apellido del paciente no pueden estar vacíos.');
            return false;
        } else {
            return true;
        }
    }
    $('.confirm-submit').on('click',function(e){
        
        e.preventDefault();
        
        if(checkPatientName()){
            $(this).closest('form').submit();
        }
        
    });

});