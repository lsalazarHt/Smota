<?php 
	session_start();
	date_default_timezone_set('America/Bogota');
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="buscar_bodega_principal"){
        $cod = $_REQUEST["bod"];
        $dato = '';
        $query =" SELECT * FROM bodega WHERE BODEESTA='A' AND BODECODI = $cod";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $dato = utf8_encode($row['BODENOMB']);
            }   
        }
        echo $dato;
    }

    if($_REQUEST["accion"]=="obtener_materiales"){ 
        $table = '';
        $bod = $_REQUEST["bod"];
        $query ="SELECT material.MATECODI, material.MATEDESC, inventario.INVECAPRO, inventario.INVEVLRPRO, inventario.INVECAPRE, inventario.INVEVLRPRE
                 FROM inventario
                    INNER JOIN material ON material.MATECODI = inventario.INVEMATE
                 WHERE INVEBODE = $bod";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $mat = str_replace("\"","",$row['MATEDESC']);
                $table .= '
                    <tr onclick="addMaterial('.$row['MATECODI'].',\''.$mat.'\','.$row['INVECAPRO'].','.$row['INVEVLRPRO'].','.$row['INVECAPRE'].','.$row['INVEVLRPRE'].')">
                        <td class="text-center">'.$row['MATECODI'].'</td>
                        <td>'.$mat.'</td>
                    </tr>';
            }   
        }
        echo $table;
    }

    if($_REQUEST["accion"]=="buscar_material"){ 
        $dato0  = '';
        $dato1  = '';
        $dato2  = '';
        $bod = $_REQUEST["bod"];
        $mat = $_REQUEST["mat"];
        $query ="SELECT material.MATECODI, material.MATEDESC, inventario.INVECAPRO, inventario.INVEVLRPRO, inventario.INVECAPRE, inventario.INVEVLRPRE
                 FROM inventario
                    INNER JOIN material ON material.MATECODI = inventario.INVEMATE
                 WHERE inventario.INVEBODE = $bod AND material.MATECODI = $mat";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $dato0 = str_replace("\"","",$row['MATEDESC']);
                $dato1 = $row['INVECAPRO'];
                $dato2 = $row['INVEVLRPRO'];
                $dato3 = $row['INVECAPRE'];
                $dato4 = $row['INVEVLRPRE'];
            }   
        }
        $arr = array($dato0,$dato1,$dato2,$dato3,$dato4);
        echo json_encode($arr);
    }

    if($_REQUEST["accion"]=="obtener_series_materiales"){ 
        $table = '';
        $mat = $_REQUEST["mat"];
        $query ="SELECT * FROM movmatserie WHERE CDGOMTRIAL = $mat";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $table .= '
                    <tr>
                        <td class="text-center">'.$row['NMROSERIE'].'</td>
                    </tr>';
            }   
        }
        echo $table;
    }
?>