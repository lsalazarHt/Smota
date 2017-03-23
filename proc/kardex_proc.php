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
        $query ="SELECT material.MATECODI, material.MATEDESC, inventario.INVECAPRO, inventario.INVEVLRPRO
                 FROM inventario
                    INNER JOIN material ON material.MATECODI = inventario.INVEMATE
                 WHERE INVEBODE = $bod";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $mat = str_replace("\"","",$row['MATEDESC']);
                $table .= '
                    <tr onclick="addMaterial('.$row['MATECODI'].',\''.$mat.'\')">
                        <td class="text-center">'.$row['MATECODI'].'</td>
                        <td>'.$mat.'</td>
                    </tr>';
            }   
        }
        echo $table;
    }

    if($_REQUEST["accion"]=="buscar_material"){ 
        $table = '';
        $bod = $_REQUEST["bod"];
        $mat = $_REQUEST["mat"];
        $query ="SELECT material.MATECODI, material.MATEDESC, inventario.INVECAPRO, inventario.INVEVLRPRO
                 FROM inventario
                    INNER JOIN material ON material.MATECODI = inventario.INVEMATE
                 WHERE inventario.INVEBODE = $bod AND material.MATECODI = $mat";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $dato0 = str_replace("\"","",$row['MATEDESC']);
            }   
        }
        $arr = array($dato0);
        echo json_encode($arr);
    }

    if($_REQUEST["accion"]=="obtener_movimientos"){ 
        $table = date('2016-02-01',strtotime("-1 month")) ;
        /*$bodCod = $_REQUEST["bodCod"];
        $matCod = $_REQUEST["matCod"];
        $anio   = $_REQUEST["anio"];
        $mes    = $_REQUEST["mes"];
        $query ="SELECT moviinve.MOINDOSO, moviinve.MOINFECH, moviinve.MOINTIMO, tipomovi.TIMODESC, 
                        tipomovi.TIMOSAEN, matemoin.MAMICANT, matemoin.MAMIVLOR
                    FROM matemoin
                        INNER JOIN moviinve ON moviinve.MOINCODI = matemoin.MAMIMOIN
                        JOIN tipomovi ON tipomovi.TIMOCODI = moviinve.MOINTIMO
                    WHERE matemoin.MAMIMATE = $matCod AND moviinve.MOINBOOR = $bodCod AND 
                            ( (SUBSTRING(moviinve.MOINFECH,1,4)=$anio) AND 
                              (SUBSTRING(moviinve.MOINFECH,6,2)=$mes) )";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $table .= '
                    <tr>
                        <td class="text-center">'.$row['MOINDOSO'].'</td>
                        <td class="text-center">'.$row['MOINFECH'].'</td>
                        <td class="text-center">'.$row['MOINTIMO'].'</td>
                        <td class="">'.$row['TIMODESC'].'</td>
                        <td class="text-center">'.$row['TIMOSAEN'].'</td>
                        <td class="text-center">'.$row['MAMICANT'].'</td>
                        <td class="text-right">'.number_format($row['MAMIVLOR'],0,"",".").'</td>
                    </tr>';
            }   
        }*/
        echo $table;
    }
?>