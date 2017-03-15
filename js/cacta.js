$(document).ready(function(){
	$('#btnCancelar').removeClass('disabled');
	$('#btnCancelar').click(function(){
        
        limpiarDatos();
    });
	$('#btnConsulta').click(function(){
        act = $("#txtActCod").val();
        if(act!=''){
        	buscarActa(act);
        }else{
        	alert('Porfavor coloque un numero de acta valida')
        }
    });

    $("#txtActCod").keypress(function(event){
		if(event.which == 13){
			act = $("#txtActCod").val();
	        if(act!=''){
	        	buscarActa(act);
	        }else{
	        	alert('Porfavor coloque un numero de acta valida')
	        }
		}
	});
});

function buscarActa(act){
	$.ajax({
        type:'POST',
        url:'proc/cacta_proc.php?accion=buscar_acta',
        data:{ act:act },
        dataType: 'json',
        success: function(data){
            $('#txtTecCod').val(data[0]);
            $('#txtTecNomb').val(data[1]);
            $('#txtFecCod').val(data[2]);
            $('#txtEstCod').val(data[3]);
            $('#txtValBruto').val(data[4]);
            $('#txtValNeto').val(data[5]);
            $('#txtObservacion').val(data[6]);
            manoObtaActa(act);
            notasActa(act);
        }
    });
}
function manoObtaActa(act){
	$.ajax({
        type:'POST',
        url:'proc/cacta_proc.php?accion=buscar_mano_obra_acta',
        data:{ act:act },
        success: function(data){
            $('#divManoObraActa').html(data);
        }
    });
}
function notasActa(act){
	$.ajax({
        type:'POST',
        url:'proc/cacta_proc.php?accion=buscar_notas_acta',
        data:{ act:act },
        success: function(data){
            $('#divNotaActa').html(data);
        }
    });
}
function limpiarDatos(){
	$('#txtActCod').val('');
	$('#txtTecCod').val('');
    $('#txtTecNomb').val('');
    $('#txtFecCod').val('');
    $('#txtEstCod').val('');
    $('#txtValBruto').val('');
    $('#txtValNeto').val('');
    $('#txtObservacion').val('');

    $('#divManoObraActa').html('');
}
function solonumeros(){
    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
        event.returnValue = false;
}