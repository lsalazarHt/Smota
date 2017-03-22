<?php
	date_default_timezone_set("America/Bogota");
	require 'template/start.php';

	$id  = $_REQUEST["id"];

    $nombLoc = '';
    $query ="SELECT tipomovi.timosaen,tipomovi.timocodi, tipomovi.timodesc,moviinve.moinfech, moviinve.moinvlor,
	            bo.bodecodi AS codBodOrg, bo.bodenomb AS nomBodOrg, de.bodecodi AS codBodDes, de.bodenomb AS nomBodDes,
                moviinve.moinsopo, moviinve.moindoso,  moviinve.moinobse
             FROM moviinve
                JOIN tipomovi on tipomovi.TIMOCODI = moviinve.mointimo
                JOIN bodega as bo on bo.bodecodi = moviinve.moinboor
                JOIN bodega AS de ON de.bodecodi = moviinve.moinbode
             WHERE moviinve.moincodi = $id";
    $respuesta = $conn->prepare($query) or die ($sql);
    if(!$respuesta->execute()) return false;
    if($respuesta->rowCount()>0){
        while ($row=$respuesta->fetch()){
            $moinfech = $row['moinfech']; //Fecha de movimiento
            $timosaen = ($row['timosaen']=='E') ? 'ENTRADA': 'SALIDA'; //Tipo de movimiento e/s
            $moinvlor = $row['moinvlor']; //Valor del tipo del movimiento
            $timocodi = $row['timocodi']; //codigo del tipo del movimiento
            $timodesc = $row['timodesc']; //nombre del tipo del movimiento

            $codBodOrg = $row['codBodOrg']; //codigo de bodega origen
            $nomBodOrg = $row['nomBodOrg']; //nombre de bodega origen

            $codBodDes = $row['codBodDes']; //codigo de bodega destino
            $nomBodDes = $row['nomBodDes']; //nombre de bodega destino

            $moinsopo = $row['moinsopo']; //soporte
            $moindoso = $row['moindoso']; //documento de soporte

            $moinobse = $row['moinobse']; //observacion
        }   
    }

	//Meses
		$mes = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
	    $fecha = date('d').' de '.$mes[date('m')-1].' del '.date('Y');
	//
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Movimiento de Inventario</title>
        <style>
            .negrillas{
                font-weight: bold;
                text-align: right;
            }   
        </style>
	</head>
	<body class="hold-transition skin-blue layout-top-nav">
		<div class="">
			<div class="">
				<div class="">
					<br>
					<section class="">
						<div class="row">
							<div class="col-md-9 text-center">
								<h4>MOVIMIENTO DE INVENTARIO</h4>
							</div>
						</div>
                        <br>
						<div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10">
                                <table class="table table-bordered">
                                    <tr>
                                        <td class="negrillas">CODIGO:</td>
                                        <td><?= $id ?></td>
                                        <td class="negrillas">VALOR:</td>
                                        <td><?= number_format($moinvlor,0,'','.') ?></td>
                                        <td class="negrillas">FECHA:</td>
                                        <td ><?= $moinfech ?></td>
                                    </tr>
                                    <tr>
                                        <td width="150" class="negrillas">TIPO MOVIMIENTO:</td>
                                        <td width="100"><?= $timosaen ?></td>
                                        <td colspan="4"><?= $timocodi.' - '.$timodesc ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50" class="negrillas">EN:</td>
                                        <td colspan="2"><?= $codBodOrg.' - '.mb_strtoupper($nomBodOrg) ?></td>
                                        <td width="50" class="negrillas">DESTINO:</td>
                                        <td colspan="2"><?= $codBodDes.' - '.mb_strtoupper($nomBodDes) ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50" class="negrillas">SOPORTE:</td>
                                        <td colspan="2"><?= $moinsopo ?></td>
                                        <td width="120" class="negrillas">DOC SOPORTE:</td>
                                        <td colspan="2"><?= $moindoso ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50" class="negrillas">OBSERVACION:</td>
                                        <td colspan="5"><?= $moinobse ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
					</section>
					<hr>
					<section>
						<div class="row">
							<div class="col-md-1"></div>
                            <div class="col-md-10">
								<table class="table table-bordered">
									<tr>
										<th width="150" class="text-center">COD MATERIAL</th>
										<th>DESC MATERIAL</th>
										<th width="150" class="text-center">CANTIDAD</th>
										<th width="150" class="text-center">VALOR</th>
									</tr>
									<?php 
										$query ="SELECT material.matecodi ,material.matedesc, matemoin.mamicant, matemoin.mamivlor
                                                 FROM matemoin
                                                 JOIN material on material.matecodi = matemoin.mamimate
                                                 WHERE matemoin.mamimoin = $id";
                                        $respuesta = $conn->prepare($query) or die ($sql);
                                        if(!$respuesta->execute()) return false;
                                        if($respuesta->rowCount()>0){
                                            while ($row=$respuesta->fetch()){
                                                echo '
                                                    <tr>
                                                        <td class="text-center">'.$row['matecodi'].'</td>
                                                        <td>'.$row['matedesc'].'</td>
                                                        <td class="text-center">'.$row['mamicant'].'</td>
                                                        <td class="text-center">'.number_format($row['mamivlor'],0,'','.').'</td>
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