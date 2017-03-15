$(document).ready(function (){
	
	$('#btnEditor').addClass('disabled');

	$('#btnListaValores').click(function(){

		$('#modalBodega').modal('show');
	});

	$('#txtBodCod').click(function(){
		
		$('#txtBodNomb').val('');
	});

	$("#txtBodCod").keypress(function(event){
		if(event.which == 13){
			bod = $.trim($('#txtBodCod').val());
			if(bod!=''){
				buscarBodega(bod);
			}else{ alert('Porfavor coloque una bodega valida') }
		}
	});
});

function addBodega(cod,nom){
	$('#txtBodCod').val(cod);
	$('#txtBodNomb').val(nom);
	$('#modalBodega').modal('hide');
}

function buscarBodega(bod){
	$.ajax({
        type:'POST',
        url:'proc/pdesaot_proc.php?accion=buscar_departamento',
        data:{bod:bod},
        success: function(data){
        	$('#txtDepNomb').val(data);
        }
    });
}