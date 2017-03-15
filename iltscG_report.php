<?php
	date_default_timezone_set("America/Bogota");
	require 'template/start.php';

	$dep  = $_REQUEST["dep"];
	$loc  = $_REQUEST["loc"];
	$pqrI = $_REQUEST["pqrI"];
	$pqrF = $_REQUEST["pqrF"];
	$tec  = $_REQUEST["tec"];

	//DEPARTAMENTO
		$nombDep = '';
	    $query ="SELECT * FROM departam WHERE DEPACODI = $dep";
	    $respuesta = $conn->prepare($query) or die ($sql);
	    if(!$respuesta->execute()) return false;
	    if($respuesta->rowCount()>0){
	        while ($row=$respuesta->fetch()){
	            $nombDep = $row['DEPADESC'];
	        }   
	    }
	//

	//LOCALIDAD
	    $nombLoc = '';
	    $query ="SELECT * FROM localidad WHERE LOCACODI = $loc";
	    $respuesta = $conn->prepare($query) or die ($sql);
	    if(!$respuesta->execute()) return false;
	    if($respuesta->rowCount()>0){
	        while ($row=$respuesta->fetch()){
	            $nombLoc = $row['LOCANOMB'];
	        }   
	    }
	//

	//PQR INICIAL
	    $nombPqrI = '';
	    $query ="SELECT * FROM pqr WHERE PQRCODI = $pqrI";
	    $respuesta = $conn->prepare($query) or die ($sql);
	    if(!$respuesta->execute()) return false;
	    if($respuesta->rowCount()>0){
	        while ($row=$respuesta->fetch()){
	            $nombPqrI = $row['PQRDESC'];
	        }   
	    }
	//

	//PQR FINAL
	    $nombPqrF = '';
	    $query ="SELECT * FROM pqr WHERE PQRCODI = $pqrF";
	    $respuesta = $conn->prepare($query) or die ($sql);
	    if(!$respuesta->execute()) return false;
	    if($respuesta->rowCount()>0){
	        while ($row=$respuesta->fetch()){
	            $nombPqrF = $row['PQRDESC'];
	        }   
	    }
	//

	//TECNICO
		$nombTec = '';
        $query ="SELECT * FROM tecnico WHERE TECNCODI = $tec";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $nombTec = utf8_encode($row['TECNNOMB']);
            }   
        }
	//

	//Meses
		$mes = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
	    $fecha = date('d').' de '.$mes[date('m')-1].' del '.date('Y');
	//
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Ot Asignadas a tecnicos</title>
	</head>
	<body class="hold-transition skin-blue layout-top-nav">
		<div class="">
			<div class="">
				<div class="">
					<br>
					<section class="">
						<div class="row">
							<div class="col-md-9 text-center">
								<h4>Ordenes de Tabajo Asignadas a Tecnicos</h4>
							</div>
							<div class="col-md-3 text-center">
								<h5><?php echo $fecha; ?></h5>
							</div>
						</div>

						<div class="row">
							<div class="form-group ">
		                     	<label class="col-sm-2 text-right" style="margin-top: 5px;">DEPARTAMENTO : </label>
		                     	<label class="col-sm-3" style="margin-top: 5px;">( <?php echo $dep.' ) '.mb_strtoupper($nombDep); ?></label>
		                     	<label class="col-sm-1 text-right" style="margin-top: 5px;">PQR INICIAL : </label>
		                     	<label class="col-sm-4" style="margin-top: 5px;">( <?php echo $pqrI.' ) '.mb_strtoupper($nombPqrI); ?></label>
		                    </div>
						</div>
						<div class="row">
							<div class="form-group">
		                     	<label class="col-sm-2 text-right" style="margin-top: 5px;">LOCALIDAD : </label>
		                     	<label class="col-sm-3" style="margin-top: 5px;">( <?php echo $loc.' ) '.mb_strtoupper($nombLoc); ?></label>
		                     	<label class="col-sm-1 text-right" style="margin-top: 5px;">PQR FINAL : </label>
		                     	<label class="col-sm-4" style="margin-top: 5px;">( <?php echo $pqrF.' ) '.mb_strtoupper($nombPqrF); ?></label>
		                    </div>
						</div>
						<div class="row">
							<div class="form-group">
		                     	<label class="col-sm-2 text-right" style="margin-top: 5px;">TECNICO: </label>
		                     	<label class="col-sm-4" style="margin-top: 5px;">( <?php echo $tec.' ) '.mb_strtoupper($nombTec); ?></label>
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
										<th colspan="2">PQR REPORTADA</th>
									</tr>
									<?php 
										$query ="SELECT OTNUME, OTFEORD, OTFEAS, OTUSUARIO, OTPQRREPO, OTPQRENCO, OTMEDI 
												 FROM ot
												 WHERE OTESTA = 1 AND OTDEPA = $dep AND OTLOCA = $loc AND OTTECN = $tec 
												 		AND (OTPQRREPO >= $pqrI AND OTPQRREPO <= $pqrF)";
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
								            		<td class="text-center">'.$row['OTNUME'].'</td>
								            		<td class="text-center">'.$row['OTFEORD'].'</td>
								            		<td class="text-center">'.$row['OTFEAS'].'</td>
								            		<td>'.$row['OTUSUARIO'].'</td>
								            		<td>'.$nombUsu.'</td>
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