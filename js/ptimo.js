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
	    
	    //Entrada - Salida - Mueve Inventario Propio
	    var cell3 = row.insertCell(2);
	    cell3.className = 'text-center';
	    a = '<input type="radio" name="tipoMov'+rowCount+'" value="E" onclick="swEditor(\'\',\'trSelect'+rowCount+'\')"> <small>Entrada</small> &nbsp;';
	    b = '<input type="radio" name="tipoMov'+rowCount+'" value="S" onclick="swEditor(\'\',\'trSelect'+rowCount+'\')"> <small>Salida</small> &nbsp;';
	    c = '<input type="checkbox" id="txtMInvPro'+rowCount+'" onclick="swEditor(\'\',\'trSelect'+rowCount+'\')"> <small>Mueve Inv. Propio</small>';
	    cell3.innerHTML = a+b+c;
	    
	    //Cod Tipo Movimiento Soporte
	    var cell4 = row.insertCell(3);
	    cell4.className = 'text-center';
	    cell4.innerHTML = '<input type="text" id="txtCodTipoSoporte'+rowCount+'" class="form-control input-sm text-center" onkeypress="solonumerosEnter('+rowCount+')" onclick="swEditor(\'txtCodTipoSoporte'+rowCount+'\',\'trSelect'+rowCount+'\')">';
	    
	    //Nom Tipo Movimiento Soporte
	    var cell5 = row.insertCell(4);
	    cell5.className = 'text-center';
	    cell5.innerHTML = '<input type="text" id="txtNomTipoSoporte'+rowCount+'" class="form-control input-sm" placeholder="Indefinido" onclick="swEditor(\'\',\'trSelect'+rowCount+'\')" readonly>';
	    
	    //Cod Clase Bodega Destino
	    var cell4 = row.insertCell(5);
	    cell4.className = 'text-center';
	    cell4.innerHTML = '<input type="text" id="txtCodClaseBodega'+rowCount+'" class="form-control input-sm text-center" onkeypress="solonumerosEnter('+rowCount+')" onclick="swEditorM(\'\',\'trSelect'+rowCount+'\',1,'+rowCount+')">';
	    
	    //Nom Clase Bodega Destino
	    var cell5 = row.insertCell(6);
	    cell5.className = 'text-center';
	    cell5.innerHTML = '<input type="text" id="txtNomClaseBodega'+rowCount+'" class="form-control input-sm" onclick="swEditor(\'\',\'trSelect'+rowCount+'\')" readonly>';
	    

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
			var e_s = $('input[name="tipoMov'+i+'"]:checked').val();
			
			if($("#txtMInvPro"+i).is(':checked')) { chek = 'S'; }
			else{ chek = 'N'; }

			var tMovSop = $.trim($('#txtCodTipoSoporte'+i).val());
			var clBodDes = $.trim($('#txtCodClaseBodega'+i).val());

			//
			if( $('#txtTipo'+i).val() == 1){ //Editar
				var codOrg = $.trim($('#txtCodOrg'+i).val());
				$.ajax({
			        type:'POST',
			        url:'proc/ptimo_proc.php?accion=editar_registros',
			        data:{ codOrg:codOrg, cod:cod, nom:nom, e_s:e_s, chek:chek, tMovSop:tMovSop, clBodDes:clBodDes },
			        success: function(data){
			            if(data==1){
		                    actualizar();
			            }else{ alert(data+' Editar!') }
			        }
			    });
			}else{ // Nuevo
				if( (cod!='') && (nom!='') && (clBodDes!='') ){
					$.ajax({
				        type:'POST',
				        url:'proc/ptimo_proc.php?accion=guardar_registros',
				        data:{cod:cod, nom:nom, e_s:e_s, chek:chek, tMovSop:tMovSop, clBodDes:clBodDes },
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

	//Btn Lista Valores
	$('#btnListaValores').click(function(){

		$('#modalClases').modal('show');
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
        url:'proc/ptimo_proc.php?accion=actualizar_registros',
        data:{cod:'1'},
        success: function(data){
            $('#table').html(data);
            $('#btnListaValores').addClass('disabled');
        }
    });
}

function solonumeros(){
    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
        event.returnValue = false;
}
function solonumerosEnter(id){
	if(event.which == 13){
		validarClase(id);
	}else{
	    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
	        event.returnValue = false;
	}
}
function validarClase(id){
	$('#txtNomClaseBodega'+id).val('');
	cod = $('#txtCodClaseBodega'+id).val();
	$.ajax({
        type:'POST',
        url:'proc/ptimo_proc.php?accion=validar_clase',
        data:{cod:cod},
        dataType: "json",
        success: function(data){
        	if(data[0]!=0){
        		$('#txtNomClaseBodega'+id).val(data[1]);
        	}else{
        		alert('Error! La Clase no es valida')
        		$('#txtNomClaseBodega'+id).val('');
        	}
        }
    });
}

var idGlb = 0;
function colocarClase(id,nom){
	$('#txtCodClaseBodega'+idGlb).val(id);
	$('#txtNomClaseBodega'+idGlb).val(nom);
	$('#modalClases').modal('hide');
}
//Ver origen del editor
var varEditor = '';
function swEditor(id,trId){

	varEditor = id;
	$('.trDefault').removeClass('trSelect');
	$('#'+trId).addClass('trSelect');
}
function swEditorM(id,trId,mdSec,i){

	varEditor = id;
	$('.trDefault').removeClass('trSelect');
	$('#'+trId).addClass('trSelect');

	if(mdSec==1){
		modal = 3;
	}
	idGlb = i;

	$('#btnListaValores').removeClass('disabled');
}
function descargarEditor(){
	var dat = $('#txtCampEditor').val();
	$('#'+varEditor).val(dat);
	$('#editModal').modal('hide');
}