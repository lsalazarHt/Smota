<?php 
	session_start();
	date_default_timezone_set('America/Bogota');
	$conn = require '../template/sql/conexion.php';

    function obtenerClassBodega($id){
	    $conn = require '../template/sql/conexion.php';
        $dato = '';
        $query ="SELECT bodeclas FROM bodega WHERE bodecodi = $id";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $dato = $row['bodeclas'];
            }   
        }
        return $dato;
    }

	if($_REQUEST["accion"]=="buscar_bodega_principal"){
        $cod = $_REQUEST["bod"];
        $dato = '';
        $query =" SELECT * FROM bodega WHERE BODEESTA='A' AND BODECODI = $cod AND (BODECLAS = 1 OR BODECLAS = 3)";
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

    //calcular cantidad y valor inicial
    if($_REQUEST["accion"]=="obtener_cant_val_inicial"){ 
        $bodCod = $_REQUEST["bodCod"];
        $matCod = $_REQUEST["matCod"];
        $anio   = $_REQUEST["anio"];
        $mes    = $_REQUEST["mes"];
        $tipo   = $_REQUEST["tipo"];

        $mes = ($mes<10) ? '0'.$mes : $mes;
        $fecha  = $anio.'-'.$mes;
        $nuevafecha = strtotime ( '-1 month' , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m' , $nuevafecha );

        $canEnt = 0; 
        $valEnt = 0;
        $canSal = 0; 
        $valSal = 0;
        $can = 0;
        $val = 0;

        //Entrada Almacen
            $query ="SELECT sum(matemoin.MAMICANT) AS sumCant, sum(matemoin.MAMIVLOR) AS sumVal
                    FROM moviinve
                        JOIN matemoin ON moviinve.MOINCODI = matemoin.MAMIMOIN
                        JOIN tipomovi ON tipomovi.TIMOCODI = moviinve.MOINTIMO
                        JOIN bodega ON bodega.bodecodi = moviinve.MOINBOOR
                    WHERE (moviinve.MOINBOOR = $bodCod OR moviinve.MOINBODE = $bodCod) -- comparamos bodega 
                        AND matemoin.MAMIMATE = $matCod -- comparamos material
                        AND DATE_FORMAT(moviinve.MOINFECH, '%Y-%m') = '$nuevafecha' -- comparamos fecha
                        AND tipomovi.TIMOSAEN = 'E' -- seleccionamos Entrada/Salida
                        AND matemoin.MAMIPROP = '$tipo' -- material propio prestado";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    $canEnt =$row['sumCant'];
                    $valEnt =$row['sumVal'];
                }
            }
        //
        //Salida Almacen
            $query ="SELECT sum(matemoin.MAMICANT) AS sumCant, sum(matemoin.MAMIVLOR) AS sumVal
                    FROM moviinve
                        JOIN matemoin ON moviinve.MOINCODI = matemoin.MAMIMOIN
                        JOIN tipomovi ON tipomovi.TIMOCODI = moviinve.MOINTIMO
                        JOIN bodega ON bodega.bodecodi = moviinve.MOINBOOR
                    WHERE (moviinve.MOINBOOR = $bodCod OR moviinve.MOINBODE = $bodCod) -- comparamos bodega 
                        AND matemoin.MAMIMATE = $matCod -- comparamos material
                        AND DATE_FORMAT(moviinve.MOINFECH, '%Y-%m') = '$nuevafecha' -- comparamos fecha
                        AND tipomovi.TIMOSAEN = 'S' -- seleccionamos Entrada/Salida
                        AND matemoin.MAMIPROP = '$tipo' -- material propio prestado";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    $canSal =$row['sumCant'];
                    $valSal =$row['sumVal'];
                }
            }
        //

        //clase tipo tecnico //legalizacion
        $clasBod = obtenerClassBodega($bodCod);
        if($clasBod==1){
            //salida legalizacion
                $query ="SELECT sum(MAOTCANT) AS sumCant, sum(MAOTVLOR) AS sumVal
                         FROM maleottr 
                         WHERE maottecn = $bodCod -- comparamos bodega
                         AND maotmate = $matCod -- comparamos material
                         AND DATE_FORMAT(MAOTFECH, '%Y-%m') = '$nuevafecha' -- comparamos fecha
                         AND MAOTPROP = '$tipo'  -- material propio prestado";
                $respuesta = $conn->prepare($query) or die ($sql);
                if(!$respuesta->execute()) return false;
                if($respuesta->rowCount()>0){
                    while ($row=$respuesta->fetch()){
                        $canSalLeg =$row['sumCant'];
                        $valSalLeg =$row['sumVal'];
                    }
                }
            //
            $can = ($canSal + $canSalLeg) - $canEnt;
            $val = ($valSal + $valSalLeg) - $valEnt;
        }else{
            $can = $canEnt - $canSal;
            $val = $valEnt - $valSal;
        }

        $arr = array($can,$val);
        echo json_encode($arr);
    }

    // calcular entradas y salidas de materian el bodega
    if($_REQUEST["accion"]=="obtener_movimientos_detalle"){ 
        $bodCod = $_REQUEST["bodCod"];
        $matCod = $_REQUEST["matCod"];
        $anio   = $_REQUEST["anio"];
        $mes    = $_REQUEST["mes"];
        $tipo   = $_REQUEST["tipo"];
        $mes = ($mes<10) ? '0'.$mes : $mes;
        $fecha  = $anio.'-'.$mes;
        
        $canEnt = 0; 
        $valEnt = 0;
        $canSal = 0; 
        $valSal = 0;
        //Entrada
            $query ="SELECT sum(matemoin.MAMICANT) AS sumCant, sum(matemoin.MAMIVLOR) AS sumVal
                    FROM moviinve
                        JOIN matemoin ON moviinve.MOINCODI = matemoin.MAMIMOIN
                        JOIN tipomovi ON tipomovi.TIMOCODI = moviinve.MOINTIMO
                        JOIN bodega ON bodega.bodecodi = moviinve.MOINBOOR
                    WHERE (moviinve.MOINBOOR = $bodCod OR moviinve.MOINBODE = $bodCod) -- comparamos bodega 
                        AND matemoin.MAMIMATE = $matCod -- comparamos material
                        AND DATE_FORMAT(moviinve.MOINFECH, '%Y-%m') >= '$fecha' -- comparamos fecha
                        AND tipomovi.TIMOSAEN = 'E' -- seleccionamos Entrada/Salida
                        AND matemoin.MAMIPROP = '$tipo' -- material propio prestado";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    $canEnt =$row['sumCant'];
                    $valEnt =$row['sumVal'];
                }
            }
        //
        //Salida
            $query ="SELECT sum(matemoin.MAMICANT) AS sumCant, sum(matemoin.MAMIVLOR) AS sumVal
                    FROM moviinve
                        JOIN matemoin ON moviinve.MOINCODI = matemoin.MAMIMOIN
                        JOIN tipomovi ON tipomovi.TIMOCODI = moviinve.MOINTIMO
                        JOIN bodega ON bodega.bodecodi = moviinve.MOINBOOR
                    WHERE (moviinve.MOINBOOR = $bodCod OR moviinve.MOINBODE = $bodCod) -- comparamos bodega 
                        AND matemoin.MAMIMATE = $matCod -- comparamos material
                        AND DATE_FORMAT(moviinve.MOINFECH, '%Y-%m') >= '$fecha' -- comparamos fecha
                        AND tipomovi.TIMOSAEN = 'S' -- seleccionamos Entrada/Salida
                        AND matemoin.MAMIPROP = '$tipo' -- material propio prestado";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    $canSal =$row['sumCant'];
                    $valSal =$row['sumVal'];
                }
            }
        //

        //clase tecnico //legalizacion
        if(obtenerClassBodega($bodCod) == 1){
            $query ="SELECT SUM(MAOTCANT) AS cant, SUM(MAOTVLOR) AS val
                        FROM maleottr 
                        WHERE maottecn = $bodCod -- comparamos bodega
                        AND maotmate = $matCod -- comparamos material
                        AND DATE_FORMAT(MAOTFECH, 'Y-%m%') >= '$fecha' -- comparamos fecha
                        AND MAOTPROP = '$tipo' -- material propio prestado";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    $canEnt = $canEnt + (int) $row['cant'];
                    $valEnt = $valEnt + (int) $row['val'];
                }
            }
            $canEnt = ($canEnt==null) ? 0 : $canEnt;
            $canSal = ($canSal==null) ? 0 : $canSal;
            $valEnt = ($valEnt==null) ? 0 : $valEnt;
            $valSal = ($valSal==null) ? 0 : $valSal;

            $arr = array($canSal,$canEnt,$valSal,$valEnt);
        }else{
            $canEnt = ($canEnt==null) ? 0 : $canEnt;
            $canSal = ($canSal==null) ? 0 : $canSal;
            $valEnt = ($valEnt==null) ? 0 : $valEnt;
            $valSal = ($valSal==null) ? 0 : $valSal;

            $arr = array($canEnt,$canSal,$valEnt,$valSal);
        }
        echo json_encode($arr);
    }

    //calcular valor del bodega - material
    if($_REQUEST["accion"]=="obtener_valor_sistema"){ 
        $bodCod = $_REQUEST["bodCod"];
        $matCod = $_REQUEST["matCod"];
        $anio   = $_REQUEST["anio"];
        $mes    = $_REQUEST["mes"];
        $tipo   = $_REQUEST["tipo"];

        $can = 0;
        $val = 0;
        //
            if($tipo=='S'){
                $sqlCant = 'INVECAPRO';
                $sqlValo = 'INVEVLRPRO';
            }else{
                $sqlCant = 'INVECAPRE';
                $sqlValo = 'INVEVLRPRE';
            }

            $query ="SELECT $sqlCant, $sqlValo FROM inventario 
            WHERE invebode = $bodCod AND invemate = $matCod";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    $can =$row[$sqlCant];
                    $val =$row[$sqlValo];
                }
            }
        //

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

        $canIni = (int)$_REQUEST["canIni"]; //cantidad inicial
        $valIni = (int)$_REQUEST["valIni"]; //valor inicial
        $fecha  = $anio.'-'.$mes;

        $canTotal = $canIni; //cantidades totales
        $valTotal = $valIni; //valores totales 

        $salCant = 0; //cantidad tabla
        $salValo = 0; //valor tabla

        $i = 0;
        $clasBod = obtenerClassBodega($bodCod);
        //Almacen
            $query ="SELECT moviinve.MOINCODI AS docum, DATE_FORMAT(moviinve.MOINFECH, '%d/%m/%Y') AS fecha, 'A' AS tipo, CONCAT(tipomovi.TIMODESC,' - ',bodega.BODENOMB) AS descrip,
                        tipomovi.TIMOSAEN AS es, matemoin.MAMICANT AS cant, matemoin.MAMIVLOR AS val
                    FROM moviinve
                        JOIN matemoin ON moviinve.MOINCODI = matemoin.MAMIMOIN
                        JOIN tipomovi ON tipomovi.TIMOCODI = moviinve.MOINTIMO
                        JOIN bodega ON bodega.bodecodi = moviinve.MOINBOOR
                    WHERE (moviinve.MOINBOOR = $bodCod OR moviinve.MOINBODE = $bodCod) -- comparamos bodega 
                        AND matemoin.MAMIMATE = $matCod -- comparamos material
                        AND DATE_FORMAT(moviinve.MOINFECH, 'Y-%m%') >= '$fecha' -- comparamos fecha
                        AND matemoin.MAMIPROP = '$tipo' -- material propio prestado";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    $ent_sal = $row['es'];

                    if($clasBod==1){
                        $ent_sal = ($row['es']=='S') ? 'E':'S'; 
                    }
                    

                    if($ent_sal=='S'){
                        $salCant = (int)$canTotal - (int)$row['cant'];
                        $salValo = (int)$valTotal - (int)$row['val'];

                        $canTotal = $salCant;
                        $valTotal = $salValo;
                    }else{
                        $salCant = (int)$canTotal + (int)$row['cant'];
                        $salValo = (int)$valTotal + (int)$row['val'];

                        $canTotal = $salCant;
                        $valTotal = $salValo;
                    }

                    $tbCant = $canTotal;
                    $tbVal  = $valTotal;

                    $table .= '
                        <tr id="trSelect'.$i.'" class="trDefault" onClick="trSelect(\'trSelect'.$i.'\')" ondblclick="enviarMovimiento('.$row['docum'].',\'A\')">
                            <td class="text-left">'.$row['docum'].'</td>
                            <td class="text-center">'.$row['fecha'].'</td>
                            <td class="text-center">'.$row['tipo'].'</td>
                            <td>'.$row['descrip'].'</td>
                            <td class="text-center">'.$ent_sal.'</td>
                            <td class="text-right">'.number_format($row['cant'],0,"",".").'</td>
                            <td class="text-right">'.number_format($row['val'],0,"",".").'</td>

                            <td class="text-right">'.number_format($tbCant,0,"",".").'</td>
                            <td class="text-right">'.number_format($tbVal,0,"",".").'</td>
                        </tr>';
                    $i++;
                }   
            }
        //

        //clase tipo tecnico // legalizacion
        if($clasBod==1){
            //Legalizacion
                $query ="SELECT MAOTNUMO AS docum, DATE_FORMAT(MAOTFECH,'%d/%m/%Y') AS fecha,'L' AS tipo,'LEGALIZACION' AS descrip,'S' AS es, MAOTCANT AS cant, MAOTVLOR AS val
                         FROM maleottr 
                         WHERE maottecn = $bodCod -- comparamos bodega
                            AND maotmate = $matCod -- comparamos material
                            AND DATE_FORMAT(MAOTFECH, 'Y-%m%')  >= '$fecha' -- comparamos fecha
                            AND MAOTPROP = '$tipo' -- material propio prestado";
                $respuesta = $conn->prepare($query) or die ($sql);
                if(!$respuesta->execute()) return false;
                if($respuesta->rowCount()>0){
                    while ($row=$respuesta->fetch()){
                        $ent_sal = $row['es'];
                        
                       if($ent_sal=='S'){
                        $salCant = (int)$canTotal - (int)$row['cant'];
                        $salValo = (int)$valTotal - (int)$row['val'];

                        $canTotal = $salCant;
                        $valTotal = $salValo;
                    }else{
                        $salCant = (int)$canTotal + (int)$row['cant'];
                        $salValo = (int)$valTotal + (int)$row['val'];

                        $canTotal = $salCant;
                        $valTotal = $salValo;
                    }

                    $tbCant = $canTotal;
                    $tbVal  = $valTotal;

                        $table .= '
                            <tr id="trSelect'.$i.'" class="trDefault" onClick="trSelect(\'trSelect'.$i.'\')" ondblclick="enviarMovimiento('.$row['docum'].',\'L\')">
                                <td class="text-left">'.$row['docum'].'</td>
                                <td class="text-center">'.$row['fecha'].'</td>
                                <td class="text-center">'.$row['tipo'].'</td>
                                <td>'.$row['descrip'].'</td>
                                <td class="text-center">'.$row['es'].'</td>
                                <td class="text-right">'.number_format($row['cant'],0,"",".").'</td>
                                <td class="text-right">'.number_format($row['val'],0,"",".").'</td>

                                <td class="text-right">'.number_format($tbCant,0,"",".").'</td>
                                <td class="text-right">'.number_format($tbVal,0,"",".").'</td>
                            </tr>';
                        $i++;
                    }   
                }
            //
        }

        echo $table;
    }
?>