$(document).ready(function() {

	//console.log(search);

	$('#dataTableBuilder_filter').find('input').val(search);

	var table = $('#dataTableBuilder').dataTable();
	
	//console.log(filteredData);
	
	filteredData = table.fnFilter(search);

});