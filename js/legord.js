$(document).ready(function(){
	//btnConsulta
	$('#btnConsulta').addClass('disabled');

	$('.tableJs').DataTable({
	    //ajax : 'assets/inc/clss/tbl/tabla-apuestas-adm-apuesta.php?camp=0',
	    "iDisplayLength": 10,
	    "lengthMenu": [
	        [10, 20, 30, -1],
	        [10, 20, 30, "Todos"] // change per page values here 
	    ],
	    initComplete: function(oSettings, json) {
	        //$('.tooltips').tooltip();
	    },
	    pageLength: 10,
	    "language": {
	        "sProcessing":     "Procesando...",
	        "sLengthMenu":     "Mostrar _MENU_ Registros",
	        "sZeroRecords":    "No se encontraron resultados",
	        "sEmptyTable":     "No hay Datos registradas en el sistema",
	        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
	        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
	        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
	        "sInfoPostFix":    "",
	        "sSearch":         "",
	        "sUrl":            "",
	        "sInfoThousands":  ",",
	        "sLoadingRecords": "Cargando Datos...",
	        "oPaginate": {
	            "sFirst":    "Primero",
	            "sLast":     "Último",
	            "sNext":     "Siguiente",
	            "sPrevious": "Anterior"
	        },
	        "oAria": {
	            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
	            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
	        }
	      },
	    "searching": true,
	    "ordering": false,
	    "info": false,
	    "autoWidth": false
	    /*"columns": [
	        { "class": "text-center cod","width":"15%"},
	        { "class": "text-left","width":"30px"}
	    ]*/
	});

	$('#btnEditor').click(function(){
		var text = $('#'+ediText).val();
		$('#txtCampEditor').val(text);
		$('#editModal').modal('show');
	});

	//validar departamento
	$("#txtDepOrd").keypress(function(event){
		if(event.which == 13){
			validar_cod_departamento($(this).val());
		}
	});
	//validar localidad
	$("#txtLocaOrd").keypress(function(event){
		if(event.which == 13){
			validar_cod_localidad($(this).val(), $("#txtDepOrd").val());
		}
	});
	//validar numero de localidad
	$("#txtNumbOrd").keypress(function(event){
		if(event.which == 13){
			dep = $.trim($('#txtDepOrd').val());
			loc = $.trim($('#txtLocaOrd').val());
			num = $.trim($('#txtNumbOrd').val());
			if( (dep!='') && (loc!='') && (num!='') ){
				buscarOrden(dep,loc,num);
			}else{ 
				demo.showNotification('bottom','left', 'Porfavor coloque un numero de orden valido', 4);
			}
		}
	});
	//fecha de cumplimiento
	$("#txtFechaCumpl").keypress(function(event){
		if(event.which == 13){
			fCump = $('#txtFechaCumpl').val();
			fAsig = $('#txtFechaAsig').val();
			fHoy  = $('#txtFechaLega').val();

			if(fCump!=''){
				//fecha de cumplimiento entre fecha de asignacion y la fecha de hoy
				if( (fCump >= fAsig) && (fCump <= fHoy) ){
					$('#txtPqrCodEnc').focus();
					modal = 2;
				}else{
					demo.showNotification('bottom','left','La fecha de cumplimiento debe ser mayor que la de asignacion y menor a la fecha de hoy',4)
				}
			}else{
				demo.showNotification('bottom','left', 'Porfavor coloque una fecha valida', 4);
			}
		}
	});
	//hora inicial
	$("#txtHoraInicial").keypress(function(event){
		if(event.which == 13){
			hIni = $('#txtHoraInicial').val();
			hFin = $('#txtHoraFinal').val();
			if(hIni!=''){
				if(hFin!=''){
					if(hIni < hFin){
						$('#txtHoraFinal').focus();
					}else{
						demo.showNotification('bottom','left', 'Porfavor coloque una hora inicial valida', 4);
					}
				}else{
					$('#txtHoraFinal').focus();
				}
			}else{
				demo.showNotification('bottom','left', 'Porfavor coloque una hora inicial valida', 4);
			}
		}
	});
	//hora final
	$("#txtHoraFinal").keypress(function(event){
		if(event.which == 13){
			hIni = $('#txtHoraInicial').val();
			hFin = $('#txtHoraFinal').val();
			if($(this).val()!=''){
				if(hIni < hFin){
					$('#txtObservacion').focus();
				}else{
					demo.showNotification('bottom','left', 'Porfavor coloque una hora final valida', 4);
				}
			}else{
				demo.showNotification('bottom','left', 'Porfavor coloque una hora final valida', 4);
			}
		}
	});

	$('#btnCancelar').click(function(){
		limpiar();
		$('#btnGuardar').addClass('disabled');
		$('#btnCancelar').addClass('disabled');
	});

	$('#btnListaValores').click(function(){
		if(modal==1){
			$('#modalOrdenes').modal('show');
		}else if(modal==2){ //Validar pqr x tecnico
			tec = $.trim($('#txtCodTecn').val());
			if(tec!=''){
				actualizarPqr(tec);
			}else{ alert('Porfavor coloque un tecnico valido') }
		}else if(modal==5){ //Validar mano de obra x tecnico y pqr
			pqr = $.trim($('#txtPqrCodEnc').val());
			if(pqr!=''){
				actualizarManoObra(pqr);
			}else{ alert('Porfavor coloque una pqr valido') }
		}else if(modal==6){
			pqr = $.trim($('#txtPqrCodEnc').val());
			if(pqr!=''){
				actualizarMateriales(pqr);
			}else{ alert('Porfavor coloque una pqr valido') }
			$('#modalMaterial').modal('show');
		}
	});

	$('#btnGuardar').click(function(){
		dep = $('#txtDepOrd').val();
		loc = $('#txtLocaOrd').val();
		num = $('#txtNumbOrd').val();

		fCumpl 	  = $('#txtFechaCumpl').val();
		pqrEnc    = $('#txtPqrCodEnc').val();
		pqrEncNom = $('#txtPqrNombEnc').val();

		horIni = $('#txtHoraInicial').val();
		horFin = $('#txtHoraFinal').val();

		legali = $('#txtLegalizador').val();

		if( (dep!='') && (loc!='') && (num!='') && (fCumpl!='') && (pqrEnc!='') && (pqrEncNom!='') && (horIni!='') 
			&& (horFin!='') && (legali!='') ){
				swFecha = false;
				swHoraIn = false;
				swHoraFi = false;
				//validar fecha cumplimiento
					fCumpl = $('#txtFechaCumpl').val();
					fAsig = $('#txtFechaAsig').val();
					fHoy  = $('#txtFechaLega').val();

					if(fCumpl!=''){
						//fecha de cumplimiento entre fecha de asignacion y la fecha de hoy
						if( (fCumpl >= fAsig) && (fCumpl <= fHoy) ){
							swFecha = true;
						}
					}
				//
				//validar hora inicial
					if(horIni!=''){
						if(horFin!=''){
							if(horIni < horFin){
								swHoraIn = true;
							}
						}
					}
				//
				//validar hora final
					horIni = $('#txtHoraInicial').val();
					horFin = $('#txtHoraFinal').val();
					if(horFin!=''){
						if(horIni < horFin){
							swHoraFi = true;
						}
					}
				//
				if((swFecha) && (swHoraIn) && (swHoraFi)){
					guardarOrdenIndiv(dep,loc,num,fCumpl,pqrEnc,horIni,horFin,legali);
				}else{
					demo.showNotification('bottom','left', 'Porfavor verifique los datos, para poder legalizar la orden', 4);
				}
		}else{
			demo.showNotification('bottom','left', 'Porfavor complete los datos, para poder legalizar la orden', 4);
		}
	});

	$("#txtPqrCodEnc").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtPqrCodEnc').val());
			tec = $.trim($('#txtCodTecn').val());
			if(tec!=''){
				buscarTrabajo(cod,tec);
			}else{
				demo.showNotification('bottom','left', 'Porfavor coloque un tecnico valido', 4);
			}
		}
	});

	$('#txtPqrCodEnc').click(function(){ modal = 2; });

	$('#txtDepOrd').click(function(){ modal = 1; });
	$('#txtLocaOrd').click(function(){ modal = 1; });
	$('#txtNumbOrd').click(function(){ modal = 1; });

	$('#txtHoraInicial').focusout(function(){
		hIni = $('#txtHoraInicial').val();
		hFin = $('#txtHoraFinal').val();

		if( (hIni!='') && (hFin!='') ){
			if(hIni>=hFin){
				demo.showNotification('bottom','left', 'La hora de inicio no es valida', 4);
				$('#txtHoraInicial').val('');
			}
		}
	});

	$('#txtHoraFinal').focusout(function(){
		hIni = $('#txtHoraInicial').val();
		hFin = $('#txtHoraFinal').val();
		
		if( (hIni!='') && (hFin!='') ){
			if(hIni>=hFin){
				demo.showNotification('bottom','left', 'La hora de inicio no es valida', 4);
				$('#txtHoraInicial').val('');
			}
		}
	});

	//Btn Agregar
	$('#addManoObra').click(function(){

		//Agregar una nueva fila a la tabla
		var table = document.getElementById('tableManoObra');
	    var rowCount = table.rows.length;
	    var row = table.insertRow(rowCount);
	    row.className = 'trDefault';
	    row.id = 'trSelect'+rowCount;

	    var cell1 = row.insertCell(0);
	    cell1.className = 'text-center';
	    cod = '<input type="text" id="txtCodMan'+rowCount+'" class="form-control input-sm text-center" onkeypress="solonumerosEnterMano('+rowCount+')" onclick="swEditor(\'txtCodMan'+rowCount+'\',\'trSelect'+rowCount+'\',5,'+rowCount+')">';
	    codH = '<input type="hidden" id="txtTipoMan'+rowCount+'" value="0">';
	    cell1.innerHTML = cod+codH;

	    var cell1 = row.insertCell(1);
	    cell1.className = 'text-center';
	    nom = '<input readonly type="text" id="txtNombMan'+rowCount+'" class="form-control input-sm" onclick="swEditor(\'txtNombMan'+rowCount+'\',\'trSelect'+rowCount+'\',5,'+rowCount+')">';
	    cell1.innerHTML = nom;
	    
	    var cell2 = row.insertCell(2);
	    cell2.className = '';
	    a = '<input id="txtCantMan'+rowCount+'" type="text" class="form-control input-sm text-right" onkeypress="solonumerosEnterCalMano('+rowCount+')" onclick="swEditor(\'txtCantMan'+rowCount+'\',\'trSelect'+rowCount+'\',5,'+rowCount+')">';
	    b = '<input id="txtCantManMAx'+rowCount+'" type="hidden" class="form-control input-sm" readonly>';
	    cell2.innerHTML = a+b;
	    
	    var cell3 = row.insertCell(3);
	    cell3.className = 'text-center ';
	    a = '<input id="txtValMan'+rowCount+'" type="hidden" readonly>';
	    b = '<input id="txtValManTotal'+rowCount+'" type="text" class="form-control input-sm text-right" onkeypress="solonumeros()" onclick="swEditor(\'txtValMan'+rowCount+'\',\'trSelect'+rowCount+'\',5,'+rowCount+')" readonly>';
	    cell3.innerHTML = a+b;

		idManGl = rowCount;
		selectedNewRow(row.id);
		$('#txtCodMan'+rowCount).focus();
		$('#selectRow').val(rowCount);
		
	    $('#contRowMano').val(rowCount);
	});
	//Btn Quitar
	$('#removeManoObra').click(function(){
		id = $('#contRowMano').val();
		$('#trSelect'+id).remove();
		$('#contRowMano').val(parseInt(id)-1);
	});

	$('#addMateriales').click(function(){

		//Agregar una nueva fila a la tabla
		var table = document.getElementById('tableMateriales');
	    var rowCount = table.rows.length;
	    var row = table.insertRow(rowCount);
	    row.className = 'trDefaultMat';
	    row.id = 'trSelectMat'+rowCount;

	    var cell1 = row.insertCell(0);
	    cell1.className = 'text-center';
	    cod = '<input type="text" id="txtCodMat'+rowCount+'" class="form-control input-sm text-center" onkeypress="solonumerosEnterMat('+rowCount+')" onclick="swEditorMat(\'txtCodMat'+rowCount+'\',\'trSelectMat'+rowCount+'\',6,'+rowCount+')">';
	    codH = '<input type="hidden" id="txtTipoMat'+rowCount+'" value="0">';
	    cell1.innerHTML = cod+codH;

	    var cell1 = row.insertCell(1);
	    cell1.className = 'text-center';
	    nom = '<input readonly type="text" id="txtNombMat'+rowCount+'" class="form-control input-sm" onclick="swEditorMat(\'txtNombMat'+rowCount+'\',\'trSelectMat'+rowCount+'\',6,'+rowCount+')">';
	    cell1.innerHTML = nom;
	    
	    var cell2 = row.insertCell(2);
	    cell2.className = '';
	    a = '<input id="txtCantMat'+rowCount+'" type="text" class="form-control input-sm text-right" onkeypress="colocarMateCant('+rowCount+')" onclick="swEditorMat(\'txtCantMat'+rowCount+'\',\'trSelectMat'+rowCount+'\',6,'+rowCount+')">';
	    b = '<input id="txtCantMatMax'+rowCount+'" type="hidden" >';
	    c = '<input id="txtCantMatFija'+rowCount+'" type="hidden" >';
	    cell2.innerHTML = a+b+c;

	    var cell3 = row.insertCell(3);
	    cell3.className = 'text-center ';
	    a = '<input readonly id="txtValMat'+rowCount+'" type="text" class="form-control input-sm text-right" onkeypress="solonumeros()" onclick="swEditorMat(\'txtValMat'+rowCount+'\',\'trSelectMat'+rowCount+'\',6,'+rowCount+')">';
	    b = '<input id="txtValMatMax'+rowCount+'" type="hidden" >';
	    c = '<input id="txtCantMatInv'+rowCount+'" type="hidden" >';
	    cell3.innerHTML = a+b+c; 

		selectedNewRowMat(row.id);
		$('#txtCodMat'+rowCount).focus();
		$('#selectRow').val(rowCount);
	    $('#contRowMate').val(rowCount);
		idMatGl = rowCount;
	});

	//Btn Quitar
	$('#removedMateriales').click(function(){
		id = $('#contRowMate').val();
		$('#trSelectMat'+id).remove();
		$('#contRowMate').val(parseInt(id)-1);
		
	});

});
var modal = 1;
var idManGl = 0;
var idMatGl = 0;
var ediText = '';

//validar departamento y localidad
function validar_cod_departamento(cod){
	$.ajax({
        type:'POST',
        url:'proc/legord_proc.php?accion=validar_cod_departamento',
        data:{ cod:cod },
        success: function(data){
			if(data==1){
				$('#txtLocaOrd').focus();
			}else{
				$('#txtDepOrd').focus();
				demo.showNotification('bottom','left', 'Porfavor coloque un departamento valido', 4);
			}
        }
    });
}
function validar_cod_localidad(cod,dep){
	$.ajax({
        type:'POST',
        url:'proc/legord_proc.php?accion=validar_cod_localidad',
        data:{ cod:cod, dep:dep },
        success: function(data){
			if(data==1){
				$('#txtNumbOrd').focus();
			}else{
				$('#txtLocaOrd').focus();
				demo.showNotification('bottom','left', 'Porfavor coloque una localidad valida', 4);
			}
        }
    });
}

//buscar datos de ordenes
function buscarOrden(dep,loc,num){
	$.ajax({
        type:'POST',
        url:'proc/legord_proc.php?accion=obtener_orden',
        data:{dep:dep, loc:loc, num:num},
        dataType: "json",
        success: function(data){
			if(data[22]==1){
				$('#modalOrdenes').modal('hide');
				$('#txtDepOrd').val(dep);
				$('#txtLocaOrd').val(loc);
				$('#txtNumbOrd').val(num);
				//Tecnico
				$('#txtCodTecn').val(data[0]);
				$('#txtNomTecn').val(data[1]);
				//Fechas
				$('#txtFechaRecib').val(data[3]);
				$('#txtFechaOrd').val(data[4]);
				$('#txtFechaCumpl').val(data[5]);
				$('#txtFechaAsig').val(data[6]);
				$('#txtFechaLega').val(data[7]);
				//Pqr
				$('#txtPqrCodRep').val(data[8]);
				$('#txtPqrNombRep').val(data[9]);
				$('#txtPqrCodEnc').val(data[10]);
				$('#txtPqrNombEnc').val(data[11]);
				//Usuario
				$('#txtCodUser').val(data[12]);
				$('#txtNomUser').val(data[13]);
				//Estado
				$('#txtCodEst').val(data[14]);
				$('#txtNomEst').val(data[15]);
				//Hora
				$('#txtHoraInicial').val(data[16]);
				$('#txtHoraFinal').val(data[17]);
				//
				$('#txtObservacion').val(data[18]);
				
				$('#txtAsignador').val(data[19]);
				$('#txtRecibidor').val(data[20]);

				obtener_fijo_pqr();
				//$('#txtLegalizador').val(data[21]);

				//obtenerManoObraOrden(dep,loc,num);
				//obtenerMaterialesOrden(dep,loc,num);

				//Desbloquear 
				$('#btnGuardar').removeClass('disabled');
				$('#btnCancelar').removeClass('disabled');

				$('#txtFechaCumpl').focus();
			}else{
				demo.showNotification('bottom','left', 'Porfavor coloque una orden valida', 4);
			}
        }
    });
}
function editor(idText){

	ediText = idText;
}
function swEditor(id,trId,mod,id){

	$('.trDefault').removeClass('trSelect');
	$('#'+trId).addClass('trSelect');
	modal = mod;
	idManGl = id;
}
function swEditorMat(id,trId,mod,id){

	$('.trDefaultMat').removeClass('trSelect');
	$('#'+trId).addClass('trSelect');
	modal = mod;
	idMatGl = id;
}
function descargarEditor(){
	var text = 	$('#txtCampEditor').val();
	$('#'+ediText).val(text);
	$('#editModal').modal('hide');
}
function guardarOrdenIndiv(dep,loc,num,fCumpl,pqrEnc,horIni,horFin,leg){
	
	contMan = $('#contRowMano').val();
	contMat = $('#contRowMate').val();

	//verificar mano de obra 
		swMO = false;
		for(var i=1;i<=contMan;i++){
			cod = $('#txtCodMan'+i).val(); //codigo mano de obra
			nom = $('#txtNombMan'+i).val(); //nombre mano de obra
			can = $('#txtCantMan'+i).val(); //cantidad mano de obra
			cMax = $('#txtCantManMAx'+i).val(); //cantidad maxima mano de obra
			val = $('#txtValManTotal'+i).val(); //valor mano de obra
			if( (cod!='') && (nom!='') && (can!=0) && (val!=0) ){
				if(can > cMax){ swMO = true; }
				if(can == 0){ swMO = true; }
			}
		}
		if(swMO){ demo.showNotification('bottom','left', 'Porfavor verifique los datos en las manos de obra', 4); }
	//
	//verificar materiales
		pqrqObl = $('#txtPqrMatFijoCont').val();
		contObl = 0;

		swMA = false;
		swMA_cant = false;
		swMA_cant0 = false;
		swMA_obli = false;
		for(var i=1;i<=contMat;i++){
			cod = $('#txtCodMat'+i).val(); //codigo del material
			nom = $('#txtNombMat'+i).val(); //nombre del material
			can = $('#txtCantMat'+i).val(); //cantidad del material
			cMax = $('#txtCantMatMax'+i).val(); //cantidad maxima a legalizar del material
			cFij = $('#txtCantMatFija'+i).val(); //cantidad fija del material
			cInv = $('#txtCantMatInv'+i).val(); //cantidad inventario del material
			val = $('#txtValMat'+i).val(); //valor del material 
			
			if( (cod!='') && (nom!='') && (can!='')  && (val!=0)){
				if(can > cMax){ swMA_cant = true; $swMA = true; }
				if(can == 0){ swMA_cant0 = true; $swMA = true; }
				if(cFij == 'S'){ contObl++; }
			}
	
		}
		if($('#txtPqrMatFijo').val()=='S'){
			if(contObl!=pqrqObl){
				swMA_obli = true;
				$swMA = true;
			}
		}
		if(swMA_cant){ demo.showNotification('bottom','left', 'La cantidada legalizar es mayor a la permitida', 4); }
		if(swMA_cant0){ demo.showNotification('bottom','left', 'Coloque una cantidad mayor a 0', 4); }
		if(swMA_obli){ demo.showNotification('bottom','left', 'Porfavor coloque el o los materiales obligatorios para legalizar esta orden', 4); }

	//
	
	//verificamos elementos en las tablas
	if( (contMan!='') || (contMat!='') ){

	}else{
		console.log(data)
		demo.showNotification('bottom','left', 'Porfavor complete los datos en las tablas para poder legalizar la orden', 4);
	}

	if( (!swMA) && (!swMO) ){
		obs = $('#txtObservacion').val();
		codTec = $('#txtCodTecn').val();
		
		$.ajax({
			type:'POST',
			url:'proc/legord_proc.php?accion=guardar_orden',
			data:{dep:dep, loc:loc, num:num, obs:obs, leg:leg, fCumpl:fCumpl, pqrEnc:pqrEnc, horIni:horIni, horFin:horFin },
			success: function(data){
				if(data==1){
					
					//Guardar Mano de Obra
						var contMan = $('#contRowMano').val();
						for(var i=1;i<=contMan;i++){
							cod = $('#txtCodMan'+i).val();
							can = $('#txtCantMan'+i).val();
							val = $('#txtValManTotal'+i).val();
							if( (cod!='') && (can!=0) && (val!=0) ){
								$.ajax({
									type:'POST',
									url:'proc/legord_proc.php?accion=guardar_mo_ot',
									data:{ cod:cod, dep:dep, loc:loc, num:num, can:can, val:val, codTec:codTec},
									success: function(data){
										console.log(data+' MO')
									}
								});
							}
						}
					//
					//Guardar Materiales
						var contMat = $('#contRowMate').val();
						for(var i=1;i<=contMat;i++){
							cod = $('#txtCodMat'+i).val();
							can = $('#txtCantMat'+i).val();
							val = $('#txtValMat'+i).val();
							cantInv = $('#txtCantMatInv'+i).val();
							if(cod!=''){
								$.ajax({
									type:'POST',
									url:'proc/legord_proc.php?accion=guardar_ma_ot',
									data:{ cod:cod, dep:dep, loc:loc, num:num, can:can, val:val, codTec:codTec, cantInv:cantInv, pqrEnc:pqrEnc},
									success: function(data){
										console.log(data+' MA')
									}
								});
							}
						}
					//
					//Actualizar Ordenes
						$.ajax({
							type:'POST',
							url:'proc/legord_proc.php?accion=actualizar_orden',
							data:{cod:'1'},
							success: function(data){
								$('#divTableOrdenes').html(data);
							}
						});

						demo.showNotification('bottom','left', 'La orden se guardo con Exito', 2);
						limpiar();
					//
				}else{ alert(data) }
			}
		});
	}
}
function obtenerManoObraOrden(dep,loc,num){
	$.ajax({
        type:'POST',
        url:'proc/legord_proc.php?accion=obtener_mano_obra',
        data:{dep:dep, loc:loc, num:num},
        success: function(data){
        	$('#tableManoObra').html(data);
        }
    });
}
function obtenerMaterialesOrden(dep,loc,num){
	$.ajax({
        type:'POST',
        url:'proc/legord_proc.php?accion=obtener_materiales',
        data:{dep:dep, loc:loc, num:num},
        success: function(data){
        	$('#tableMateriales').html(data);
        }
    });
}
function limpiar(){
	$('#txtDepOrd').val('');
	$('#txtLocaOrd').val('');
	$('#txtNumbOrd').val('');
	//Tecnico
	$('#txtCodTecn').val('');
	$('#txtNomTecn').val('');
	//Cumplida
	//$('#divEstOrd').html('<input type="checkbox" style="margin-left: 20px; margin-top:10px;"><label style="margin-left: 10px; color:red;">Cumplida</label>');
	//Fechas
	$('#txtFechaRecib').val('');
	$('#txtFechaOrd').val('');
	$('#txtFechaCumpl').val('');
	$('#txtFechaAsig').val('');
	$('#txtFechaLega').val('');
	//Pqr
	$('#txtPqrCodRep').val('');
	$('#txtPqrNombRep').val('');
	$('#txtPqrCodEnc').val('');
	$('#txtPqrNombEnc').val('');
	//Usuario
	$('#txtCodUser').val('');
	$('#txtNomUser').val('');
	//Estado
	$('#txtCodEst').val('');
	$('#txtNomEst').val('');
	//Hora
	$('#txtHoraInicial').val('');
	$('#txtHoraFinal').val('');
	$('#txtObservacion').val('');
	$('#txtAsignador').val('');
	$('#txtRecibidor').val('');
	//$('#txtLegalizador').val('');

	a = '<tr style="background-color: #3c8dbc; color:white;"><td class="text-right" width="80"></td>';
	b = '<td >Mano de Obra</td><td class="text-right" width="70">Cantidad</td>';
	c = '<td class="text-right" width="100">Valor</td></tr>';
	$('#tableManoObra').html(a+b+c);
	
	a = '<tr style="background-color: #3c8dbc; color:white;"><td class="text-right" width="80"></td>';
	b = '<td >Material</td><td class="text-right" width="70">Cantidad</td>';
	c = '<td class="text-right" width="100">Valor</td></tr>';
	$('#tableMateriales').html(a+b+c);
}
//PQR X TECNICO
function actualizarPqr(cod){
	$.ajax({
        type:'POST',
        url:'proc/legord_proc.php?accion=buscar_pqrxtecnico',
        data:{cod:cod},
        success: function(data){
        	$('#tablaDivPqr').html(data);
			$('#modalPqr').modal('show');
        }
    });
}
function buscarTrabajo(cod,tec){
	$.ajax({
        type:'POST',
        url:'proc/legord_proc.php?accion=buscar_trabajo',
        data:{cod:cod,tec:tec},
        success: function(data){
        	if(data!=''){
	            $('#txtPqrCodEnc').val(cod);
	            $('#txtPqrNombEnc').val(data);
				$('#txtHoraInicial').focus();
				obtener_fijo_pqr();
        	}else{
        		$('#txtPqrNombEnc').val('');
				demo.showNotification('bottom','left', 'Porfavor coloque un pqr valido', 4);
        	}
        	$('#modalPqr').modal('hide');
        }
    });
}
//verificar si la pqr tiene materiales fijo
function obtener_fijo_pqr(){
	pqr = $('#txtPqrCodEnc').val();
	$.ajax({
        type:'POST',
        url:'proc/legord_proc.php?accion=verificar_pqr_material_obligatorio',
        data:{ pqr:pqr },
        success: function(data){
	        $('#txtPqrMatFijo').val(data);
			if(data=='S'){
				$.ajax({
					type:'POST',
					url:'proc/legord_proc.php?accion=cont_pqr_material_obligatorio',
					data:{ pqr:pqr },
					success: function(data){
						$('#txtPqrMatFijoCont').val(data);
					}
				});
			}else{
				$('#txtPqrMatFijoCont').val(0);
			}
        }
    });
}
//MANO DE OBRA X PQR
function solonumerosEnterMano(id){
	if(event.which == 13){
		colocarManoObra(id);
	}else{
	    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
	        event.returnValue = false;
	}
}
function actualizarManoObra(cod){
	$.ajax({
        type:'POST',
        url:'proc/legord_proc.php?accion=actualiza_manoObraxpqr',
        data:{cod:cod},
        success: function(data){
        	$('#tablaDivManoObra').html(data);
			$('#modalManoObra').modal('show');
        }
    });
}
function buscarManoObra(cod,cant,val){
	$('#txtCodMan'+idManGl).val('');
	//Validar que no se repita
	sw = false;
	var cont = $('#contRowMano').val();
	for(var i=1;i<=cont;i++){
		var codOrg = $.trim($('#txtCodMan'+i).val());
		if(codOrg==cod){
			sw = true;
		}
	}
	if(!sw){
	    $('#modalManoObra').modal('hide');
		$.ajax({
	        type:'POST',
	        url:'proc/legord_proc.php?accion=buscar_manoObra',
	        data:{cod:cod},
	        //dataType: 'json',
	        success: function(data){
	        	//alert(data)
	        	if(data!=''){
	        		//
		            $('#txtCodMan'+idManGl).val(cod);
		            $('#txtNombMan'+idManGl).val(data);
		            if(cant!=0){
		            	$('#txtCantMan'+idManGl).val(1);
		            }else{
		            	$('#txtCantMan'+idManGl).val(0);
		            }
		            $('#txtCantManMAx'+idManGl).val(cant);
		            $('#txtValMan'+idManGl).val(val);
		            $('#txtValManTotal'+idManGl).val(val);
	        	}else{
	        		alert('Porfavor coloque una mano de obra valida')
	        	}
	        }
	    });
	}else{
		alert('Error! La mano de obra ya existe')
	}
}
function solonumerosEnterCalMano(id){
	if(event.which == 13){
		colocarManoObraCal(id);
	}else{
	    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
	        event.returnValue = false;
	}
}
function colocarManoObra(id){
	cod = $('#txtCodMan'+id).val();
	if(cod!=''){
		buscarManoObraCant(cod);
	}else{
		$('#txtCodMan'+id).val('');
		$('#txtTipoMan'+id).val('');
		$('#txtNombMan'+id).val('');
		$('#txtCantMan'+id).val('');
		$('#txtCantManMAx'+id).val('');
		$('#txtValMan'+id).val('');
		$('#txtValManTotal'+id).val('');
	}
}
function buscarManoObraCant(cod){
	$('#txtCodMan'+idManGl).val('');
	//Validar que no se repita
	sw = false;
	var cont = $('#contRowMano').val();
	for(var i=1;i<=cont;i++){
		var codOrg = $.trim($('#txtCodMan'+i).val());
		if(codOrg==cod){
			sw = true;
		}
	}
	if(!sw){
		pqr = $('#txtPqrCodEnc').val();
	    $('#modalManoObra').modal('hide');
		$.ajax({
	        type:'POST',
	        url:'proc/legord_proc.php?accion=buscar_manoObraxCant',
	        data:{pqr:pqr,cod:cod},
	        dataType: "json",
	        success: function(data){
	        	if(data[0]!=''){
	        		//
		            $('#txtCodMan'+idManGl).val(cod);
		            $('#txtNombMan'+idManGl).val(data);
		            if(data[1]!=0){
		            	$('#txtCantMan'+idManGl).val(1);
		            }else{
		            	$('#txtCantMan'+idManGl).val(0);
		            }
		            $('#txtCantManMAx'+idManGl).val(data[1]);
		            $('#txtValMan'+idManGl).val(data[2]);
		            $('#txtValManTotal'+idManGl).val(data[2]);
					$('#txtCantMan'+idManGl).focus();
	        	}else{
					demo.showNotification('bottom','left', 'Porfavor coloque una mano de obra valida', 4);
					$('#txtCodMan'+idManGl).val('');
		            $('#txtNombMan'+idManGl).val('');
					$('#txtCantMan'+idManGl).val('');
					$('#txtCantManMAx'+idManGl).val('');
		            $('#txtValMan'+idManGl).val('');
		            $('#txtValManTotal'+idManGl).val('');
	        	}
	        }
	    });
	}else{
		demo.showNotification('bottom','left', 'Error! La mano de obra ya existe', 4);
	}
}
function colocarManoObraCal(id){
	cant = parseInt($('#txtCantMan'+id).val());
	cantMax = parseInt($('#txtCantManMAx'+id).val());
	val = parseInt($('#txtValMan'+id).val());

	if(cant<=cantMax){
		$('#txtValManTotal'+id).val(cant*val);
	}else{
		demo.showNotification('bottom','left', 'La Cantidad no es valida', 4);
		$('#txtCantMan'+id).val(1);
		$('#txtValManTotal'+id).val(val);
	}
}
function selectedNewRow(id){
	// $('table > tbody  > tr').each(function(tr) {
	//     if($('#trSelect'+tr).hasClass('trSelect')===true){
	//     	$('#trSelect'+tr).removeClass('trSelect');
	//     }

	// });
	$('.trDefault').removeClass('trSelect');
	$('#'+id).addClass('trSelect');
}
// MATERIALES X PQR
function buscarMaterial(cod,cantFija,cant,invCant,invVal){
	$('#txtCodMat'+idMatGl).val('');
	//Validar que no se repita
	sw = false;
	var cont = $('#contRowMate').val();
	for(var i=1;i<=cont;i++){
		var codOrg = $.trim($('#txtCodMat'+i).val());
		if(codOrg==cod){
			sw = true;
		}
	}
	if(!sw){
	    $('#modalMaterial').modal('hide');
		$.ajax({
	        type:'POST',
	        url:'proc/legord_proc.php?accion=buscar_materiales',
	        data:{cod:cod},
	        success: function(data){
	        	if(data!=''){
	        		//
		            $('#txtCodMat'+idMatGl).val(cod);
		            $('#txtNombMat'+idMatGl).val(data);
		            $('#txtCantMat'+idMatGl).val(1);
		            $('#txtCantMatMax'+idMatGl).val(cant);
		            $('#txtCantMatFija'+idMatGl).val(cantFija);
		            $('#txtValMat'+idMatGl).val(invVal);
		            $('#txtValMatMax'+idMatGl).val(invVal);
		            $('#txtCantMatInv'+idMatGl).val(invCant);

					if(cantFija=='S'){
						if(invCant < cant){
							demo.showNotification('bottom','left', 'La cantidad del inventrio no es suficiente', 4);
							limpiarMaterial();
						}
					}
	        	}else{
					demo.showNotification('bottom','left', 'Porfavor coloque un material valido', 4);
	        	}
	        }
	    });
	}else{
		demo.showNotification('bottom','left', 'El material ya existe', 4);
	}
}
function actualizarMateriales(cod){
	tec = $('#txtCodTecn').val();
	$.ajax({
        type:'POST',
        url:'proc/legord_proc.php?accion=actualiza_materialesxpqr',
        data:{cod:cod,tec:tec},
        success: function(data){
        	$('#tablaDivMateriales').html(data);
			$('#modalMaterial').modal('show');
        }
    });
}
function solonumerosEnterMat(id){
	if(event.which == 13){
		colocarMaterial(id);
	}else{
	    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
	        event.returnValue = false;
	}
}
function colocarMaterial(id){
	cod = $('#txtCodMat'+id).val();
	if(cod!=''){
		buscarMaterialxCant(cod);
	}else{
		$('#txtCodMat'+id).val('');
		$('#txtTipoMat'+id).val('');
		$('#txtNombMat'+id).val('');
		$('#txtCantMat'+id).val('');
		$('#txtCantMatMax'+id).val('');
		$('#txtCantMatFija'+id).val('');
		$('#txtValMat'+id).val('');
		$('#txtValMatMax'+id).val('');
		$('#txtCantMatInv'+id).val('');

	}
}
function buscarMaterialxCant(cod){
	$('#txtCodMat'+idMatGl).val('');
	//Validar que no se repita
	sw = false;
	var cont = $('#contRowMate').val();
	for(var i=1;i<=cont;i++){
		var codOrg = $.trim($('#txtCodMat'+i).val());
		if(codOrg==cod){
			sw = true;
		}
	}
	if(!sw){
		tec = $('#txtCodTecn').val();
		pqr = $('#txtPqrCodEnc').val();
	    $('#modalMaterial').modal('hide');
		$.ajax({
	        type:'POST',
	        url:'proc/legord_proc.php?accion=buscar_materialesxcant',
	        data:{cod:cod,tec:tec,pqr:pqr},
	        dataType: "json",
	        success: function(data){
	        	if(data[0]!=''){
	        		//
		            $('#txtCodMat'+idMatGl).val(cod);
		            $('#txtNombMat'+idMatGl).val(data[0]);
		            $('#txtCantMat'+idMatGl).val(1);
		            $('#txtCantMatMax'+idMatGl).val(data[1]);
		            $('#txtCantMatFija'+idMatGl).val(data[2]);
		            
		            $('#txtValMat'+idMatGl).val(data[3]);
					$('#txtValMatMax'+idMatGl).val(data[3]);
		            $('#txtCantMatInv'+idMatGl).val(data[4]);
					
					if(data[0]!=''){
						$('#txtCantMat'+idMatGl).focus();
					}

					if(data[2]=='S'){
						if(data[4] < data[1]){
							demo.showNotification('bottom','left', 'La cantidad del inventario no es suficiente', 4);
							limpiarMaterial();
						}
					}
	        	}else{
					demo.showNotification('bottom','left', 'Porfavor coloque un material valido', 4);
					limpiarMaterial();
	        	}
	        }
	    });
	}else{
		demo.showNotification('bottom','left', 'El material ya existe', 4);
	}
}
function colocarMateCant(id){
	if(event.which == 13){
		calcularMaterial(id);
	}else{
	    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
	        event.returnValue = false;
	}
}
function calcularMaterial(id){
	cant = parseFloat($('#txtCantMat'+id).val()); //cantidad de material
	cantFija = parseFloat($('#txtCantMatMax'+id).val()); //cantidad maxima a legalizar
	cantFijaVal = $('#txtCantMatFija'+id).val(); //valor fijo S/N
	val = parseFloat($('#txtValMatMax'+id).val()); //valor del material
	cantInv = parseFloat($('#txtCantMatInv'+id).val()); //cantidad en inventario

	if(cantFijaVal=='N'){
		if(cant <= cantInv){
			if(cant <= cantFija){
				$('#txtValMat'+id).val(cant*val);
			}else{
				demo.showNotification('bottom','left', 'La Cantidad a legalizar no es valida, ', 4);
				$('#txtCantMat'+id).val(1);
				$('#txtValMat'+id).val(val);
			}
		}else{
			demo.showNotification('bottom','left', 'La Cantidad no es valida, el inventario no es suficiente', 4);
			$('#txtCantMat'+id).val(1);
			$('#txtValMat'+id).val(val);
		}
	}else{
		if(cantFija <= cantInv){
			$('#txtCantMat'+id).val(cantFija);
			$('#txtValMat'+id).val(cantFija*val);
		}else{
			demo.showNotification('bottom','left', 'La Cantidad no es valida, el inventario no es suficiente', 4);
			$('#txtCantMat'+id).val(0);
			$('#txtValMat'+id).val(0);
		}
	}
}
function selectedNewRowMat(id){
	$('.trDefaultMat').removeClass('trSelect');
	$('#'+id).addClass('trSelect');
}
function limpiarMaterial(){
	$('#txtCodMat'+idMatGl).val('');
	$('#txtNombMat'+idMatGl).val('');
	$('#txtCantMat'+idMatGl).val('');
	$('#txtCantMatMax'+idMatGl).val('');
	$('#txtCantMatFija'+idMatGl).val('');
	$('#txtValMat'+idMatGl).val('');
	$('#txtValMatMax'+idMatGl).val('');
	$('#txtCantMatInv'+idMatGl).val('');
}