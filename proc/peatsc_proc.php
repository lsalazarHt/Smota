<?php 
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="buscar"){
		$dato='';
		$query ="SELECT CUADNOMB FROM cuadrilla WHERE CUADCODI = ".$_REQUEST["cod"];
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                	$dato = $row['CUADNOMB'];                              
                }   
            }
            echo $dato;
	}

	if($_REQUEST["accion"]=="obtener_campos"){
		$dato='';
		$sw=0;
		$query ="SELECT * FROM configarchivo WHERE ID = 1";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
        	$sw = 1;
            while ($row=$respuesta->fetch()){
            	$dato1 = $row['OTDEPA'];
            	$dato2 = $row['OTLOCA'];
            	$dato3 = $row['OTNUME'];
            	$dato4 = $row['OTFEORD'];
            	$dato5 = $row['OTUSUARIO'];
            	$dato6 = $row['OTPQRREPO'];
            	$dato7 = $row['OTOBSEAS'];
            }
        }
        
        $arr = array($dato1,$dato2,$dato3,$dato4,$dato5,$dato6,$dato7);
        echo json_encode($arr);
	}

	if($_REQUEST["accion"]=="guardarCambios"){

		$query = "UPDATE configarchivo 
				  SET OTDEPA='".$_REQUEST["a"]."', OTLOCA='".$_REQUEST["b"]."', OTNUME='".$_REQUEST["c"]."',
				  OTFEORD='".$_REQUEST["d"]."', OTUSUARIO='".$_REQUEST["e"]."', OTPQRREPO='".$_REQUEST["f"]."',
				  OTOBSEAS='".$_REQUEST["g"]."'
				  WHERE ID = 1";

        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
	}
?>