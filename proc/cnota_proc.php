<?php
	session_start();
    //FUNCIONES
        function obtenerTecnico($cod){
            $conn = require '../template/sql/conexion.php';
            $nom = '';
            $query ="SELECT * FROM tecnico WHERE TECNCODI = $cod";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    $nom = utf8_encode($row['TECNNOMB']);                              
                }   
            }
            return $nom;
        }
        function obtenerClase($cod){
            $conn = require '../template/sql/conexion.php';
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

	$conn = require '../template/sql/conexion.php';
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
	if($_REQUEST["accion"]=="editar_nota"){
		$cod 	 = $_REQUEST["cod"];
		$cls 	 = $_REQUEST["cls"];
		$fech 	 = $_REQUEST["fech"];
		$tipo 	 = $_REQUEST["tipo"];
		$fechApl = $_REQUEST["fechApl"];
		$tec 	 = $_REQUEST["tec"];
		$val 	 = $_REQUEST["val"];
		$obs 	 = $_REQUEST["obs"];

        $query = "UPDATE nota 
                  SET NOTACLAS = $cls, NOTAFECH = '$fech', NOTAFEAP = '$fechApl', NOTATECN = $tec, NOTAVALO = $val, NOTAOBSE = '$obs', NOTASIGN = '$tipo'
                  WHERE NOTACODI = $cod";

        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
	}
    if($_REQUEST["accion"]=="buscar_nota"){
        $query ="SELECT * FROM nota WHERE NOTACODI = ".$_REQUEST["cod"];
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $dato0 = $row['NOTACLAS'];
                $dato1 = $row['NOTAFECH'];
                $dato2 = $row['NOTAFEAP'];
                $dato3 = $row['NOTATECN'];
                $dato4 = $row['NOTAVALO'];
                $dato5 = $row['NOTAOBSE'];
                $dato6 = $row['NOTASIGN'];
            }   
        }
        $nomClase = obtenerClase($dato0);
        $nomTecni = obtenerTecnico($dato3);
            
        $arr = array($dato0,$nomClase,$dato1,$dato2,$dato3,$nomTecni,$dato4,$dato5,$dato6);
        echo json_encode($arr);
    }
    if($_REQUEST["accion"]=="eliminar_nota"){
        $cod     = $_REQUEST["cod"];
        
        $query = "DELETE FROM nota WHERE NOTACODI = $cod";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }
?>