$(document).ready(function() {
    
    // var prof_id = 2;
    // var prof_name = 'Walter';
    
    var getProfessionalId = function(){
        return prof_id;
    }

    var getProfessionalName = function() {
        
        return prof_name;
    }
    var getDateSelected = function() {
        
        return $('#calendar').fullCalendar('getDate').format('YYYY-MM-DD');
    }

    var getNumberOfAppointments = function() {
        
        $number = $('.fc-list-item-title :not(:contains("Libre"))').length;        
        
        return $number;

    }

    /**************************************************************************
     * Full Calendar Sources
     **************************************************************************/
    var viewRender = function(view, element) {
        if(view.name=="agendaWeek" || view.name=="agendaDay"){
            $('.fc-print-button').hide();
            $('.fc-listDay-button').removeClass("fc-state-active");
            $('.fc-agendaDay-button').addClass("fc-state-active");
        }else{
            $('.fc-print-button').show();
            $('.fc-listDay-button').addClass("fc-state-active");
            $('.fc-agendaDay-button').removeClass("fc-state-active");
        }
    }

    var fcSources = {
        availables: {
            url: '/api/calendar/appointments',
            type: 'POST',
            data: function() {
                    return {
                        api_token : localStorage.getItem('api_token'),
                        status: '0', //Libre
                        professional_id: getProfessionalId(),
                    };
            },
            error: function() {
                //alert('Ocurrió un error al cargar los turnos. Por favor intentelo más tarde.');
            },
            color: '#DFF0D8',   // a non-ajax option
            textColor: '#444444' // a non-ajax option
        },
        taken: {
            url: '/api/calendar/appointments',
            type: 'POST',
            data: function() {
                    return {
                        api_token : localStorage.getItem('api_token'),
                        status: '1', //Ocupado
                        professional_id: getProfessionalId()
                    }
            },
            error: function() {
                //alert('Ocurrió un error al cargar los turnos. Por favor intentelo más tarde.');
            },
            color: '#D7F0F7',   // a non-ajax option
            textColor: '#444444' // a non-ajax option
        },
        waiting: {
            url: '/api/calendar/appointments',
            type: 'POST',
            data: function() {
                    return {
                        api_token : localStorage.getItem('api_token'),
                        status: '2', //En Espera
                        professional_id: getProfessionalId()
                    }
            },
            error: function() {
                //alert('Ocurrió un error al cargar los turnos. Por favor intentelo más tarde.');
            },
            color: '#FFB878', // naranja
            textColor: '#444444' // a non-ajax option
        },
        ended: {
            url: '/api/calendar/appointments',
            type: 'POST',
            data: function() {
                    return {
                        api_token : localStorage.getItem('api_token'),
                        status: '3', //Finalizado
                        professional_id: getProfessionalId(),
                        //medical_study_id: getMedicalStudyId()
                    }
            },
            error: function() {
                //alert('Ocurrió un error al cargar los turnos. Por favor intentelo más tarde.');
            },
            color: '#f8d7da',   // a non-ajax option
            textColor: '#444444' // a non-ajax option
        },
        canceled: {
            url: '/api/calendar/appointments',
            type: 'POST',
            data: function() {
                    return {
                        api_token : localStorage.getItem('api_token'),
                        status: '4', //Cancelado
                        professional_id: getProfessionalId()
                    }
            },
            error: function() {
                //alert('Ocurrió un error al cargar los turnos. Por favor intentelo más tarde.');
            },
            color: '#E1E1E1',   // a non-ajax option
            textColor: '#444444' // a non-ajax option
        }

    };


    /********************************************************************
     * CARGA DINAMICA DE HORARIOS DEL CALENDARIO
     ********************************************************************/
    
    //defaults
    var times = [
        ['07:00:00', '23:00:00'], //domingo
        ['07:00:00', '23:00:00'], //lunes
        ['07:00:00', '23:00:00'], //martes
        ['07:00:00', '23:00:00'], //miercoles
        ['07:00:00', '23:00:00'], //jueves
        ['07:00:00', '23:00:00'], //viernes
        ['07:00:00', '23:00:00'], //sabado
    ];

    getMinMaxCalendarTime().then(function(jsonResponse){
        times = jsonResponse;
    }, function(reason){
        console.log(reason);
    });
    
    var currentDate = moment(new Date()).add(1,'days');
    
    var nextDate = moment(new Date());

    var updateCalendarMinMaxTime = function(){        
        day = nextDate.day();
        if( !nextDate.isSame(currentDate,'day') ){
            currentDate = nextDate.clone(true);
            $("#calendar").fullCalendar('destroy');
            
            $("#calendar").fullCalendar(
                $.extend(fcOpts, {
                    defaultDate : currentDate,
                    minTime: times[day][0],
                    maxTime: times[day][1]
                })
            );
        }
    }

    $('body').on('click', 'button.fc-prev-button', function() {
       nextDate = nextDate.subtract(1,'days');
    });

    $('body').on('click', 'button.fc-next-button', function() {
       nextDate = nextDate.add(1,'days');
    });

    var initialMinTime = '10:00:00';
    var initialMaxTime = '22:00:00';

    var fcOpts = {
        // put your options and callbacks here
        eventOrder: 'id',
        locale: 'es',
        defaultView: 'agendaDay',
        slotDuration: '00:10:00',
        timeFormat: 'H:mm', // uppercase H for 24-hour clock
        minTime: initialMinTime,
        maxTime: initialMaxTime,
        allDaySlot: false,
        displayEventEnd: false,
        buttonText: 
            {
                listDay: 'Lista',
                listWeek: 'Lista de semana',
                agendaDay: 'Agenda'
            },
        header :
            {
                left: 'prev',
                center: 'title',
                right: 'next'
            },
        contentHeight: 400,
        height: 200,
        customButtons: {
        //     enable_all: {
        //         text: 'Crear Todos',
        //         click: function() {
        //             habilitar($('#calendar').fullCalendar('getView'));
        //         }
        //     },
        //     disable_all: {
        //         text: 'Eliminar Todos',
        //         click: function() {
        //             alert(); 
        //         }
        //     },
        //     enable_one: {
        //         text: 'Crear uno',
        //         click: function() {
        //             createUniqueAppointment();
        //         }
        //     },
            print_day: {
                text: 'Imprimir',
                click: function() {
                    printAgenda($('#calendar').fullCalendar('getView'));
                }
            }
        },
        viewRender: function(view, element) {
            viewRender(view, element);
            
        },
        // eventRender: function(event, element) {
        //     total_money += event.money;
        //     total_coupons += event.coupons;
        //     //console.log('render');
        //     element.find('.fc-content').prepend( "<i  class='fa fa-close pull-left text-danger' id='delete'></i>" );
        // },
        eventAfterAllRender: function(view){
            // updateTotals();
            
            updateCalendarMinMaxTime();
            
        },
        eventClick: function(calEvent, jsEvent, view) {
            //checkAppointmentReserved(calEvent, jsEvent, view);
            showEditAppointmentModal(calEvent, jsEvent, view);
            //showEditAppointmentModal(calEvent, jsEvent, view);
        },
        // dayClick: function(date, jsEvent, view) {
        //         var day = date.day(); // number 0-6 with Sunday as 0 and Saturday as 6
        //         //alert(day);
        // },
        eventSources: [fcSources.availables, fcSources.taken, fcSources.waiting, fcSources.ended, fcSources.canceled]
    };

    $('#calendar').fullCalendar(fcOpts);

    /**************************************************************************
     * Botones calendario
     **************************************************************************/

    addButtons();

    bindButtonActions();

    function addButtons() {
        /*
         *    View Options
         */
        var agenda = $("<button/>")
            .addClass("fc-agendaDay-button fc-button fc-state-default fc-corner-left fc-state-active")
            .attr({
                unselectable: "on",
                type: "button"
            })
            .text("Agenda");

        var lista = $("<button/>")
            .addClass("fc-listDay-button fc-button fc-state-default fc-corner-right")
            .attr({
                unselectable: "on",
                type: "button"
            })
        .text("Lista");

        /*
         *    New appointments Options
         */
        
        //create left buttons
        // var enable_one = $("<button/>")
        //     .addClass("fc-enable_one-button fc-button-lonely fc-button fc-state-default fc-corner-left fc-corner-right")
        //     .attr({
        //         unselectable: "on",
        //         type: "button"
        //     })
        //     .text("Nuevo Turno");

        /*
         *    Print Options
         */
        var print = $("<button/>")
            .addClass("fc-print-button fc-button-lonely fc-button fc-state-default fc-corner-left fc-corner-right")
            .attr({
                unselectable: "on",
                type: "button"
            })
            .hide()
        .text("Imprimir");

        var toolbar = $("<div/>")
            .addClass("fc-toolbar fc-header-toolbar fc-custom-toolbar")
            .append(
                $("<div/>")
                .addClass("fc-left")
                // .append(enable_one)
                .append(print)
            )
            .append(
                $("<div/>")
                .addClass("fc-right")
                .append(agenda)
                .append(lista)
            );
        

        // insert row before title.
        $("#addedButtons").before(toolbar);
    }

    function bindButtonActions(){
        // bind actions to buttons
        $(".fc-agendaDay-button, .fc-listDay-button").on('click', function() {
            $('.fc-agendaDay-button, .fc-listDay-button').removeClass("fc-state-active");
            var view = "agendaDay";
            if ($(this).hasClass("fc-agendaDay-button")) {
                view = "agendaDay";
            } else if ($(this).hasClass("fc-listDay-button")) {
                view = "listDay";
            }

            $('#calendar').fullCalendar('changeView', view);
        });

        // $(".fc-enable_one-button").on('click', function(){
            // createUniqueAppointment();
        // });

        $(".fc-print-button").on('click', function(){
            printAgenda($('#calendar').fullCalendar('getView'));
        });
    }

    /**************************************************************************
     * Time picker del calendario
     **************************************************************************/

    var changeDate = function(selectedDate){
        //console.log(selectedDate.getDate());
        nextDate = moment(selectedDate);
        $('.loader').fadeIn('slow');
        $('#calendar').fullCalendar('gotoDate', selectedDate);
        setTimeout(function () {
            $(".loader").fadeOut("slow");
        }, 1000);
    }

    /**************************************************************************
     * Show calendar with dates
     **************************************************************************/
    
    var dates = [];
    
    var initCalendar = function(){

        dates = [
            "2017/12/16, Disponibilidad media, media-disponibility",
            "2017/12/23, Disponibilidad baja, low-disponibility",
        ];

        //initCalendarWithColor(dates);
        
        $.ajax({
            url: '/api/appointments/disponibilityExtended',
            data: { 
                    api_token: localStorage.getItem('api_token'),
                    professional_id : getProfessionalId(),
                    },
            type: "GET",
            success: function (data) {
                initCalendarWithColor(data);
            },
            error: function (data) {
                initCalendarWithColor(null);
            }
        });  
    }

    var initCalendarWithColor = function(dates){        
        var today = new Date();
        
        //console.log(dates);
        
        $('.calendar-date').datetimepicker({   
            highlightedDates: dates,
            inline:true,
            minDate: '2010/01/01',
            timepicker: false,
            onSelectDate: changeDate,
        });
        
        setTimeout(function () {
            $(".loader").fadeOut("slow");
        }, 1000);

        $('.cargando-fechas').hide('slow');
        $('.calendar-form').show('slow')
    }

    initCalendar();


    function getPatientName(calEvent){
        if(calEvent.owner == "me"){
            return calEvent.ownername;    
        } else {
            return calEvent.patient_name + ' ' + calEvent.patient_surname;
        }
    }

    function getPatientSurname(calEvent){
        console.log(calEvent);
        if(calEvent.status == "Libre"){
            return "";
        }
        if(calEvent.owner == "me" && calEvent.patient !== null){
            return calEvent.patient.surname;    
        } else {
            return calEvent.patient_surname;
        }   
    }

    var showEditAppointmentModal = function(calEvent, jsEvent, view) {

        //console.log(calEvent);

        $('#invisible_id').val(calEvent.id);
        $('#patient-datetime').text(calEvent.date + ' ' + calEvent.time + ' hs.');
        $('#patient-name').text(getPatientName(calEvent));
        $('#search-surname').text(getPatientSurname(calEvent));
        $('#patient-os').text(calEvent.insurance_name);
        $('#patient-ms').text(calEvent.medical_study_name);
        $('#patient-comment').val(calEvent.comment);
        $('#patient-status').val(calEvent.status_id);
        $('#editAppointmentModal').modal('show');
    };

    
    function submitEditModal(){
        
        var appointment_id = $('#invisible_id').val();
        console.log($('#patient-status').val() == 0);

        data_array = {
            api_token: localStorage.getItem('api_token'),
            comment: $('#patient-comment').val(),
            status: $('#patient-status option:selected').val()
        };
        if($('#patient-status').val() == 0){
            data_array.patient_id = null;
            data_array.money = null;
            data_array.coupons = null;
            data_array.patient_name = null;
            data_array.patient_surname = null;
            data_array.patient_address = null;
            data_array.patient_primary_phone = null;
            data_array.patient_secondary_phone = null;
            data_array.patient_plan = null;
            data_array.patient_affiliate_number = null;
            data_array.patient_professional = null;
            data_array.patient_email = null;
            data_array.insurance_id = null;
            data_array.owner = "me";
            data_array.comment = null;
            data_array.medical_study_id = null;
        }
        
        $.ajax({
            url: '/api/appointments/'+appointment_id,
            data: data_array,
            type: "PUT",
            success: function () {
                console.log('success');
                $('#calendar').fullCalendar('refetchEvents');
                initCalendar();
                $('#editAppointmentModal').modal('hide');
                updateFlashMessage('success','El turno se actualizó correctamente');
            },
            error: function() {
                $('#editAppointmentModal').modal('hide');
                updateFlashMessage('danger','El turno no se pudo actualizar correctamente. Por favor inténtelo más tarde.');  
            }

        });
    }

    $('#editAppointmentModal').submit(function(event){
        
        event.preventDefault();
        
        console.log('submit');
        
        submitEditModal();
    });


    /**************************************************************************
     * Flash messages
     **************************************************************************/

     var updateFlashMessage = function(type, msg, object = false) {
        
        var div = $('.flash-message').empty();
        if(object){
            var alert = $('<div/>')       
                    .addClass('flash-message list-style-none alert alert-dismissible alert-'+type)
                    .append(msg)
                    .append($('<button type="button" class="close dismiss-button" data-dismiss="alert" aria-hidden="true">×</button>)'));
        }else{
            var alert = $('<div/>')       
                    .addClass('flash-message alert alert-dismissible alert-'+type)
                    .text(msg)
                    .append($('<button type="button" class="close dismiss-button" data-dismiss="alert" aria-hidden="true">×</button>)'));
        }        
        div.append(alert).show();

     }
    /*************************************************************************
    * Autoreload of events in calendar
    *************************************************************************/
    setInterval(function(){
        $('#calendar').fullCalendar('refetchEvents');
        //initCalendar();
        //updateTotals();
    }, 5000);


    /**************************************************************************
     * Printer Function
     **************************************************************************/
     var getPdfHeader = function() {
        
        var pdfHeader = '<h2>Profesional: '+ getProfessionalName() +'</h2>'
                       +'<h3>Fecha: '+ getDateSelected() +'</h2>'
                       +'<h4>Turnos otorgados: ' + getNumberOfAppointments() + ' </h4>';

        return pdfHeader;        
     }

     var printAgenda = function(view) {
        //console.log(getNumberOfAppointments());
        $(".fc-list-table").printThis({
            debug: false,               // show the iframe for debugging
            importCSS: false,            // import page CSS
            importStyle: false,         // import style tags
            printContainer: true,       // grab outer container as well as the contents of the selector
            loadCSS: "css/printThis.css",  // path to additional css file - use an array [] for multiple
            removeInline: false,        // remove all inline styles from print elements
            printDelay: 333,            // variable print delay; depending on complexity a higher value may be necessary
            header: getPdfHeader(), // prefix to html
            footer:  $('.hidden-print-header-content'),               // postfix to html
            base: false ,               // preserve the BASE tag, or accept a string for the URL
            formValues: true,           // preserve input/form values
            canvas: false,              // copy canvas elements (experimental)
            removeScripts: false        // remove script tags from print content
        });
     }
});