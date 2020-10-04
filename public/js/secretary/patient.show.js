$(document).ready(function() {

	var getPatientId = function(){
    	return $('input[name="patient_id"]').val();
    };

    var table = $('#cards-table').DataTable({
        processing: true,
        serverSide: true,
        bFilter: false,
        scrollX: false,
        bLengthChange: false,
        responsive: true,
        pageLength: 50,
        ajax: {
        	url: url,
        	data: function ( d ) {
                d.patient_id = getPatientId();
            },
        },
        columnDefs: [ {
           	targets: 3,
           	data: null,
           	defaultContent: 
           	'<div class="btn-group">'+
           		'<a href="" class="btn btn-default btn-xs">'+
           			'<i class="glyphicon glyphicon-edit"></i>'+
           		'</a>'+
           		'<button type="submit" class="btn btn-danger btn-xs">'+
           			'<i class="glyphicon glyphicon-trash"></i>'+
           		'</button>'+
           	'</div>'
           	},
           	{
                targets: 0,
                visible: false,
                searchable: false
            }
        ],
        columns: [
        	{ data: 'id', name: 'id', orderable: 'false'},
            { data: 'professional_name', name: 'professional_name', orderable: 'false'},
            { data: 'number', name: 'number', orderable: 'false'}
        ]
    });

    $('#cards-table tbody').on( 'click', 'button', function () {
        var data = table.row( $(this).parents('tr') ).data();
        var r = confirm('¿Esta seguro que desea eliminar este registro?');
        var base_url = window.location.href;
		if (r == true) {
    		$('#deleteForm').attr('action', base_url+"/cards/"+data.id).submit();
		} else {
    		return;
		}
    } );

    $('#cards-table tbody').on( 'click', 'a', function (e) {
    	e.preventDefault();
        var data = table.row( $(this).parents('tr') ).data();
    	var base_url = window.location.href;
    	window.location.href = base_url+"/cards/"+data.id+"/edit";
    } );

});