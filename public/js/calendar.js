$(document).ready(function () {
  var total_money = 0;
  var total_coupons = 0;

  $('#total-coupons').html('Calculando...');
  $('#total-money').html('Calculando...');

  /**************************************************************************
   * Getters
   **************************************************************************/
  var getProfessionalIdSelected = function () {
    return $('#professional option:selected').val();
  };

  var getMedicalStudyIdSelected = function () {
    var study_id = $('#medical_study option:selected').val();
    if (study_id == 'null') {
      study_id = null;
    }
    return study_id;
  };

  var getProfessionalNameSelected = function () {
    return $('#professional option:selected').text();
  };
  var getDateSelected = function () {
    return $('#calendar').fullCalendar('getDate').format('YYYY-MM-DD');
  };

  var getNumberOfAppointments = function () {
    $number = $('.fc-list-item-title :not(:contains("Libre"))').length;
    return $number;
  };

  var getStartWeekDateSelected = function () {
    return $('#calendar').fullCalendar('getView').intervalStart.format('YYYY-MM-DD');
  };

  var getEndWeekDateSelected = function () {
    return $('#calendar').fullCalendar('getView').intervalEnd.format('YYYY-MM-DD');
  };

  /**************************************************************************
   * Full Calendar Sources
   **************************************************************************/
  var fcSources = {
    availables: {
      url: '/api/calendar/appointments',
      type: 'POST',
      data: function () {
        return {
          api_token: localStorage.getItem('api_token'),
          status: '0', //Libre
          professional_id: getProfessionalIdSelected(),
          medical_study_id: getMedicalStudyIdSelected(),
        };
      },
      error: function () {
        //alert('Ocurrió un error al cargar los turnos. Por favor intentelo más tarde.');
      },
      color: '#DFF0D8', // a non-ajax option
      textColor: '#444444', // a non-ajax option
    },
    taken: {
      url: '/api/calendar/appointments',
      type: 'POST',
      data: function () {
        return {
          api_token: localStorage.getItem('api_token'),
          status: '1', //Ocupado
          professional_id: getProfessionalIdSelected(),
          medical_study_id: getMedicalStudyIdSelected(),
        };
      },
      error: function () {
        //alert('Ocurrió un error al cargar los turnos. Por favor intentelo más tarde.');
      },
      color: '#D7F0F7', // a non-ajax option
      textColor: '#444444', // a non-ajax option
    },
    waiting: {
      url: '/api/calendar/appointments',
      type: 'POST',
      data: function () {
        return {
          api_token: localStorage.getItem('api_token'),
          status: '2', //En Espera
          professional_id: getProfessionalIdSelected(),
          medical_study_id: getMedicalStudyIdSelected(),
        };
      },
      error: function () {
        //alert('Ocurrió un error al cargar los turnos. Por favor intentelo más tarde.');
      },
      color: '#FFB878', // naranja
      textColor: '#444444', // a non-ajax option
    },
    ended: {
      url: '/api/calendar/appointments',
      type: 'POST',
      data: function () {
        return {
          api_token: localStorage.getItem('api_token'),
          status: '3', //Finalizado
          professional_id: getProfessionalIdSelected(),
          medical_study_id: getMedicalStudyIdSelected(),
        };
      },
      error: function () {
        //alert('Ocurrió un error al cargar los turnos. Por favor intentelo más tarde.');
      },
      color: '#f8d7da', // a non-ajax option
      textColor: '#444444', // a non-ajax option
    },
    canceled: {
      url: '/api/calendar/appointments',
      type: 'POST',
      data: function () {
        return {
          api_token: localStorage.getItem('api_token'),
          status: '4', //Cancelado
          professional_id: getProfessionalIdSelected(),
          medical_study_id: getMedicalStudyIdSelected(),
        };
      },
      error: function () {
        //alert('Ocurrió un error al cargar los turnos. Por favor intentelo más tarde.');
      },
      color: '#E1E1E1', // a non-ajax option
      textColor: '#444444', // a non-ajax option
    },
  };

  /**************************************************************************
   * Full Calendar
   **************************************************************************/
  // @CARDIOINFANTIL
  var updateButtons = function () {
    var day_name = $('#calendar').fullCalendar('getDate');
    console.log('Day: Professional ID', getProfessionalIdSelected());
    console.log('Day: ', day_name.format('dddd'));
    // if (getProfessionalIdSelected() == 1 || getProfessionalIdSelected() == 3) {
    //   if (day_name.format('dddd') == 'viernes') {
    //     $('.fc-custom-toolbar .fc-left').hide();
    //   } else {
    //     $('.fc-custom-toolbar .fc-left').show();
    //   }
    // } else {
    // Hide buttons if we are on friday appointments and we select another day
    if (getProfessionalIdSelected() == 5 && day_name.format('dddd') != 'viernes') {
      $('.fc-custom-toolbar .fc-left').hide();
    } else {
      $('.fc-custom-toolbar .fc-left').show();
    }
    // }
  };
  // @END

  $('select#professional').on('change', function () {
    updateButtons();
  });

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

  getMinMaxCalendarTime().then(
    function (jsonResponse) {
      times = jsonResponse;
    },
    function (reason) {
      console.log(reason);
    }
  );

  var currentDate = moment(new Date()).add(1, 'days');

  var nextDate = moment(new Date());

  var updateCalendarMinMaxTime = function () {
    day = nextDate.day();
    if (!nextDate.isSame(currentDate, 'day')) {
      currentDate = nextDate.clone(true);
      $('#calendar').fullCalendar('destroy');

      $('#calendar').fullCalendar(
        $.extend(fcOpts, {
          defaultDate: currentDate,
          minTime: times[day][0],
          maxTime: times[day][1],
        })
      );
    }
  };

  $('body').on('click', 'button.fc-prev-button', function () {
    nextDate = nextDate.subtract(1, 'days');
  });

  $('body').on('click', 'button.fc-next-button', function () {
    nextDate = nextDate.add(1, 'days');
  });

  var viewRender = function (view, element) {
    if (view.name == 'agendaWeek' || view.name == 'agendaDay') {
      $('.fc-print-button').hide();
      $('.fc-listDay-button').removeClass('fc-state-active');
      $('.fc-agendaDay-button').addClass('fc-state-active');
    } else {
      $('.fc-print-button').show();
      $('.fc-listDay-button').addClass('fc-state-active');
      $('.fc-agendaDay-button').removeClass('fc-state-active');
    }
    // @CARDIOINFANTIL
    updateButtons();
    // @END
  };

  var calEventObject = null;

  var initialMinTime = times[currentDate.day()][0];
  var initialMaxTime = times[currentDate.day()][1];

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
    buttonText: {
      listDay: 'Lista',
      listWeek: 'Lista de semana',
      agendaDay: 'Agenda',
    },
    header: {
      //left: 'prev,next today',
      //left: 'prev,next today enable_all,enable_one',
      left: 'prev',
      center: 'title',
      right: 'next',
      //center: 'title print_day',
      //right: 'agendaDay,listDay'
    },
    contentHeight: 400,
    height: 200,
    customButtons: {
      enable_all: {
        text: 'Crear Todos',
        click: function () {
          habilitar($('#calendar').fullCalendar('getView'));
        },
      },
      disable_all: {
        text: 'Eliminar Todos',
        click: function () {
          alert();
        },
      },
      enable_one: {
        text: 'Crear uno',
        click: function () {
          createUniqueAppointment();
        },
      },
      print_day: {
        text: 'Imprimir',
        click: function () {
          printAgenda($('#calendar').fullCalendar('getView'));
        },
      },
    },
    viewRender: function (view, element) {
      viewRender(view, element);
    },
    eventRender: function (event, element) {
      total_money += event.money;
      total_coupons += event.coupons;
      //console.log('render');
      element.find('.fc-content').prepend("<i  class='fa fa-close pull-left text-danger' id='delete'></i>");
    },
    eventAfterAllRender: function (view) {
      updateTotals();

      updateCalendarMinMaxTime();
    },
    eventClick: function (calEvent, jsEvent, view) {
      if (jsEvent.target.id === 'delete') {
        //$('#deleteModal').modal();
        showConfirmDialog(calEvent);
        //if(confirm('¿Esta seguro que desea eliminar este turno?')){
        //    deleteAppointment(calEvent);
        //}
      } else {
        checkAppointmentReserved(calEvent, jsEvent, view);
        //showEditAppointmentModal(calEvent, jsEvent, view);
      }
    },
    dayClick: function (date, jsEvent, view) {
      var day = date.day(); // number 0-6 with Sunday as 0 and Saturday as 6
      //alert(day);
    },
    eventSources: [fcSources.availables, fcSources.taken, fcSources.waiting, fcSources.ended, fcSources.canceled],
  };

  $('#calendar').fullCalendar(fcOpts);

  addButtons();

  bindButtonActions();

  function addButtons() {
    /*
     *    View Options
     */
    var agenda = $('<button/>')
      .addClass('fc-agendaDay-button fc-button fc-state-default fc-corner-left fc-state-active')
      .attr({
        unselectable: 'on',
        type: 'button',
      })
      .text('Agenda');

    var lista = $('<button/>')
      .addClass('fc-listDay-button fc-button fc-state-default fc-corner-right')
      .attr({
        unselectable: 'on',
        type: 'button',
      })
      .text('Lista');

    /*
     *    New appointments Options
     */
    var dropdown = $('<span/>')
      .addClass('btn-group')
      .append(
        $('<button/>')
          .addClass('fc-dropdown-button fc-button-lonely fc-button fc-state-default fc-corner-left fc-corner-right')
          .attr({
            'data-toggle': 'dropdown',
            'aria-expanded': 'true',
            id: 'CalendarDropdown',
          })
          .text('Alta')
          .append($('<span/>').addClass('caret'))
      )
      .append(
        $('<ul/>')
          .addClass('dropdown-menu')
          .attr({
            'aria-labelledby': 'CalendarDropdown',
          })
          .append(
            $('<li/>').append(
              $('<a/>')
                .attr({ href: '#' })
                .addClass('fc-enable_all-button fc-button fc-state-default fc-dropdown-li')
                .text('Día')
            )
          )
          .append(
            $('<li/>').append(
              $('<a/>')
                .attr({ href: '#' })
                .addClass('fc-enable_range-button fc-button fc-state-default fc-dropdown-li')
                .text('Período')
            )
          )
      );

    //create left buttons
    var enable_one = $('<button/>')
      .addClass('fc-enable_one-button fc-button-lonely fc-button fc-state-default fc-corner-left fc-corner-right')
      .attr({
        unselectable: 'on',
        type: 'button',
      })
      .text('Nuevo Turno');

    /*
     *    Print Options
     */
    var print = $('<button/>')
      .addClass('fc-print-button fc-button-lonely fc-button fc-state-default fc-corner-left fc-corner-right')
      .attr({
        unselectable: 'on',
        type: 'button',
      })
      .text('Imprimir');

    /*
     *    Remove appointments Options
     */
    var dropdown2 = $('<span/>')
      .addClass('btn-group')
      .append(
        $('<button/>')
          .addClass('fc-dropdown-button fc-button-lonely fc-button fc-state-default fc-corner-left fc-corner-right')
          .attr({
            'data-toggle': 'dropdown',
            'aria-expanded': 'true',
            id: 'CalendarDropdown2',
          })
          .text('Baja')
          .append($('<span/>').addClass('caret'))
      )
      .append(
        $('<ul/>')
          .addClass('dropdown-menu')
          .attr({
            'aria-labelledby': 'CalendarDropdown2',
          })
          .append(
            $('<li/>').append(
              $('<a/>')
                .attr({ href: '#' })
                .addClass('fc-disable-button fc-button fc-state-default fc-dropdown-li')
                .text('Deshabilitar')
            )
          )
          .append(
            $('<li/>').append(
              $('<a/>')
                .attr({ href: '#' })
                .addClass('fc-delete-button fc-button fc-state-default fc-dropdown-li')
                .text('Eliminar')
            )
          )
      );

    var toolbar = $('<div/>')
      .addClass('fc-toolbar fc-header-toolbar fc-custom-toolbar')
      .append(
        $('<div/>')
          .addClass('fc-left')
          .append(enable_one)
          .append(dropdown)
          .append(dropdown2)
          // .append(enable_all)
          // .append(enable_range)
          .append(print)
      )
      .append($('<div/>').addClass('fc-right').append(agenda).append(lista));

    // insert row before title.
    $('#addedButtons').before(toolbar);
  }

  function bindButtonActions() {
    // bind actions to buttons
    $('.fc-agendaDay-button, .fc-listDay-button').on('click', function () {
      $('.fc-agendaDay-button, .fc-listDay-button').removeClass('fc-state-active');
      var view = 'agendaDay';
      if ($(this).hasClass('fc-agendaDay-button')) {
        view = 'agendaDay';
      } else if ($(this).hasClass('fc-listDay-button')) {
        view = 'listDay';
      }

      $('#calendar').fullCalendar('changeView', view);
    });

    $('.fc-enable_one-button').on('click', function () {
      createUniqueAppointment();
    });

    $('.fc-enable_all-button').on('click', function () {
      habilitar($('#calendar').fullCalendar('getView'));
    });

    $('.fc-enable_range-button').on('click', function () {
      habilitarRango($('#calendar').fullCalendar('getView'));
    });

    $('.fc-print-button').on('click', function () {
      printAgenda($('#calendar').fullCalendar('getView'));
    });

    $('.fc-disable-button').on('click', function () {
      $('input[name="action"]').val('disable');
      showRangePickerModal();
    });

    $('.fc-delete-button').on('click', function () {
      $('input[name="action"]').val('delete');
      showRangePickerModal();
    });
  }

  var showConfirmDialog = function (calEvent) {
    $('#send_email').prop('checked', false);

    if (calEvent.patient_id != undefined || calEvent.patient_email != null) {
      //con paciente
      $('#confirmSendEmail').show();
    } else {
      $('#confirmSendEmail').hide();
    }

    calEventObject = calEvent;
    $('#deleteModal').modal();
  };

  $('.deleteModal .btn-submit').on('click', function () {
    $('#deleteModal').modal('toggle');
    var sendEmail = $('#send_email').is(':checked');
    deleteAppointment(calEventObject, sendEmail);
  });
  /**************************************************************************
   * Printer Function
   **************************************************************************/
  var getPdfHeader = function () {
    var pdfHeader =
      '<h2>Profesional: ' +
      getProfessionalNameSelected() +
      '</h2>' +
      '<h3>Fecha: ' +
      getDateSelected() +
      '</h2>' +
      '<h4>Turnos otorgados: ' +
      getNumberOfAppointments() +
      ' </h4>';

    return pdfHeader;
  };

  var printAgenda = function (view) {
    //console.log(getNumberOfAppointments());
    $('.fc-list-table').printThis({
      debug: false, // show the iframe for debugging
      importCSS: false, // import page CSS
      importStyle: false, // import style tags
      printContainer: true, // grab outer container as well as the contents of the selector
      loadCSS: 'css/printThis.css', // path to additional css file - use an array [] for multiple
      removeInline: false, // remove all inline styles from print elements
      printDelay: 333, // variable print delay; depending on complexity a higher value may be necessary
      header: getPdfHeader(), // prefix to html
      footer: $('.hidden-print-header-content'), // postfix to html
      base: false, // preserve the BASE tag, or accept a string for the URL
      formValues: true, // preserve input/form values
      canvas: false, // copy canvas elements (experimental)
      removeScripts: false, // remove script tags from print content
    });
  };

  /**************************************************************************
   * Range appointments modal wrapper
   **************************************************************************/
  var habilitarRango = function (view) {
    var professional = $('#professional option:selected').text();

    $('#rangeProfessionalName').text(professional);

    showNewWeekAppointmentsModal();
  };

  /**************************************************************************
   * New appointments modal wrapper
   **************************************************************************/
  var habilitar = function (view) {
    var professional = $('#professional option:selected').text();

    $('#professionalName').text(professional);
    if (view.name == 'agendaDay' || view.name == 'listDay') {
      $('#modalForm').modal('show');
      initModalCalendar();
    } else {
      showNewWeekAppointmentsModal();
    }
  };

  $('#professional').on('change', function () {
    $('.loader').fadeIn('slow');
    $('#calendar').fullCalendar('refetchEvents');
    console.log('cambio');
    initCalendar();
  });

  $('#medical_study').on('change', function () {
    $('.loader').fadeIn('slow');
    $('#calendar').fullCalendar('refetchEvents');
    //console.log(getMedicalStudyIdSelected());
    initCalendar();
  });

  /**************************************************************************
   * New Day Appointment Modal
   **************************************************************************/
  $('#newAppointmentsModalForm').submit(function (event) {
    event.preventDefault();

    $('input[name="professional_id"]').val(getProfessionalIdSelected());

    $('input[name="date_from"]').val(getDateSelected());

    $('input[name="date_until"]').val(getDateSelected());

    $.ajax({
      url: '/api/calendar/bulk',
      data: $('#newAppointmentsModalForm').serialize(),
      type: 'POST',
      success: function () {
        $('#calendar').fullCalendar('refetchEvents');
        initCalendar();
        $('#modalForm').modal('hide');
        updateFlashMessage('success', 'Los turnos se dieron de alta correctamente');
      },
      error: function () {
        $('#modalForm').modal('hide');
        updateFlashMessage(
          'danger',
          'No se dió de alta ningún turno. Por favor verifique que el profesional trabaje en el día indicado. De ser así, inténtelo de nuevo más tarde.'
        );
      },
    });
  });

  /**************************************************************************
   * Delete / disable appointments
   **************************************************************************/
  var showRangePickerModal = function () {
    resetNewWeekAppointmentModal();

    initModalCalendar();

    $('#rangePickerModal').modal('show');
  };

  /**************************************************************************
   * New Week Appointment Modal
   **************************************************************************/
  var showNewWeekAppointmentsModal = function () {
    resetNewWeekAppointmentModal();
    $('input[name="date_from"]').val('');

    $('input[name="date_until"]').val('');

    initModalCalendar();

    $('#newWeekAppointmentsModal').modal('show');
  };

  $('#newWeekAppointmentsModalForm').submit(function (event) {
    event.preventDefault();

    $('input[name="professional_id"]').val(getProfessionalIdSelected());

    $('.loader').fadeIn('slow');
    $.ajax({
      url: '/api/calendar/bulk',
      data: $('#newWeekAppointmentsModalForm').serialize(),
      type: 'POST',
      success: function () {
        $('#calendar').fullCalendar('refetchEvents');
        initCalendar();
        $('#newWeekAppointmentsModal').modal('hide');
        $('.loader').fadeOut('slow');
        updateFlashMessage('success', 'Los turnos se dieron de alta correctamente');
      },
      error: function (data) {
        $('#newWeekAppointmentsModal').modal('hide');
        $('.loader').fadeOut('slow');
        var obj = JSON.parse(data.responseText);
        var msg = '<ul>';
        msg += '<li>No se dieron de alta los turnos debido a los siguientes errores:</li>';
        for (var key in obj) {
          msg += '<li>' + obj[key][0] + '</li>';
        }
        msg += '</ul>';
        //console.log(msg);
        //updateFlashMessage('danger','No se dió de alta ningún turno. Por favor verifique que el profesional trabaje en el día indicado. De ser así, inténtelo de nuevo más tarde.');
        updateFlashMessage('danger', $(msg), true);
      },
    });
  });

  /**************************************************************************
   * Edit Appointment Modal
   **************************************************************************/

  $('#btn-liberar').on('click', function () {
    $('#patient_id').val(null);
    $('#patient_show_name').val(null);
    $('#insurance_id').val(null);
    $('#status').val(0);
    $('#medical_study_id').val(null);
    $('#comment').val('');
    $('#money').val('');
    $('#coupons').val('');

    resetFieldsSearchPatient(null, true);
  });

  $('#editAppointmentModalForm #patient_id').on('change', function () {
    getPatientInformation($('#patient_id').val());
  });

  var updatePatientInformation = function (data) {
    $('#insurance').val(data.insurance);
    $('#status').val(1);
  };
  var showEditAppointmentModal = function (calEvent, jsEvent, view) {
    console.log(calEvent);

    var professional = $('#professional option:selected').text();
    $('#modalEditAppointment input[name="professional_id"]').val(getProfessionalIdSelected());

    $('#modalEditAppointment #editModalProfessionalName').text(professional);
    $('#modalEditAppointment #invisible_id').val(calEvent.id);
    $('#modalEditAppointment #editModalDate').text(calEvent.date);
    $('#modalEditAppointment #editModalTime').text(calEvent.time);
    $('#modalEditAppointment #patient_id').val(calEvent.pati_id);
    $('#modalEditAppointment #status').val(calEvent.status_id);
    $('#modalEditAppointment #medical_study_id').val(calEvent.medical_study_id);
    $('#modalEditAppointment #comment').val(calEvent.comment);
    $('#modalEditAppointment #money').val(calEvent.money);
    $('#modalEditAppointment #coupons').val(calEvent.coupons);
    if (calEvent.patient != null) {
      $('#modalEditAppointment #send-email-btn').attr('email', calEvent.patient.email);
    } else {
      $('#modalEditAppointment #send-email-btn').attr('email', '');
    }

    //console.log(calEvent.patient.email);

    if (calEvent.owner == 'me') {
      $('#modalEditAppointment #appointment-owner').addClass('hidden');
    } else {
      $('#modalEditAppointment #owner-email').html(calEvent.patient.email);
      $('#modalEditAppointment #appointment-owner').removeClass('hidden');
    }
    resetSearchPatientPanel(calEvent);

    $('.edit-insurance-select option[value="' + calEvent.insurance_id + '"]').prop('selected', true);

    $('#modalEditAppointment #patient_show_name').val('');
    clearAdvancedSearchForm(true);

    if (calEvent.pati_id != null) {
      $('#modalEditAppointment #patient_show_name').val(calEvent.patient.name + ' ' + calEvent.patient.surname);
      console.log('show button');
      updatePatientEditLink('show', calEvent.pati_id);
    } else {
    }

    if (
      (calEvent.pati_id == null || calEvent.owner == 'other') &&
      (calEvent.patient_name != null || calEvent.patient_surname != null)
    ) {
      //console.log(calEvent.patient_name, calEvent.patient_surname);
      setPatientWithoutDni(calEvent.patient_name, calEvent.patient_surname);
      //$("#modalEditAppointment select[name='patient_id'] option:last").attr("selected", "selected");
      $("#modalEditAppointment input[name='patient_id']").val('');
      //cargo el patient-name y patient-surname para el formulario
      $('input.patient-name').val(calEvent.patient_name);
      $('input.patient-surname').val(calEvent.patient_surname);
      $('input.patient-address').val(calEvent.patient_address);
      $('input.patient-primary-phone').val(calEvent.patient_primary_phone);
      $('input.patient-secondary-phone').val(calEvent.patient_secondary_phone);
      $('input.patient-plan').val(calEvent.patient_plan);
      $('input.patient-affiliate-number').val(calEvent.patient_affiliate_number);
      $('input.patient-professional').val(calEvent.patient_professional);
      $('input.patient-email').val(calEvent.patient_email);
      $('#editAppointmentModalForm #patient_insurance_id').val(calEvent.insurance_id);
    }

    initModalCalendar();
    $('#modalEditAppointment').modal('show');
  };

  var checkAppointmentReserved = function (calEvent, jsEvent, view) {
    $.ajax({
      url: '/api/appointment/' + calEvent.id,
      data: {
        api_token: localStorage.getItem('api_token'),
      },
      type: 'GET',
      success: function (data, textStatus, xhr) {
        if (!data.isReserved) {
          reserveAppointment(calEvent, jsEvent, view);
        } else {
          showAlertAppointmentIsReserved();
        }
      },
      error: function (textStatus, xhr) {
        showAlertAppointmentIsReserved();
      },
    });
  };

  var showAlertAppointmentIsReserved = function () {
    alert('El turno acaba de ser reservado por otro paciente de forma online.');
    $('#calendar').fullCalendar('refetchEvents');
    initCalendar();
  };

  var reserveAppointment = function (calEvent, jsEvent, view) {
    $.ajax({
      url: '/api/appointment/' + calEvent.id + '/reserve',
      data: {
        api_token: localStorage.getItem('api_token'),
        id: calEvent.id,
        reserve: 1,
        professional_id: getProfessionalIdSelected(),
      },
      type: 'POST',
      success: function (data, textStatus, xhr) {
        if (!data.isReserved) {
          showEditAppointmentModal(calEvent, jsEvent, view);
        } else {
          showAlertAppointmentIsReserved();
        }
      },
      error: function (textStatus, xhr) {
        showAlertAppointmentIsReserved();
      },
    });
  };

  $('#modalEditAppointment').on('hidden.bs.modal', function () {
    deleteReserveAppointment($('#modalEditAppointment #invisible_id').val());
    updateMessageTotals();
    removePatientsWithoutId();
    initCalendarCalendar();
  });

  $('#uniqueAppointmentModal, #newWeekAppointmentsModal, #rangePickerModal').on('hidden.bs.modal', function () {
    initCalendarCalendar();
  });

  $('.btn-cancel').on('click', function () {
    console.log('a');
    initCalendarCalendar();
  });

  var removePatientsWithoutId = function () {
    var options = $("select[name='patient_id'] option[value='']").each(function () {
      if ($(this).text() != 'Seleccionar') {
        $(this).remove();
      }
    });
  };

  var updateMessageTotals = function () {
    $('#total-coupons').html('Recalculando...');
    $('#total-money').html('Recalculando...');
  };
  var deleteReserveAppointment = function (appointment_id) {
    $.ajax({
      url: '/api/appointment/' + appointment_id + '/reserve',
      data: {
        api_token: localStorage.getItem('api_token'),
        id: appointment_id,
        reserve: 0,
        professional_id: getProfessionalIdSelected(),
      },
      type: 'POST',
      success: function (data, textStatus, xhr) {
        //console.log('Complete.');
      },
      error: function (textStatus, xhr) {
        //console.log('Complete.');
      },
    });
  };

  $('#modalEditAppointment').submit(function (event) {
    event.preventDefault();

    submitEditModal();
  });

  /**************************************************************************
   * Search Patient By Dni
   **************************************************************************/
  var patientFound = false;
  var patientSearched = true;
  var previousValueDni = null;
  var patient_id = null;
  var patient_name = null;
  var patient_surname = null;

  $('.fc-enable_one-button').on('click', function () {
    $('.patient-name').val('');
    $('.patient-surname').val('');
    $('.patient-address').val('');
    $('.patient-primary-phone').val('');
    $('.patient-secondary-phone').val('');
    $('.patient-plan').val('');
    $('.patient-affiliate-number').val('');
    $('.patient-professional').val('');
    $('.patient-email').val('');
  });
  var resetFieldsSearchPatient = function (data = null, forceReset = false) {
    //console.log(data);
    //console.log(patient_id);

    if (data != null && data.patient != null) {
      var patient_info = [];
      patient_info = data.patient;
      //console.log(data);
      setFieldsSearchPatient(patient_info);
      // $('.patient-name').val('');
      // $('.patient-surname').val('');
      // $('.patient-address').val('');
      // $('.patient-primary-phone').val('');
      // $('.patient-secondary-phone').val('');
      // $('.patient-insurance-id').val('');
      // $('.patient-plan').val('');
      // $('.patient-affiliate-number').val('');
      // $('.patient-professional').val('');
      // $('a.patient-edit-link').hide();
    } else {
      if (data != null) {
        console.log(data.patient);
        var patient_info = [];
        patient_info.name = data.patient_name;
        patient_info.surname = data.patient_surname;
        patient_info.address = data.patient_address;
        patient_info.primary_phone = data.patient_primary_phone;
        patient_info.secondary_phone = data.patient_secondary_phone;
        patient_info.plan = data.patient_plan;
        patient_info.affiliate_number = data.patient_affiliate_number;
        patient_info.professional = data.patient_professional;
        patient_info.insurance_id = data.insurance_id;
        patient_info.dni = data.patient != null ? data.patient.dni : '';
        patient_info.email = data.patient_email;
        //console.log(data.patient.dni);
        $('a.patient-edit-link').hide();
        setFieldsSearchPatient(patient_info);
      }
    }

    if (forceReset) {
      $('.patient-name').val('');
      $('.patient-surname').val('');
      $('.patient-address').val('');
      $('.patient-primary-phone').val('');
      $('.patient-secondary-phone').val('');
      $('.patient-insurance-id').val('');
      $('.patient-plan').val('');
      $('.patient-insurance-id').val(null);
      $('.patient-affiliate-number').val('');
      $('.patient-professional').val('');
      $('.patient-email').val('');
    }
  };

  var setFieldsSearchPatient = function (data) {
    //console.log(data);
    $('.patient-surname').val(data.surname);
    $('.patient-name').val(data.name);
    $('.patient-address').val(data.address);
    $('.patient-primary-phone').val(data.primary_phone);
    $('.patient-secondary-phone').val(data.secondary_phone);
    $('.patient-insurance-id').val(data.insurance_id);
    $('.patient-insurance-id').trigger('change');
    $('.patient-plan').val(data.plan);
    $('.patient-affiliate-number').val(data.affiliate_number);
    $('.patient-professional').val(data.professional);
    $('.patient-email').val(data.email);
    $('.patient-dni').val(data.dni);
  };

  var resetSearchPatientPanel = function (data = null, hide = true, forceReset = false) {
    //Hide error messages and new patient panel
    //$('.searchpatient-panel').hide();
    $('.error-msg').hide();
    $('.success-msg').hide();
    $('.info-msg').show();

    $('.patient-dni').val('');
    resetFieldsSearchPatient(data, forceReset);

    if (hide) {
      $('.searchpatient-panel').hide();
    }
  };

  var updatePatientEditLink = function (show, id = null) {
    if (show == 'show') {
      $('a.patient-edit-link').prop('href', '/secretary/patients/' + id + '/edit');
      $('a.patient-edit-link').show();
    }
    if (show == 'hide') {
      $('a.patient-edit-link').hide();
    }
  };
  var getPatientInformationByDni = function (dni, panel) {
    $.ajax({
      url: '/api/patients/dni/' + dni,
      data: {
        api_token: localStorage.getItem('api_token'),
      },
      type: 'GET',
      success: function (data) {
        updatePatientEditLink('show', data.id);
        updateSearchPatientInformation(data, panel);
      },
      error: function (data) {
        if ((data.status = 'Not Found')) {
          updatePatientEditLink('hide');
          updatePatientNotFound(panel);
        }
      },
    });
  };

  var storePatientWithoutDni = function (form) {
    var name = form.find('#patient_name').val();
    var surname = form.find('#patient_surname').val();
    var address = form.find('#patient_address').val();
    var primary_phone = form.find('#patient_primary_phone').val();
    var secondary_phone = form.find('#patient_secondary_phone').val();
    var plan = form.find('#patient_plan').val();
    var affiliate_number = form.find('#patient_affiliate_number').val();
    var professional = form.find('#patient_professional').val();
    var email = form.find('#patient_email').val();

    setPatientWithoutDni(name, surname);

    //form.find("select[name='patient_id'] option:last").attr("selected", "selected");
    form.find("input[name='patient_id']").val('');
    form.find('input[name="patient_name"]').val(name);
    form.find('input[name="patient_surname"]').val(surname);
    form.find('input[name="patient_address"]').val(address);
    form.find('input[name="patient_primary_phone"]').val(primary_phone);
    form.find('input[name="patient_secondary_phone"]').val(secondary_phone);
    form.find('input[name="patient_plan"]').val(plan);
    form.find('input[name="patient_affiliate_number"]').val(affiliate_number);
    form.find('input[name="patient_professional"]').val(professional);
    form.find('input[name="patient_email"]').val(email);
  };

  var setPatientWithoutDni = function (name, surname) {
    $('#modalEditAppointment #patient_show_name').val(name + ' ' + surname);
    $('#uniqueAppointmentModal #patient_show_name').val(name + ' ' + surname);

    patient_id = null;

    var patient = {
      id: '',
      name: name,
      surname: surname,
    };
    addPatientToSelect(patient);
  };

  var storePatient = function (form) {
    var dni = form.find('input[name="patient_dni"]').val();
    if (dni == '') {
      storePatientWithoutDni(form);
    } else {
      var data = $('#newPatientForm').serialize();
      $.ajax({
        url: '/api/patients',
        data: data,
        type: 'POST',
        success: function (data, textStatus, xhr) {
          //console.log(xhr.status);
          patient_id = data.id;
          addPatientToSelect(data);
          patientFound = true;
          selectPatient(form);
          form.find('.patient-success-msg').show();
          form.find('.patient-error-msg').hide();
          // changeStatusIfNotSelected(form);
        },
        error: function (textStatus, xhr) {
          form.find('.patient-success-msg').hide();
          form.find('.patient-error-msg').show();
          //console.log(xhr.status);
        },
      });
    }
  };

  var addPatientToSelect = function (data) {
    $('select[name="patient_id"]').append(
      $('<option>', {
        value: data.id,
        text: data.name + ' ' + data.surname,
      })
    );
  };

  var updateSearchPatientInformation = function (data, panel) {
    //console.log(data);
    panel.find('.search-error-msg').hide();
    panel.find('.search-success-msg').show();
    panel.find('.search-info-msg').hide();

    setFieldsSearchPatient(data);
    patientFound = true;
    patient_id = data.id;
  };

  var updatePatientNotFound = function (panel) {
    panel.find('.search-success-msg').hide();
    panel.find('.search-error-msg').show();
    panel.find('.search-info-msg').hide();

    resetFieldsSearchPatient();

    patientFound = false;
  };

  $('.search-patient').on('click', function () {
    clearSearchPatientForm();
    $('.searchpatient-panel').show('slow');
    $('.advanced-search-panel').hide('slow');
  });

  $('.advanced-search').on('click', function () {
    clearAdvancedSearchForm();
    $('.advanced-search-panel').show('slow');
    $('.searchpatient-panel').hide('slow');
  });

  var clearAdvancedSearchForm = function (hide = false) {
    $('.advanced-dni').val('');
    $('.advanced-name').val('');
    $('.advanced-surname').val('');
    $('.advanced_confirm').prop('disabled', 'disabled');
    $('.advanced-result-table tbody').empty();
    if (hide) {
      $('.advanced-search-panel').hide();
    }
  };
  var clearSearchPatientForm = function () {
    patientFound = false;
    patientSearched = true;
    previousValueDni = null;
    $('.success-msg').hide();
    $('.error-msg').hide();
    $('.info-msg').show();

    $('#uniqueAppointmentModal .patient-dni').val('');
    resetFieldsSearchPatient();
  };

  $('.patient-dni').on('input', function (event) {
    var actualValueDni = $(this).val();
    if (previousValueDni == null || previousValueDni != actualValueDni) {
      patientSearched = false;
      //console.log('cambio');
    }
    if (actualValueDni == '') patientSearched = true;
    previousValueDni = actualValueDni;
  });

  $('.patient-dni').bind('cut copy paste', function (e) {
    e.preventDefault();
  });

  $('.search-dni').on('click', function () {
    var panel = $(this).closest('.panel');
    //console.log($(this).parent('.input-group').find('.patient-dni').val());
    patientSearched = true;
    getPatientInformationByDni($(this).closest('.form-group').find('.patient-dni').val(), panel);
  });

  $('.search-cancel').on('click', function () {
    $('.searchpatient-panel').hide('slow');
  });
  $('.advanced-cancel').on('click', function () {
    $('.advanced-search-panel').hide('slow');
  });

  var selectPatient = function (form) {
    //form.find('select[name="patient_id"]').val(patient_id);
    form.find('input[name="patient_id"]').val(patient_id);
    $('input[name="patient_show_name"]').val(patient_name + ' ' + patient_surname);
  };

  var changeStatusIfNotSelected = function (form) {
    var select = form.find('select[name="status"]');
    if (select.find('option:selected').val() == 0) {
      select.val(1);
    }
  };
  $('.search-confirm').on('click', function () {
    var form = $(this).closest('.form');
    if (patientSearched == false) {
      alert(
        'Debe presionar el botón Buscar antes de utilizar un número de DNI ' +
          'con un paciente. Si no quiere utilizar el campo DNI por favor asegúrese ' +
          'que se encuentra vacío'
      );
      return;
    }
    patient_name = form.find('.patient-name').val();
    patient_surname = form.find('.patient-surname').val();

    if (patient_name == '' || patient_surname == '') {
      alert('Debe completar Nombre y Apellido obligatoriamente');
      return;
    }

    var dni = form.find('.patient-dni').val();

    if (patientFound && dni != '') {
      selectPatient(form);
      $(this).parent('.form-group').find('.success-msg').show();
      $(this).parent('.form-group').find('.error-msg').hide();
      $(this).parent('.form-group').find('.info-msg').hide();
      changeStatusIfNotSelected(form);
      $('.searchpatient-panel').hide('slow');
    } else {
      if (dni == '') {
        storePatientWithoutDni(form);
      } else {
        $('#newPatientForm input[name="dni"]').val(form.find('.patient-dni').val());
        $('#newPatientForm input[name="name"]').val(form.find('.patient-name').val());
        $('#newPatientForm input[name="surname"]').val(form.find('.patient-surname').val());
        $('#newPatientForm input[name="address"]').val(form.find('.patient-address').val());
        $('#newPatientForm input[name="primary_phone"]').val(form.find('.patient-primary-phone').val());
        $('#newPatientForm input[name="secondary_phone"]').val(form.find('.patient-secondary-phone').val());
        $('#newPatientForm input[name="affiliate_number"]').val(form.find('.patient-affiliate-number').val());
        $('#newPatientForm input[name="insurance_id"]').val(form.find('.patient-insurance-id').val());
        $('#newPatientForm input[name="professional"]').val(form.find('.patient-professional').val());
        $('#newPatientForm input[name="email"]').val(form.find('.patient-email').val());
        $('#newPatientForm input[name="plan"]').val(form.find('.patient-plan').val());

        storePatient(form);
      }
      $('.searchpatient-panel').hide('slow');
    }
  });

  /**************************************************************************
   * New Unique Appointment Modal
   **************************************************************************/
  var initModalCalendar = function () {
    $('.calendar-form').find('.xdsoft_month').addClass('month_disabled');
    $('.calendar-form').find('.xdsoft_year').addClass('year_disabled');
    $('.datepicker').datetimepicker({
      inline: false,
      minDate: '2010/01/01',
      onSelectDate: null,
      highlightedDates: ["2010/01/01, '', "],
    });
  };

  var initCalendarCalendar = function () {
    $('.calendar-form').find('.xdsoft_month').removeClass('month_disabled');
    $('.calendar-form').find('.xdsoft_year').removeClass('year_disabled');
    initCalendar();
  };

  var createUniqueAppointment = function () {
    var professional = $('#professional option:selected').text();

    $('.new-appointment-error-msg').hide();

    $('#uniqueAppointmentModal #professionalName').text(professional);
    //reset fields
    $('#uniqueAppointmentModal #patient_id').val(null);
    $('#uniqueAppointmentModal #patient_show_name').val('');
    $('#uniqueAppointmentModal #status').val(1);
    $('#uniqueAppointmentModal #insurance_id option:contains("Seleccionar")').prop('selected', true);
    $('#uniqueAppointmentModal #medical_study_id option:contains("Seleccionar")').prop('selected', true);
    $('#uniqueAppointmentModal #money').val('');
    $('#uniqueAppointmentModal #coupons').val('');
    $('#uniqueAppointmentModal #timepicker').val('');
    $('#uniqueAppointmentModal #date').val('');
    //set professional_id
    $('#uniqueAppointmentModal input[name="professional_id"]').val(getProfessionalIdSelected());

    resetSearchPatientPanel(null, true, true);

    initModalCalendar();
    $('.datepicker').datetimepicker({ value: getDateSelected() });
    $('#uniqueAppointmentModal').modal('show');
  };

  $('#uniqueAppointmentModal').submit(function (event) {
    event.preventDefault();

    if (validateCreateUniqueAppointment()) {
      submitCreateUniqueAppointment();
    }
  });

  var validateCreateUniqueAppointment = function () {
    //console.log('validation');

    $('.new-appointment-error-msg').hide();

    var errors = false;
    //fecha seleccionada
    if ($('#uniqueAppointmentModal #date').val() == '') {
      errors = true;
      $('#new-appointment-date-error').show();
    }
    //hora seleccionada
    if ($('#uniqueAppointmentModal #timepicker').val() == '') {
      errors = true;
      $('#new-appointment-timepicker-error').show();
    }
    //paciente seleccionado
    /*
        if($( "#uniqueAppointmentModal #patient_id option:selected" ).text() == 'Seleccionar'){
            errors = true;
            $('#new-appointment-patient_id-error').show();
        }      
        */
    return !errors;
  };
  /**************************************************************************
   * Ajax Calls
   **************************************************************************/

  var submitCreateUniqueAppointment = function () {
    if ($('#uniqueAppointmentModal #insurance_id option:selected').text() == 'Seleccionar') {
      $('#uniqueAppointmentModal #insurance_id').val(null);
    }

    $('#timepicker').val($('#timepicker').val().split(' ').join(''));

    var data = $('#uniqueAppointmentModalForm').serialize();

    //console.log(data);

    //return;

    $.ajax({
      url: '/api/appointments',
      data: data,
      type: 'POST',
      success: function () {
        $('#calendar').fullCalendar('refetchEvents');
        //console.log('recargados');
        initCalendar();
        $('#uniqueAppointmentModal').modal('hide');
        updateFlashMessage('success', 'El turno se creó correctamente');
        removePatientsWithoutId();
      },
      error: function () {
        $('#uniqueAppointmentModal').modal('hide');
        updateFlashMessage('danger', 'El turno no se pudo crear. Por favor inténtelo más tarde.');
      },
    });
  };

  var getPatientInformation = function (patient_id) {
    $.ajax({
      url: '/api/patients/' + patient_id,
      data: {
        api_token: localStorage.getItem('api_token'),
      },
      type: 'GET',
      success: function (data) {
        //console.log('success');
        updatePatientInformation(data);
      },
    });
  };

  var deleteAppointment = function (calEvent, sendEmail = false) {
    $.ajax({
      url: '/api/appointments/' + calEvent.id,
      data: {
        api_token: localStorage.getItem('api_token'),
        send_email: sendEmail,
      },
      type: 'DELETE',
      success: function () {
        $('#calendar').fullCalendar('removeEvents', calEvent.id);
        updateFlashMessage('success', 'El turno se borró correctamente');
      },
      error: function () {
        updateFlashMessage('danger', 'El turno no se pudo borrar. Por favor intentélo más tarde.');
      },
    });
  };

  var submitEditModal = function () {
    var data = $('#editAppointmentModalForm').serialize();

    var appointment_id = $('#invisible_id').val();

    //console.log(data);

    $.ajax({
      url: '/api/appointments/' + appointment_id,
      data: data,
      type: 'PUT',
      success: function () {
        //console.log('success');
        $('#calendar').fullCalendar('refetchEvents');
        initCalendar();
        $('#modalEditAppointment').modal('hide');
        updateFlashMessage('success', 'El turno se actualizó correctamente');
      },
      error: function () {
        $('#modalEditAppointment').modal('hide');
        updateFlashMessage('danger', 'El turno no se pudo actualizar correctamente. Por favor inténtelo más tarde.');
      },
    });
  };

  /**************************************************************************
   * Flash messages
   **************************************************************************/

  var updateFlashMessage = function (type, msg, object = false) {
    var div = $('.flash-message').empty();
    if (object) {
      var alert = $('<div/>')
        .addClass('flash-message list-style-none alert alert-dismissible alert-' + type)
        .append(msg)
        .append(
          $('<button type="button" class="close dismiss-button" data-dismiss="alert" aria-hidden="true">×</button>)')
        );
    } else {
      var alert = $('<div/>')
        .addClass('flash-message alert alert-dismissible alert-' + type)
        .text(msg)
        .append(
          $('<button type="button" class="close dismiss-button" data-dismiss="alert" aria-hidden="true">×</button>)')
        );
    }
    div.append(alert).show();
  };

  /**************************************************************************
   * Date and Time pickers
   **************************************************************************/
  var options = {
    now: '11:00', //hh:mm 24 hour format only, defaults to current time
    twentyFour: true, //Display 24 hour format, defaults to false
    title: 'Seleccione un horario', //The Wickedpicker's title,
    minutesInterval: 5, //Change interval for minutes, defaults to 1
  };

  $('.timepicker').wickedpicker(options);

  $('.datepicker').datetimepicker({
    timepicker: false,
    format: 'Y-m-d',
    minDate: 0,
    lang: 'es',
  });

  /*************************************************************************
   * Autoreload of events in calendar
   *************************************************************************/
  setInterval(function () {
    $('#calendar').fullCalendar('refetchEvents');
    //initCalendar();
    //updateTotals();
  }, 5000);

  /**************************************************************************
   * Calculate totals (money and coupons)
   **************************************************************************/
  var updateTotals = function () {
    $('#total-coupons').html(total_coupons);
    $('#total-money').html('$' + total_money + '.00');
    total_money = 0;
    total_coupons = 0;
  };

  updateTotals();

  /**************************************************************************
   * Actualizar OS paciente
   **************************************************************************/
  $('#uniqueAppointmentModal .patient-insurance-id').on('change', function () {
    //console.log('cambio el select');
    id = $('#uniqueAppointmentModal .patient-insurance-id option:selected').val();
    $('#uniqueAppointmentModal select[name="insurance_id"]').val(id);
  });

  $('#modalEditAppointment .patient-insurance-id').on('change', function () {
    //console.log('cambio el select');
    id = $('#modalEditAppointment .patient-insurance-id option:selected').val();
    $('#modalEditAppointment select[name="insurance_id"]').val(id);
  });

  /**************************************************************************
   * Boton para nuevo paciente (borra la información de search-panel)
   **************************************************************************/
  $('.new-patient').on('click', function () {
    resetSearchPatientPanel(null, false, true);
    updatePatientEditLink('hide');
  });

  /**************************************************************************
   * Time picker del calendario
   **************************************************************************/
  var changeDate = function (selectedDate) {
    //console.log(selectedDate.getDate());
    nextDate = moment(selectedDate);
    $('.loader').fadeIn('slow');
    $('#calendar').fullCalendar('gotoDate', selectedDate);
    setTimeout(function () {
      $('.loader').fadeOut('slow');
    }, 1000);
  };

  // $('.calendar-date').datetimepicker({
  //     inline:true,
  //     minDate: '2010/01/01',
  //     onChangeDateTime: changeDate
  // });

  /**************************************************************************
   * Show calendar
   **************************************************************************/

  var dates = [];

  var initCalendar = function () {
    dates = [
      '2017/12/16, Disponibilidad media, media-disponibility',
      '2017/12/23, Disponibilidad baja, low-disponibility',
    ];

    initCalendarWithColor(dates);

    $.ajax({
      url: '/api/appointments/disponibilityExtended',
      data: {
        api_token: localStorage.getItem('api_token'),
        professional_id: getProfessionalIdSelected(),
        medical_study_id: getMedicalStudyIdSelected(),
      },
      type: 'GET',
      success: function (data) {
        //console.log('Cargando turnos');
        //console.log(data);
        initCalendarWithColor(data);
      },
      error: function (data) {
        //console.log('Actualmente el sistema no puede mostrar los turnos. Intente nuevamente más tarde');
        initCalendarWithColor(null);
      },
    });
  };

  var initCalendarWithColor = function (dates) {
    var today = new Date();

    //console.log(dates);

    $('.calendar-date').datetimepicker({
      highlightedDates: dates,
      inline: true,
      minDate: '2010/01/01',
      onSelectDate: changeDate,
    });

    setTimeout(function () {
      $('.loader').fadeOut('slow');
    }, 1000);

    $('.cargando-fechas').hide('slow');
    $('.calendar-form').show('slow');
  };

  initCalendar();

  /**************************************************************************
   * Advanced Result Table
   **************************************************************************/
  var advanced_patient_dni = null;

  $('.advanced-result-table').on('click', 'tbody tr', function (event) {
    $(this).addClass('active').siblings().removeClass('active');

    advanced_patient_dni = $(this).find('td:first-child').html();

    $('.advanced-confirm').prop('disabled', false);
  });

  $('.advanced-search-submit').on('click', function () {
    form = $(this).closest('form');
    getPatientsWithAdvancedSearch(form);
  });

  $('.advanced-confirm').on('click', function () {
    $('.advanced-search-panel').hide('slow');
    $('.patient-dni').val(advanced_patient_dni);
    $('.searchpatient-panel').show('slow');
    $('.search-dni').trigger('click');
  });

  $('.advanced-new').on('click', function () {
    $('.advanced-search-panel').hide('slow');
    resetSearchPatientPanel(null, false, true);
    $('.searchpatient-panel').show('slow');
  });

  $('#advancedResultTable').on('click', 'a', function (event) {
    event.preventDefault();
  });

  var getAdvancedSearchDni = function (form) {
    return form.find('.advanced-dni').val();
  };

  var getAdvancedSearchName = function (form) {
    return form.find('.advanced-name').val();
  };

  var getAdvancedSearchSurname = function (form) {
    return form.find('.advanced-surname').val();
  };

  var populateAdvancedSearchTable = function (patients) {
    $('.advanced-result-table tbody').empty();
    $.each(patients, function (i, item) {
      console.log(item.dni);
      var elem = '<tr><td>' + item.dni + '</td>';
      elem += '<td>' + item.surname + '</td>';
      elem += '<td>' + item.name + '</td>';
      elem += '<td> <a href="#" class="button select-table">Seleccionar</a></td></tr>';
      //console.log(elem);
      $('.advanced-result-table').append(elem);
    });
  };

  var getPatientsWithAdvancedSearch = function (form) {
    $.ajax({
      url: '/api/patients/advanced',
      data: {
        api_token: localStorage.getItem('api_token'),
        dni: getAdvancedSearchDni(form),
        surname: getAdvancedSearchSurname(form),
        name: getAdvancedSearchName(form),
      },
      type: 'GET',
      success: function (data) {
        //console.log('Cargando turnos');
        console.log(data);
        populateAdvancedSearchTable(data);
      },
      error: function (data) {
        console.log(data);
        //console.log('Actualmente el sistema no puede mostrar los turnos. Intente nuevamente más tarde');
        initCalendarWithColor(null);
      },
    });
  };

  /**************************************************************************
   * Week Appointments Bulk Store
   **************************************************************************/
  var resetNewWeekAppointmentModal = function () {
    $('.date_from').datetimepicker('destroy');
    $('.date_from').val('');
    $('.date_until').datetimepicker('destroy');
    $('.date_until').val('');
    $('input[name="send_email"').prop('checked', false);
    initDateTimeRangePicker();
    $('.appointments_per_turn').val('');
  };

  var initDateTimeRangePicker = function () {
    $('.date_from').datetimepicker({
      timepicker: false,
      format: 'Y-m-d',
      lang: 'es',
      minDate: '2010/01/01',
      inline: true,
      defaultSelect: false,
      onChangeDateTime: function (dateFromSelected) {
        //when we change Date in delivery picker, we set the collection picker to have this date as minimum
        $('.date_until').datetimepicker({
          minDate: dateFromSelected,
        });
      },
    }); //End of date from select

    $('.date_until').datetimepicker({
      timepicker: false,
      format: 'Y-m-d',
      minDate: '2010/01/01',
      lang: 'es',
      inline: true,
      defaultSelect: false,
      onChangeDateTime: function (dateUntilSelected) {
        //set the maxDate of delivery picker according to our collection picked day
        $('.date_from').datetimepicker({
          maxDate: dateUntilSelected,
        });
      },
    }); //End of collection datepicker
  };

  initDateTimeRangePicker();

  $('#rangePickerForm').submit(function (event) {
    event.preventDefault();

    $('input[name="professional_id"]').val(getProfessionalIdSelected());

    console.log($('#rangePickerForm').serialize());

    $('.loader').fadeIn('slow');

    $.ajax({
      url: '/api/calendar/bulkAction',
      data: $('#rangePickerForm').serialize(),
      type: 'POST',
      success: function () {
        console.log('success');
        $('#calendar').fullCalendar('refetchEvents');
        initCalendar();
        $('#rangePickerModal').modal('hide');
        $('.loader').fadeOut('slow');
        updateFlashMessage('success', 'Los turnos se modificaron correctamente');
      },
      error: function (data) {
        $('#rangePickerModal').modal('hide');
        $('.loader').fadeOut('slow');
        var obj = JSON.parse(data.responseText);
        var msg = '<ul>';
        msg += '<li>No se pudieron modificar los turnos debido a los errores:</li>';
        for (var key in obj) {
          msg += '<li>' + obj[key][0] + '</li>';
        }
        msg += '</ul>';
        updateFlashMessage('danger', $(msg), true);
      },
    });
  });
});
