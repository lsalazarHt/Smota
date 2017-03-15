<?php
	date_default_timezone_set("America/Bogota");
	require 'template/start.php';

	$fecI  = $_REQUEST["fecI"];
	$fecF  = $_REQUEST["fecF"];
	

	//Meses
		$mes = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
	    $fecha = date('d').' de '.$mes[date('m')-1].' del '.date('Y');
	//
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Ot para Certificar</title>
	</head>
	<body class="hold-transition skin-blue layout-top-nav">
		<div class="">
			<div class="">
				<div class="">
					<br>
					<section class="">
						<div class="row">
							<div class="col-md-9 text-center">
								<h4>Listado de ordenes para Certificar</h4>
							</div>
							<div class="col-md-3 text-center">
								<h5><?php echo $fecha; ?></h5>
							</div>
						</div>

						<div class="row">
							<div class="form-group ">
		                     	<label class="col-sm-2 text-right" style="margin-top: 5px;">FECHA INICIAL : </label>
		                     	<label class="col-sm-2" style="margin-top: 5px;"><?php echo $fecI; ?></label>
		                     	<label class="col-sm-2 text-right" style="margin-top: 5px;">FECHA FINAL : </label>
		                     	<label class="col-sm-2" style="margin-top: 5px;"><?php echo $fecF; ?></label>
		                    </div>
						</div>
					</section>
					<hr>
					<section>
						<div class="row">
							<div class="col-md-12">
								<table class="table table-bordered table-hover table-condensed">
									<tr>
										<th width="100" class="text-center">N° ORDEN</th>
										<th width="100" class="text-center">FECHA ORDEN</th>
										<th width="150" class="text-center">FECHA ASIGNACION</th>
										<th colspan="2">USUARIO</th>
										<th colspan="2">TECNICO</th>
										<th colspan="2">PQR REPORTADA</th>
									</tr>
									<?php 
										$query ="SELECT OTDEPA, OTLOCA, OTNUME, OTFEORD, OTFEAS, OTUSUARIO, OTTECN, OTPQRREPO, OTESTA
													FROM ot
													WHERE (OTFEORD >= '$fecI' AND OTFEORD <= '$fecF')
													ORDER BY OTFEORD";
								        $respuesta = $conn->prepare($query) or die ($sql);
								        if(!$respuesta->execute()) return false;
								        if($respuesta->rowCount()>0){
								            while ($row=$respuesta->fetch()){
								            	//USUARIO
								            		$nombUsu = '';
											        $queryUsu ="SELECT * FROM usuarios WHERE USUCODI = ".$row['OTUSUARIO'];
											        $respuestaUsu = $conn->prepare($queryUsu) or die ($queryUsu);
											        if(!$respuestaUsu->execute()) return false;
											        if($respuestaUsu->rowCount()>0){
											            while ($rowUsu=$respuestaUsu->fetch()){
											                $nombUsu = utf8_encode($rowUsu['USUNOMB']);
											            }   
											        }
								            	//
											    //TECNICO
								            		$nombTecnico = '';
								            		if($row['OTTECN']!=''){
												        $queryTecnico ="SELECT * FROM tecnico WHERE TECNCODI = ".$row['OTTECN'];
												        $respuestaTecnico = $conn->prepare($queryTecnico) or die ($queryTecnico);
												        if(!$respuestaTecnico->execute()) return false;
												        if($respuestaTecnico->rowCount()>0){
												            while ($rowTecnico=$respuestaTecnico->fetch()){
												                $nombTecnico = utf8_encode($rowTecnico['TECNNOMB']);
												            }   
												        }
								            		}
								            	//
											    //PQR REPORTADA
								            		$nombPqrReport = '';
											        $queryPqrReport ="SELECT * FROM pqr WHERE PQRCODI = ".$row['OTPQRREPO'];
											        $respuestaPqrReport = $conn->prepare($queryPqrReport) or die ($queryPqrReport);
											        if(!$respuestaPqrReport->execute()) return false;
											        if($respuestaPqrReport->rowCount()>0){
											            while ($rowPqrReport=$respuestaPqrReport->fetch()){
											                $nombPqrReport = utf8_encode($rowPqrReport['PQRDESC']);
											            }   
											        }
								            	//
								            	echo '
								            	<tr>
								            		<td class="text-center">'.$row['OTDEPA'].'-'.$row['OTLOCA'].'-'.$row['OTNUME'].'</td>
								            		<td class="text-center">'.$row['OTFEORD'].'</td>
								            		<td class="text-center">'.$row['OTFEAS'].'</td>
								            		<td>'.$row['OTUSUARIO'].'</td>
								            		<td>'.$nombUsu.'</td>
								            		<td>'.$row['OTTECN'].'</td>
								            		<td>'.$nombTecnico.'</td>
								            		<td>'.$row['OTPQRREPO'].'</td>
								            		<td>'.$nombPqrReport.'</td>
								            	</tr>';
								            }   
								        }
									?>
								</table>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</body>
	<?php require 'template/end.php'; ?>
	<script type="text/javascript">
		$(document).ready(function(){
			window.print();
		});
	</script>
</html>