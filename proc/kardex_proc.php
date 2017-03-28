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

    if($_REQUEST["accion"]=="obtener_cant_val_inicial"){ 
        $bodCod = $_REQUEST["bodCod"];
        $matCod = $_REQUEST["matCod"];
        $anio   = $_REQUEST["anio"];
        $mes    = $_REQUEST["mes"];
        $tipo   = $_REQUEST["tipo"];

        $fecha  = $anio.'-'.$mes;
        $nuevafecha = strtotime ( '-1 month' , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m' , $nuevafecha );

        $query ="SELECT sum(matemoin.MAMICANT) AS sumCant, sum(matemoin.MAMIVLOR) AS sumVal
                FROM moviinve
                    JOIN matemoin ON moviinve.MOINCODI = matemoin.MAMIMOIN
                    JOIN tipomovi ON tipomovi.TIMOCODI = moviinve.MOINTIMO
                    JOIN bodega ON bodega.bodecodi = moviinve.MOINBOOR
                WHERE (moviinve.MOINBOOR = $bodCod OR moviinve.MOINBODE = $bodCod) -- comparamos bodega 
                    AND matemoin.MAMIMATE = $matCod -- comparamos material
                    AND DATE_FORMAT(moviinve.MOINFECH, '%Y-%m') = '$nuevafecha' -- comparamos fecha";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $can =$row['sumCant'];
                $val =$row['sumVal'];
            }
        }
        $arr = array($can,$val);
        echo json_encode($arr);
    }

     if($_REQUEST["accion"]=="obtener_movimientos"){
        $table  = ''; 
        $bodCod = $_REQUEST["bodCod"];
        $matCod = $_REQUEST["matCod"];
        $anio   = $_REQUEST["anio"];
        $mes    = $_REQUEST["mes"];
        $tipo   = $_REQUEST["tipo"];

        $canIni   = $_REQUEST["canIni"];
        $valIni   = $_REQUEST["valIni"];
        $fecha  = $anio.'-'.$mes;

        $salCant = $canIni;
        $salValo = $valIni;

        $query ="SELECT moviinve.MOINCODI AS docum, DATE_FORMAT(moviinve.MOINFECH, '%d/%m/%Y') AS fecha, 'I' AS tipo, CONCAT(tipomovi.TIMODESC,' - ',bodega.BODENOMB) AS descrip,
                    tipomovi.TIMOSAEN AS es, matemoin.MAMICANT AS cant, matemoin.MAMIVLOR AS val
                FROM moviinve
                    JOIN matemoin ON moviinve.MOINCODI = matemoin.MAMIMOIN
                    JOIN tipomovi ON tipomovi.TIMOCODI = moviinve.MOINTIMO
                    JOIN bodega ON bodega.bodecodi = moviinve.MOINBOOR
                WHERE (moviinve.MOINBOOR = $bodCod OR moviinve.MOINBODE = $bodCod) -- comparamos bodega 
                    AND matemoin.MAMIMATE = $matCod -- comparamos material
                    AND moviinve.MOINFECH >= '$fecha' -- comparamos fecha";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $table .= '
                    <tr>
                        <td class="text-center">'.$row['docum'].'</td>
                        <td class="text-center">'.$row['fecha'].'</td>
                        <td class="text-center">'.$row['tipo'].'</td>
                        <td>'.$row['descrip'].'</td>
                        <td class="text-right">'.$row['es'].'</td>
                        <td class="text-right">'.number_format($row['cant'],0,"",".").'</td>
                        <td class="text-right">'.number_format($row['val'],0,"",".").'</td>
                    </tr>';
            }   
        }
        echo $table;
    }
?>