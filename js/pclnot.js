$(document).ready(function () {
	
    actualizar();
    $('#btnNuevo').removeClass('disabled');
	$('#btnGuardar').removeClass('disabled');
	$('#btnListaValores').addClass('disabled');
	$('#btnConsulta').addClass('disabled');

	//Agregar campos
	$('#btnNuevo').click(function(){

		//Agregar una nueva fila a la tabla
		var table = document.getElementById('table');
	    var rowCount = table.rows.length;
	    var row = table.insertRow(rowCount);
	    row.className = 'trDefault';
		row.id = 'trSelect'+rowCount;
	    
	    //Codigo
	    var cell1 = row.insertCell(0);
	    cell1.className = 'text-center';
	    cell1.innerHTML = '<input type="text" id="txtCod'+rowCount+'" class="form-control input-sm text-center" onkeypress="solonumeros()" onclick="swEditor(\'txtCod'+rowCount+'\',\'trSelect'+rowCount+'\')"><input type="hidden" id="txtTipo'+rowCount+'" value="0">';
	    
	    //Descripcion
	    var cell2 = row.insertCell(1);
	    cell2.className = '';
	    cell2.innerHTML = '<input type="text" id="txtNomb'+rowCount+'" class="form-control input-sm" onclick="swEditor(\'txtNomb'+rowCount+'\',\'trSelect'+rowCount+'\')">';
	    
	    //Debito - Credito
	    var cell3 = row.insertCell(2);
	    cell3.className = 'text-center';
	    a = '<input type="radio" checked="checked" name="tipoPago'+rowCount+'" value="D" onclick="swEditor(\'\',\'trSelect'+rowCount+'\')"> <small>DEBITO</small> &nbsp;';
	    b = '<input type="radio" name="tipoPago'+rowCount+'" value="C" onclick="swEditor(\'\',\'trSelect'+rowCount+'\')"> <small>CREDITO</small> &nbsp;';
	    c = '';
	    cell3.innerHTML = a+b;
	    
	    //Visible
	    var cell4 = row.insertCell(3);
	    cell4.className = 'text-center';
	    cell4.innerHTML = '<input checked="checked" type="checkbox" id="txtCkek'+rowCount+'" onclick="swEditor(\'\',\'trSelect'+rowCount+'\')">';
	   
	    $('#contRow').val(rowCount);
	    $('#txtCod'+rowCount).focus();
	    selectedNewRow(row.id);
	});
	
	//Btn Guardar
	$('#btnGuardar').click(function(){
		var cont = $('#contRow').val();

		for(var i=1;i<=cont;i++){
			var cod = $.trim($('#txtCod'+i).val());
			var nom = $.trim($('#txtNomb'+i).val());
			var d_c = $('input[name="tipoPago'+i+'"]:checked').val();
			if($("#txtCkek"+i).is(':checked')) { chek = 1; }
			else{ chek = 0; }
			//
			if( $('#txtTipo'+i).val() == 1){ //Editar
				var codOrg = $.trim($('#txtCodOrg'+i).val());
				if( (cod!='') && (nom!='') ){
					$.ajax({
				        type:'POST',
				        url:'proc/pclnot_proc.php?accion=editar_registros',
				        data:{ codOrg:codOrg, cod:cod, nom:nom, d_c:d_c, chek:chek },
				        success: function(data){
				            if(data==1){
			                    actualizar();
				            }else{ alert(data+' Editar!') }
				        }
				    });
				}
			}else{ // Nuevo
				if( (cod!='') && (nom!='') ){
					$.ajax({
				        type:'POST',
				        url:'proc/pclnot_proc.php?accion=guardar_registros',
				        data:{cod:cod, nom:nom, d_c:d_c },
				        success: function(data){
				            if(data==1){
			                    actualizar();
				            }else{ alert(data+' Agregar!') }
				        }
				    });
				}
			}
		}
	});

	//Btn Editor
	$('#btnEditor').click(function(){
		var dat = $('#'+varEditor).val();
		$('#txtCampEditor').val(dat);
		$('#editModal').modal('show');
	});

});

function actualizar(){
	$('#table').html('');
	$.ajax({
        type:'POST',
        url:'proc/pclnot_proc.php?accion=actualizar_registros',
        data:{cod:'1'},
        success: function(data){
            $('#table').html(data);
        }
    });
}

//Ver origen del editor
var varEditor = '';
function swEditor(id,trId){

	varEditor = id;
	$('.trDefault').removeClass('trSelect');
	$('#'+trId).addClass('trSelect');
}
function descargarEditor(){
	var dat = $('#txtCampEditor').val();
	$('#'+varEditor).val(dat);
	$('#editModal').modal('hide');
}
