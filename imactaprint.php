<?php 
	//FUNCIONES
		function buscarManoObra($cod){
			$conn = require 'template/sql/conexion.php';
			$nom = '';
			$query ="SELECT * FROM manobra WHERE MOBRCODI = $cod";
	        $respuesta = $conn->prepare($query) or die ($sql);
	        if(!$respuesta->execute()) return false;
	        if($respuesta->rowCount()>0){
	            while ($row=$respuesta->fetch()){
	            	$nom = utf8_encode($row['MOBRDESC']);                              
	            }   
	        }
	        return $nom;
		}
		function buscarUsuario($cod){
			$conn = require 'template/sql/conexion.php';
			$nom = '';
			$query ="SELECT * FROM usuarios WHERE USUCODI = $cod";
	        $respuesta = $conn->prepare($query) or die ($sql);
	        if(!$respuesta->execute()) return false;
	        if($respuesta->rowCount()>0){
	            while ($row=$respuesta->fetch()){
	            	$nom = utf8_encode($row['USUNOMB']);                              
	            }   
	        }
	        return $nom;
		}
		function buscarClaseNota($cod){
			$conn = require 'template/sql/conexion.php';
			$nom = '';
			$query ="SELECT * FROM clasnota WHERE CLNOCODI = $cod";
	        $respuesta = $conn->prepare($query) or die ($sql);
	        if(!$respuesta->execute()) return false;
	        if($respuesta->rowCount()>0){
	            while ($row=$respuesta->fetch()){
	            	$nom = utf8_encode($row['CLNODESC']);                              
	            }   
	        }
	        return $nom;
		}
	//
	$cod = $_REQUEST["cod"];
	$conn = require 'template/sql/conexion.php';

	$query ="SELECT ACTANUME, tecnico.TECNCODI, tecnico.TECNNOMB, ACTAFECH, ACTAESTA, ACTAVABR,ACTAVANE, ACTAOBSE
			 FROM acta
				INNER JOIN tecnico ON tecnico.TECNCODI = acta.ACTATECN
			 WHERE acta.ACTANUME = ".$_REQUEST["cod"];
    $respuesta = $conn->prepare($query) or die ($sql);
    if(!$respuesta->execute()) return false;
    if($respuesta->rowCount()>0){
        while ($row=$respuesta->fetch()){
        	$dato0 = $row['ACTANUME'];
        	$dato1 = $row['TECNCODI'];
        	$dato2 = utf8_encode($row['TECNNOMB']);
        	$dato3 = $row['ACTAFECH'];
        	$dato4 = $row['ACTAESTA'];
        	$dato5 = number_format($row['ACTAVABR'],0,"",".");
        	$dato6 = number_format($row['ACTAVANE'],0,"",".");
        	$dato7 = $row['ACTAOBSE'];

        	if( $dato4 == 'A' ){
        		$dato4 = 'Aprobada';
        	}else{
        		$dato4 = 'Generada';
        	}
        }   
    }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<link href='https://fonts.googleapis.com/css?family=Marvel' rel='stylesheet' type='text/css'>
		<meta charset="UTF-8">
		<title>Acta #<?php echo str_pad($cod,4,"0", STR_PAD_LEFT); ?></title>
		<style type="text/css">
			body{
				font-family: 'Marvel', sans-serif;
			}
			.table {
			    border-collapse: collapse !important;
			  }
			  .table td,
			  .table th {
			    background-color: #fff !important;
			  }
			  .table-bordered th,
			  .table-bordered td {
			    border: 1px solid #ddd !important;
			  }
			.text-center{
				text-align: center;
			}
			.text-right{
				text-align: right;
			}
			th, td{
				padding-left: 5px;
				padding-right: 5px;
			}
		</style>
	</head>
	<body>
		<table>
			<tr>
				<td width="80"><b>Acta N°:</b></td>
				<td><?php echo str_pad($cod,4,"0", STR_PAD_LEFT); ?></td>
				<td><b>Fecha:</b></td>
				<td width="80"><?php echo $dato3; ?></td>
				<td><b>Estado:</b></td>
				<td width="80"><?php echo $dato4; ?></td>
			</tr>
			<tr>
				<td><b>Valor Bruto:</b></td>
				<td width="80">$ <?php echo $dato5; ?></td>
				<td><b>Valor Neto:</b></td>
				<td width="80">$ <?php echo $dato6; ?></td>
			</tr>
			<tr>
				<td><b>Tecnico:</b></td>
				<td width="200"><?php echo $dato1.' - '.$dato2; ?></td>
			</tr>
			<tr>
				<td><b>Observacion:</b></td>
				<td><?php echo $dato7; ?></td>
			</tr>
		</table>
		<hr>
		<!-- MANOS DE OBRA-->
		<?php
			$i=0;
			$table = '';
			$query = "SELECT mobrottr.ID, mobrottr.MOOTDEPA, mobrottr.MOOTLOCA, mobrottr.MOOTNUMO, ot.OTFEORD, ot.OTFEAS, ot.OTCUMP, ot.OTPQRREPO, mobrottr.MOOTMOBR, ot.OTUSUARIO, mobrottr.MOOTVAPA
				  	  FROM mobrottr
				  	  INNER JOIN ot ON ot.OTNUME = mobrottr.MOOTNUMO 
				  	  WHERE MOOTACTA = $cod";

	        $respuesta = $conn->prepare($query) or die ($sql);
	        if(!$respuesta->execute()) return false;
	        if($respuesta->rowCount()>0){
	            while ($row=$respuesta->fetch()){
	            	$i++;
	            	$mObra = buscarManoObra( $row['MOOTMOBR'] );
	            	$usuar = buscarUsuario( $row['OTUSUARIO'] );
	            	$table .= '
	            		<tr>
	        				<td class="" style="vertical-align:middle">'.$row['MOOTDEPA'].'-'.$row['MOOTLOCA'].'-'.$row['MOOTNUMO'].'</td>
	        				<td class="text-center" style="vertical-align:middle">'.$row['OTFEORD'].'</td>
	        				<td class="text-center" style="vertical-align:middle">'.$row['OTPQRREPO'].'</td>
	        				<td class="" style="vertical-align:middle"><small>'.$mObra.'</small></td>
	        				<td class="text-right" style="vertical-align:middle">$ '.number_format($row['MOOTVAPA'],0,"",".").'</td>
	        			</tr>';
	            }   
	        }
	        if($i>0){
	        	$manoObra = '
					<h3>Manos de Obras</h3>
					<table class="table table-bordered">
						<tr>
							<th class="text-center" width="90">ORDEN</th>
							<th class="text-center" width="90" style="vertical-align:middle">FECHA ORDEN</th>
							<th class="text-center" width="60" style="vertical-align:middle">PQR</th>
							<th style="vertical-align:middle">MANO DE OBRA</th>
							<th class="text-right" width="90" style="vertical-align:middle">VALOR</th>
						</tr>
						'.$table.'
					</table>
					<br>
					<hr>
	        	';
	        	echo $manoObra;
	        }
		?>
		<!-- NOTAS -->
		<?php
			$j=0;
			$table = '';
			$query = "SELECT *
				  	  FROM nota
				  	  WHERE NOTAACTA = $cod";

	        $respuesta = $conn->prepare($query) or die ($sql);
	        if(!$respuesta->execute()) return false;
	        if($respuesta->rowCount()>0){
	            while ($row=$respuesta->fetch()){
	            	$j++;
	            	$clases = buscarClaseNota( $row['NOTACLAS'] );
	            	$table .= '
	            		<tr>
	        				<td class="text-center" style="vertical-align:middle">'.str_pad($row['NOTACODI'],4,"0", STR_PAD_LEFT).'</td>
	        				<td class="text-center" style="vertical-align:middle">'.$clases.'</td>
	        				<td class="text-center" style="vertical-align:middle">'.$row['NOTAFECH'].'</td>
	        				<td class="text-center" style="vertical-align:middle"><small>'.$row['NOTAFEAP'].'</small></td>
	        				<td class="text-right" style="vertical-align:middle">$ '.number_format($row['NOTAVALO'],0,"",".").'</td>
	        				<td class="text-center" style="vertical-align:middle"><small>'.$row['NOTASIGN'].'</small></td>
	        			</tr>';
	            }   
	        }
			if($j>0){
				$notas = '
					<h3>Notas</h3>
					<table class="table table-bordered">
						<tr>
							<th class="text-center" width="50">CODIGO</th>
							<th style="vertical-align:middle">CLASE</th>
							<th class="text-center" width="90" style="vertical-align:middle">FECHA</th>
							<th class="text-center" width="90" style="vertical-align:middle">FECHA APLICACION</th>
							<th class="text-right" width="90" style="vertical-align:middle">VALOR</th>
							<th class="text-center" width="20">TIPO</th>
						</tr>
						'.$table.'
					</table>
					<br>
					<hr>
				';
				echo $notas;
			}
		?>
	<?php require 'template/end.php'; ?>
	<script type="text/javascript">
		$(document).ready(function(){
			window.print();
		});
	</script>
</html>