function selectedNewRow(id){
	// $('table > tbody  > tr').each(function(tr) {
	//     if($('#trSelect'+tr).hasClass('trSelect')===true){
	//     	$('#trSelect'+tr).removeClass('trSelect');
	//     }

	// });
	$('.trDefault').removeClass('trSelect');
	$('#'+id).addClass('trSelect');
}