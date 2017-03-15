<?php 
	session_start();
	date_default_timezone_set('America/Bogota');
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="buscar_acta"){
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
            }   
        }
        

        $arr = array($dato0,$dato1,$dato2,$dato3,$dato4,$dato5,$dato6,$dato7);
	    echo json_encode($arr);
	}
?>