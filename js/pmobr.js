$(document).ready(function () {
	
    $('#btnNuevo').removeClass('disabled');
	$('#btnGuardar').removeClass('disabled');
	$('#btnListaValores').addClass('disabled');
	$('#btnConsulta').addClass('disabled');
	actualizar();

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
	    cell1.innerHTML = '<input type="text" id="txtCod'+rowCount+'" class="form-control input-sm" onkeypress="solonumeros()" onclick="swEditor(\'txtCod'+rowCount+'\',\'trSelect'+rowCount+'\')"><input type="hidden" id="txtTipo'+rowCount+'" value="0">';
	    //Valor Numerico
	    var cell2 = row.insertCell(1);
	    cell2.className = '';
	    cell2.innerHTML = '<input type="text" id="txtNomb'+rowCount+'" class="form-control input-sm" onclick="swEditor(\'txtNomb'+rowCount+'\',\'trSelect'+rowCount+'\')">';
	    //Und Medida
	    var cell3 = row.insertCell(2);
	    cell3.className = 'text-center';
	    cell3.innerHTML = '<input type="text" id="txtUndMed'+rowCount+'" class="form-control input-sm" onclick="swEditor(\'txtUndMed'+rowCount+'\',\'trSelect'+rowCount+'\')">';
	    
	    //Legalizacion Especial
	    //No Se Asocia Tecnico
	    var cell4 = row.insertCell(3);
	    cell4.className = 'text-center ';
	    cell4.innerHTML = '<input type="checkbox" id="ckLegEspec'+rowCount+'" onclick="swEditor(\'\',\'trSelect'+rowCount+'\')"> Legalizacion Especial';
	    //No Se Asocia Tecnico
	    var cell4 = row.insertCell(4);
	    cell4.className = 'text-center ';
	    cell4.innerHTML = '<input type="checkbox" id="ckAsocTec'+rowCount+'" onclick="swEditor(\'\',\'trSelect'+rowCount+'\')"> No se asocia al Tecnico';
	    //Visible
	    var cell6 = row.insertCell(5);
	    cell6.className = 'text-center ';
	    cell6.innerHTML = '<input type="checkbox" id="txtCkek'+rowCount+'" checked="checked" onclick="swEditor(\'\',\'trSelect'+rowCount+'\')"> ';
	    $('#contRow').val(rowCount);
	});
	//Guardar
	$('#btnGuardar').click(function(){
		var cont = $('#contRow').val();

		for(var i=1;i<=cont;i++){
			var cod = $.trim($('#txtCod'+i).val());
			var nom = $('#txtNomb'+i).val();
			var med = $('#txtUndMed'+i).val();
			
			if($("#ckLegEspec"+i).is(':checked')) { espe = 1; }
			else{ espe = 0; }

			if($("#ckAsocTec"+i).is(':checked')) { note = 1; }
			else{ note = 0; }

			if($("#txtCkek"+i).is(':checked')) { chek = 1; }
			else{ chek = 0; }

			if( $('#txtTipo'+i).val() == 1){ //Editar
				var codOrg = $.trim($('#txtCodOrg'+i).val());
				if( (cod!='') && (nom!='') ){
					$.ajax({
				        type:'POST',
				        url:'proc/pmobr_proc.php?accion=editar_registros',
				        data:{ codOrg:codOrg, cod:cod, nom:nom, med:med, espe:espe, note:note, chek:chek},
				        success: function(data){
				            console.log(data)
				            if(data==1){
			                    actualizar();
				            }else{ alert(data+' Editar!') }
				        }
				    });
				}
			}else{
				if( (cod!='') && (nom!='') ){
					$.ajax({
				        type:'POST',
				        url:'proc/pmobr_proc.php?accion=guardar_registros',
				        data:{cod:cod, nom:nom, med:med , espe:espe, note:note },
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
	//Editor
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
        url:'proc/pmobr_proc.php?accion=actualizar_registros',
        data:{codDep:'1'},
        success: function(data){
            $('#table').html(data);
        }
    });
}
function solonumeros(){
    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
        event.returnValue = false;
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