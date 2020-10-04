$(document).ready(function() {

    //onsole.log(history_d);
    // Select 2 de usuarios del sitio
    $('.js-data-example-ajax.user-select2').select2({
        language: "es",
        placeholder: 'Buscar usuario',
        minimumInputLength: 3,
        ajax: {
            url: '/api/users/patients',
            dataType: 'json',
            data: function(params){
                var query = {
                    search: params.term,
                    api_token : localStorage.getItem('api_token')
                };

                return query;
            },
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            processResults: function (data) {
            return {
                results: $.map(data.users, function (item) {
                    return {
                        email: item.email,
                        name: item.name,
                        surname: item.surname,
                        id: item.id
                        }
                    })
                };
            }
        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });

    function formatRepo (repo) {
        //console.log(repo);
        if (repo.loading) {
            return repo.text;
        }

        var markup = "<div class='select2-result-repository clearfix'>" +
                     "<div class='select2-result-repository__title'>" + repo.name + " " + repo.surname +"</div>";

        markup += "<div class='select2-result-repository__description'>" + repo.email + "</div>";
        markup += "</div>";

        return markup;
    }

    function formatRepoSelection (repo) {
        if(repo.id == ""){
            return 'Buscar usuario';
        }

        if(repo.name != undefined){
            return repo.name + " " + repo.surname;
        } else {
            return repo.text;
        }

    }

    // Select 2 de OS del sitio
    $('.js-data-example-ajax.os-select2').select2({
        language: "es",
        placeholder: 'Buscar obra social',
        minimumInputLength: 1,
        ajax: {
            url: '/api/insurances/availables',
            dataType: 'json',
            data: function(params){
                var query = {
                    search: params.term,
                    api_token : localStorage.getItem('api_token')
                };

                return query;
            },
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            processResults: function (data) {
            return {
                results: $.map(data.insurances, function (item) {
                    return {
                        text: item.name,
                        id: item.id
                        }
                    })
                };
            }
        }
    });

    function init_select2(){
        console.log(history_d);
        if(history_d != null){
            if(history_d.patient_os != null){
                var $option = $('<option selected>'+history_d.insurance_name+'</option>').val(history_d.patient_os);
                $('.js-data-example-ajax.os-select2').append($option).trigger('change');
            };
            if(history_d.user_id != null){
                var $newOption = $('<option selected>'+history_d.user_completename+'</option>').val(history_d.user_id);
                $('.js-data-example-ajax.user-select2').append($newOption).trigger('change');
            };
        }
    }

    init_select2();
});