$(document).ready(function() {

	$('.search-historia').on('click',function(e){
		
		e.preventDefault();

		var surname = $('#search-surname').html().trim();

		var url = $(this).parent('a').attr('href');

		window.open(url+'?search='+surname);

	});
});