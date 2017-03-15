<?php
	session_start();
    
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="obtener_ultimo"){
		$dato='';
		$query ="SELECT NOTACODI FROM nota ORDER BY NOTACODI DESC LIMIT 1";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                	$dato = $row['NOTACODI'];                              
                }   
            }
            echo str_pad($dato+1,4,"0", STR_PAD_LEFT);
	}
	if($_REQUEST["accion"]=="buscar_clase"){
		$dato='';
		$query ="SELECT * FROM clasnota WHERE CLNOCODI = ".$_REQUEST["cod"];
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                	$dato = utf8_encode($row['CLNODESC']);                              
                }   
            }
            echo $dato;
	}
	if($_REQUEST["accion"]=="buscar_tecnico"){
		$dato='';
		$query ="SELECT * FROM tecnico WHERE TECNCODI = ".$_REQUEST["cod"];
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                	$dato = utf8_encode($row['TECNNOMB']);                              
                }   
            }
            echo $dato;
	}
	if($_REQUEST["accion"]=="guardar_nota"){
		$cod 	 = $_REQUEST["cod"];
		$cls 	 = $_REQUEST["cls"];
		$fech 	 = $_REQUEST["fech"];
		$tipo 	 = $_REQUEST["tipo"];
		$fechApl = $_REQUEST["fechApl"];
		$tec 	 = $_REQUEST["tec"];
		$val 	 = $_REQUEST["val"];
		$obs 	 = $_REQUEST["obs"];

        $query ="INSERT INTO nota (NOTACODI,NOTACLAS,NOTAFECH,NOTAFEAP,NOTATECN,NOTAVALO,NOTAOBSE,NOTASIGN,NOTAESTA) 
                VALUES ($cod,$cls,'$fech','$fechApl',$tec,$val,'$obs','$tipo','A')";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
	}
?>