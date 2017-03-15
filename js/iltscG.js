$(document).ready(function(){

	$('#btnCancelar').removeClass('disabled');
	$('#btnImprimir').removeClass('disabled');
	$('#btnConsulta').addClass('disabled');
	//$('#btnListaValores').addClass('disabled');
	$('#btnEditor').addClass('disabled');

	$('#btnListaValores').click(function(){
		if(modal==1){
			$('#modalDepartamentos').modal('show');
		}else if(modal==2){
			dep = $('#txtDepCod').val();
			nom = $('#txtDepNomb').val();
			if((dep!='') && (nom!='')){
				actualizarLocalidad(dep);
			}
		}else if(modal==3){
			
			$('#modalPqr').modal('show');
		}else if(modal==4){
			
			$('#modalPqr2').modal('show');
		}else{

			$('#modalTecnicos').modal('show');
		}
	});

	$('#btnCancelar').click(function(){
		$('#txtDepCod').val('');
		$('#txtDepNomb').val('');

		$('#txtLocCod').val('');
		$('#txtLocNomb').val('');

		$('#txtPqrIniCod').val('');
		$('#txtPqrIniNomb').val('');

		$('#txtPqrFinCod').val('');
		$('#txtPqrFinNomb').val('');

		$('#txtTecnCod').val('');
		$('#txtTecnNomb').val('');
	});
	$('#btnImprimir').click(function(){
		dep  = $("#txtDepCod").val();
		loc  = $("#txtLocCod").val();
		pqrI = $("#txtPqrIniCod").val();
		pqrF = $("#txtPqrFinCod").val();
		tec  = $("#txtTecnCod").val();

		if( (dep!='') && (loc!='') && (pqrI!='') && (pqrF!='') && (tec!='') ){
			imprimirOtRelacionadas(dep,loc,pqrI,pqrF,tec);
		}else{
			alert('Porfavor complete los datos')
		}
	});

	$('#txtDepCod').click(function(){ 
		modal=1;
		$('#txtDepNomb').val('');
		$('#txtLocCod').val('');
		$('#txtLocNomb').val('');
	});
	$('#txtLocCod').click(function(){ 
		modal=2;
		$('#txtLocNomb').val('');
	});
	$('#txtPqrIniCod').click(function(){
		modal=3;
		$('#txtPqrIniNomb').val('');
	});
	$('#txtPqrFinCod').click(function(){ 
		modal=4;
		$('#txtPqrFinNomb').val('');
	});
	$('#txtTecnCod').click(function(){ 
		modal=5;
		$('#txtTecnNomb').val('');
	});

	$("#txtDepCod").keypress(function(event){
		if(event.which == 13){
			dep = $.trim($('#txtDepCod').val());
			if(dep!=''){
				buscarDepartamento(dep);
			}else{ alert('Porfavor coloque un departamento valido') }
		}
	});
	$("#txtLocCod").keypress(function(event){
		if(event.which == 13){
			dep = $.trim($('#txtDepCod').val());
			nom = $('#txtDepNomb').val();
			loc = $.trim($('#txtLocCod').val());
			if((dep!='') && (nom!='')){
				buscarLocalidad(dep,loc);
			}else{ alert('Porfavor coloque un departamento valido') }
		}
	});
	$("#txtPqrIniCod").keypress(function(event){
		if(event.which == 13){
			pqr = $.trim($('#txtPqrIniCod').val());
			if(pqr!=''){
				buscarPqr(pqr);
			}else{ alert('Porfavor coloque un pqr valido') }
		}
	});
	$("#txtPqrFinCod").keypress(function(event){
		if(event.which == 13){
			pqr = $.trim($('#txtPqrFinCod').val());
			if(pqr!=''){
				buscarPqr2(pqr);
			}else{ alert('Porfavor coloque un pqr valido') }
		}
	});

	$("#txtTecnCod").keypress(function(event){
		if(event.which == 13){
			tec = $.trim($('#txtTecnCod').val());
			if(tec!=''){
				buscarTecnico(tec);
			}else{ alert('Porfavor coloque un tecnico valido') }
		}
	});
});

var modal = 1;
function addDepartamento(cod,dep){
	$('#txtDepCod').val(cod);
	$('#txtDepNomb').val(dep);
	$('#modalDepartamentos').modal('hide');
}
function buscarDepartamento(dep){
	$.ajax({
        type:'POST',
        url:'proc/iltscG_proc.php?accion=buscar_departamento',
        data:{dep:dep},
        success: function(data){
        	$('#txtDepNomb').val(data);
        }
    });
}

function addLocalidad(cod,loc){
	$('#txtLocCod').val(cod);
	$('#txtLocNomb').val(loc);
	$('#modalLocalidad').modal('hide');
}
function buscarLocalidad(dep,loc){
	$.ajax({
        type:'POST',
        url:'proc/iltscG_proc.php?accion=buscar_localidades',
        data:{dep:dep, loc:loc},
        success: function(data){
        	$('#txtLocNomb').val(data);
        }
    });
}
function actualizarLocalidad(dep){
	$.ajax({
        type:'POST',
        url:'proc/iltscG_proc.php?accion=actualizar_localidades',
        data:{dep:dep},
        success: function(data){
        	$('#divLocalidades').html(data);
        	$('#modalLocalidad').modal('show');
        }
    });
}

function addPqr(cod,pqr){
	$('#txtPqrIniCod').val(cod);
	$('#txtPqrIniNomb').val(pqr);
	$('#modalPqr').modal('hide');
}
function buscarPqr(pqr){
	$.ajax({
        type:'POST',
        url:'proc/iltscG_proc.php?accion=buscar_pqr',
        data:{pqr:pqr},
        success: function(data){
        	$('#txtPqrIniNomb').val(data);
        }
    });
}

function addPqr2(cod,pqr){
	$('#txtPqrFinCod').val(cod);
	$('#txtPqrFinNomb').val(pqr);
	$('#modalPqr2').modal('hide');
}
function buscarPqr2(pqr){
	$.ajax({
        type:'POST',
        url:'proc/iltscG_proc.php?accion=buscar_pqr',
        data:{pqr:pqr},
        success: function(data){
        	$('#txtPqrFinNomb').val(data);
        }
    });
}

function addTecnico(cod,tec){
	$('#txtTecnCod').val(cod);
	$('#txtTecnNomb').val(tec);
	$('#modalTecnicos').modal('hide');
}
function buscarTecnico(tec){
	$.ajax({
        type:'POST',
        url:'proc/iltscG_proc.php?accion=buscar_tecnico',
        data:{tec:tec},
        success: function(data){
        	$('#txtTecnNomb').val(data);
        }
    });
}

function imprimirOtRelacionadas(dep,loc,pqrI,pqrF,tec){

	window.open('iltscG_report.php?dep='+dep+'&&loc='+loc+'&&pqrI='+pqrI+'&&pqrF='+pqrF+'&&tec='+tec, "Imprimir OT Relacionadas", "width=1200, height=620");
}