$(document).ready(function(){
	$('#btnCancelar').removeClass('disabled');
	$('#btnImprimir').removeClass('disabled');
	$('#btnConsulta').addClass('disabled');
	//$('#btnListaValores').addClass('disabled');
	$('#btnEditor').addClass('disabled');

	$('#btnCancelar').click(function(){
		org = $('#txtFechaOrg').val();

		$('#txtFecInicial').val(org);
		$('#txtFecFin').val(org);
	});

	$('#btnImprimir').click(function(){
		fecI  = $("#txtFecInicial").val();
		fecF  = $("#txtFecFin").val();

		if( (fecI!='') && (fecF!='') ){
			imprimirOtRelacionadas(fecI,fecF);
		}else{
			alert('Porfavor complete los datos')
		}
	});
});

function imprimirOtRelacionadas(fecI,fecF){

	window.open('rece_report.php?fecI='+fecI+'&&fecF='+fecF, "Imprimir OT Relacionadas", "width=1200, height=620");
}