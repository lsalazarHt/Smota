<?php
	date_default_timezone_set("America/Bogota");
	require 'template/start.php';

	//TECNICO
	$tecnico = '';
	$query ="SELECT * FROM bodega WHERE BODEESTA = 'A' AND BODECODI = ".$_REQUEST["cod"];
	$respuesta = $conn->prepare($query) or die ($sql);
	if(!$respuesta->execute()) return false;
	if($respuesta->rowCount()>0){
	    while ($row=$respuesta->fetch()){
	    	$tecnico = $row['BODENOMB'];
	    }   
	}

	/*
		$query ="SELECT * FROM BODEGA WHERE BODEESTA = 'A' ORDER BY BODECODI";
		$respuesta = $conn->prepare($query) or die ($sql);
		if(!$respuesta->execute()) return false;
		if($respuesta->rowCount()>0){
		    while ($row=$respuesta->fetch()){
		        echo 
		        	'<tr onclick="colocarBodega('.$row['BODECODI'].',\''.$row['BODENOMB'].'\')">
		        		<td>'.$row['BODECODI'].'</td>
		        		<td>'.$row['BODENOMB'].'</td>
		        	</tr>';                                   
		    }   
		}
	*/

	//Meses
	$mes = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    $fecha = date('d').' de '.$mes[date('m')-1].' del '.date('Y');
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Reporte de inventario de tecnico</title>
	</head>
	<body class="hold-transition skin-blue layout-top-nav">
		<div class="">
			<div class="">
				<div class="">
					<br>
					<section class="">
						<div class="row">
							<div class="col-md-9 text-center">
								<h4>Imprime Existencia y Cupos de Materiales a Tecnicos</h4>
							</div>
							<div class="col-md-3 text-center">
								<h5><?php echo $fecha; ?></h5>
							</div>
						</div>

						<div class="row">
							<div class="form-group text-center">
		                     	<label class="col-sm-2" style="margin-top: 5px;">TECNICO : <?php echo $_REQUEST["cod"]; ?></label>
		                     	<label class="col-sm-2" style="margin-top: 5px;">BODEGA : <?php echo $_REQUEST["cod"]; ?></label>
		                     	<label class="col-sm-2" style="margin-top: 5px;"><?php echo utf8_encode($tecnico); ?></label>
		                    </div>
						</div>
					</section>
					<hr>
					<section>
						<div class="row">
							<div class="col-md-12">
								<table class="table table-bordered table-hover table-condensed">
									<tr>
										<th width="100">Codigo</th>
										<th>Descripcion</th>
										<th width="100" class="text-center">Cantidad</th>
										<th width="200" class="text-right">Valor</th>
									</tr>
									<?php 
										$query ="SELECT *
												 FROM inventario
												 WHERE INVEBODE = ".$_REQUEST["cod"]."
												 ORDER BY INVEMATE";
								        $respuesta = $conn->prepare($query) or die ($sql);
								        if(!$respuesta->execute()) return false;
								        if($respuesta->rowCount()>0){
								            while ($row=$respuesta->fetch()){
								            	
								            	//MATERIAL 
								                $queryMate ="SELECT MATEDESC FROM material WHERE MATECODI = ".$row["INVEMATE"];
								                $respuestaMate = $conn->prepare($queryMate) or die ($sql);
								                if(!$respuestaMate->execute()) return false;
								                if($respuestaMate->rowCount()>0){
								                    while ($rowMate=$respuestaMate->fetch()){
								                        $MATEDESC = $rowMate['MATEDESC'];                              
								                    }   
								                }

								                echo '
								                	<tr>
								                		<td>'.$row['INVEMATE'].'</td>
								                		<td>'.$MATEDESC.'</td>
								                		<td class="text-right">'.$row['INVECAPRO'].'</td>
								                		<td class="text-right">'.number_format($row['INVEVLRPRO'],0,'.',',').'</td>
								                	</tr>
								                ';

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