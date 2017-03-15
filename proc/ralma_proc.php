<?php 
	session_start();
	date_default_timezone_set('America/Bogota');
	$conn = require '../template/sql/conexion.php';

    function obtener_tipo_movimiento($id){
    	$matPropio = null;
        $conn = require '../template/sql/conexion.php';
        $query ="SELECT timoprop FROM tipomovi WHERE timocodi = $id";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $matPropio = $row['timoprop'];
            }
        }
        return $matPropio;
    }
    function obtener_tipo_movimiento_ent_sal($id){
    	$tipoMov = null;
        $conn = require '../template/sql/conexion.php';
        $query ="SELECT TIMOSAEN FROM tipomovi WHERE timocodi = $id";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $tipoMov = $row['TIMOSAEN'];
            }
        }
        return $tipoMov;
    }

    if($_REQUEST["accion"]=="buscar_bodega_principal"){
        $cod = $_REQUEST["bod"];
        $dato = '';
        $query =" SELECT * FROM bodega WHERE BODEESTA='A' AND BODECODI = $cod AND BODECLAS = 3";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $dato = utf8_encode($row['BODENOMB']);
            }   
        }
        echo $dato;
    }
    if($_REQUEST["accion"]=="actualizar_bodega_destino"){
        
        $tipMov = $_REQUEST["tipo"];
        $table  = '';
        $clsMov = '';
        //OBTENER CLASE DE MOVIMIENTO
            $query ="SELECT TIMVCLBO FROM tipomovi WHERE TIMOCODI = $tipMov";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    $clsMov = $row['TIMVCLBO'];
                }   
            }
        //

        $query ="SELECT * FROM bodega WHERE BODEESTA='A' AND BODECLAS = $clsMov";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $table .= 
                    '<tr onclick="addBodegaDesti(\''.$row['BODECODI'].'\',\''.utf8_encode($row['BODENOMB']).'\')">
                        <td class="text-center">'.$row['BODECODI'].'</td>
                        <td>'.utf8_encode($row['BODENOMB']).'</td>
                    </tr>';                                   
            }   
        }
        echo $table;
    }
    if($_REQUEST["accion"]=="buscar_bodega_destino"){
        $cod = $_REQUEST["bod"];
        $tipMov = $_REQUEST["tipo"];
        $dato = '';
        $clsMov = '';
        //OBTENER CLASE DE MOVIMIENTO
            $query ="SELECT TIMVCLBO FROM tipomovi WHERE TIMOCODI = $tipMov";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    $clsMov = $row['TIMVCLBO'];
                }   
            }
        //

        $query =" SELECT * FROM bodega WHERE BODEESTA='A' AND BODECODI = $cod AND BODECLAS = $clsMov";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $dato = utf8_encode($row['BODENOMB']);
            }   
        }
        echo $dato;
    }
    if($_REQUEST["accion"]=="buscar_tipo_movimiento"){
        $cod = $_REQUEST["cod"];
        $tipMov = $_REQUEST["tipo"];
        $dato = '';
        $query ="SELECT timodesc FROM tipomovi WHERE TIMOSAEN = '$tipMov' AND timocodi = $cod";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $dato = utf8_encode($row['timodesc']);
            }   
        }
        echo $dato;
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
                $dato1 = $row['INVECAPRO'];
                $dato2 = $row['INVEVLRPRO'];
            }   
        }
        $arr = array($dato0,$dato1,$dato2);
        echo json_encode($arr);
    }
    if($_REQUEST["accion"]=="obtener_cod_movimiento"){
		$dato = 0;
		$query =" SELECT MOINCODI FROM moviinve ORDER BY MOINCODI DESC LIMIT 1";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
            	$dato = $row['MOINCODI'];
            }   
        }
	    echo $dato+1;
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
                    <tr onclick="addMaterial('.$row['MATECODI'].',\''.$mat.'\','.$row['INVECAPRO'].','.$row['INVEVLRPRO'].')">
                        <td class="text-center">'.$row['MATECODI'].'</td>
                        <td>'.$mat.'</td>
                    </tr>';
            }   
        }
        echo $table;
    }

	if($_REQUEST["accion"]=="actualizar_tipo_movimiento"){
		$table = '';
		$tipMov = $_REQUEST["tipo"];
        $query ="SELECT timocodi,timodesc,timosaen,timoprop,clbodesc 
                 FROM tipomovi,clasbode 
                 WHERE TIMOSAEN = '$tipMov' AND timvclbo is not null and timvclbo<>-1 and clbocodi=timvclbo 
                 ORDER BY timocodi";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
            	$table .= '
            		<tr onclick="addTipoMovimiento('.$row['timocodi'].',\''.$row['timodesc'].'\')">
            			<td class="text-center">'.$row['timocodi'].'</td>
            			<td>'.$row['timodesc'].'</td>
            			<td>'.$row['timoprop'].'</td>
            			<td>'.$row['clbodesc'].'</td>
            		</tr>';
            }   
        }
	    echo $table;
	}

	if($_REQUEST["accion"]=="guardar_movimiento_inventario"){
        $codMov = $_REQUEST["codMov"];
        $fecha  = $_REQUEST["fecha"];
        $bodOrg = $_REQUEST["codEn"];
        $valor  = str_replace('.','',$_REQUEST["valor"]);
        $tipMov = $_REQUEST["codTip"];
        if($_REQUEST["codBod"]!=0){ $bodDes = $_REQUEST["codBod"];
        }else{ $bodDes = 0; }
        if($_REQUEST["sop"]!=0){ $sop = $_REQUEST["sop"];
        }else{ $sop = 0; }
        if($_REQUEST["docSop"]!=0){ $docSop = $_REQUEST["docSop"];
        }else{ $docSop = 0; }
        $obs = $_REQUEST["obs"];
        $user = $_SESSION['user'];

        $query ="INSERT INTO moviinve (MOINCODI, MOINFECH, MOINBOOR, MOINBODE, MOINVLOR, MOINTIMO, MOINOBSE, MOINSOPO, MOINDOSO, MOINUSUA)  
                 VALUES ($codMov,'$fecha',$bodOrg,$bodDes,$valor,$tipMov,'$obs',$sop,$docSop,'$user')";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }

    if($_REQUEST["accion"]=="calcular_material"){
        $codMat     = $_REQUEST["codMat"]; //codigo de material
        $cantMat    = $_REQUEST["cantMat"]; //cantidad de material
        $codBod     = $_REQUEST["bod"]; //bodega origen
        $codBodDes  = $_REQUEST["des"]; //bodega destino
        $tMo        = $_REQUEST["tMo"]; //tipo de movimiento E/S

        //Verificamos el tipo de movimiento | propio / prestado
            $tipo_movi = obtener_tipo_movimiento($tMo);
            //es propio
            if($tipo_movi=='S'){ //propio
                $canti = 'INVECAPRO';
                $valor = 'INVEVLRPRO';
            }else{//prestado
                $canti = 'INVECAPRE';
                $valor = 'INVEVLRPRE';
            }
        //
        //tipo de obtener_tipo_movimiento | entrada / salida
            $tipo_movi_e_s = obtener_tipo_movimiento_ent_sal($tMo);
            if($tipo_movi_e_s=='E'){ //entrada
                $vodeVal = $codBodDes;
            }else{//salida
                $vodeVal = $codBod;
            }
        //

        $canMatSelec = 0;
        $valMatSelec = 0;
        $cupoAsigna = 0;
        $query ="SELECT $canti, $valor, INVECUPO FROM inventario WHERE INVEMATE = $codMat AND INVEBODE = $vodeVal";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $canMatSelec = (int)$row[$canti];
                $valMatSelec = (int)$row[$valor];
                $cupoAsigna = (int)$row['INVECUPO'];
            }
        }

        //validamos cantidad de material en inventario
        if($canMatSelec>=$cantMat){
            $sw = 1;
            $total = $cantMat * $valMatSelec;
        }else{
            $sw = 2;
            $total = 0;
        }

        if($total > $cupoAsigna){
            $sw = 3;
            $total = 0;
        }

        $arr = array($sw,$total,$cupoAsigna);
        echo json_encode($arr);
    }

    if($_REQUEST["accion"]=="guardar_materiales_movimiento_inventario"){
        $codMov = $_REQUEST["codMov"];
        $cod    = $_REQUEST["cod"];
        $can    = (int)$_REQUEST["can"];
        $val    = $_REQUEST["val"];
        $tipo   = $_REQUEST["tipo"];
        $bodO   = $_REQUEST["bodO"];
        $bodD   = $_REQUEST["bodD"];
        $codTip = $_REQUEST["codTip"];

        //Verificamos el tipo de movimiento
            $tipo_movi = obtener_tipo_movimiento($codTip);
            if($tipo_movi=='S'){
                $canti = 'INVECAPRO';
                $valor = 'INVEVLRPRO';
            }else{
                $canti = 'INVECAPRE';
                $valor = 'INVEVLRPRE';
            }
        //
        $query ="INSERT INTO matemoin (MAMIMOIN, MAMIMATE, MAMICANT, MAMIVLOR)  
                 VALUES ($codMov,$cod,$can,$val)";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            //CUANDO ES SALIDA DE ALMACEN
            if($tipo=='S'){
                //OBTENEMOS LA CANTIDAD DE MATERIAL EN EL ALMACEN
                    $caMat = 0;
                    $query ="SELECT $canti FROM inventario WHERE INVEMATE = $cod AND INVEBODE = $bodO";
                    $respuesta = $conn->prepare($query) or die ($sql);
                    if(!$respuesta->execute()) return false;
                    if($respuesta->rowCount()>0){
                        while ($row=$respuesta->fetch()){
                            $caMat = (int)$row[$canti];
                        }
                    }
                //
                
                //ACTUALIZAMOS LA CANTIDAD DEL ALMACEN
                    $newCant = $caMat - $can;
                    $query ="UPDATE inventario SET $canti = $newCant 
                             WHERE INVEMATE = $cod AND INVEBODE = $bodO";
                    $respuesta = $conn->prepare($query) or die ($query);
                    if(!$respuesta->execute()){
                        echo 'Error Actualizar Inventario';
                    }else{
                        //echo 1;
                    }
                //

                //VERIFICAMOS QUE LA BODEGA DESTINO TENGA EL MATERIAL
                    $caMatDest = 0;
                    $query ="SELECT $canti FROM inventario WHERE INVEMATE = $cod AND INVEBODE = $bodD";
                    $respuesta = $conn->prepare($query) or die ($sql);
                    if(!$respuesta->execute()) return false;
                    if($respuesta->rowCount()>0){
                        while ($row=$respuesta->fetch()){
                            $caMatDest = (int)$row[$canti];
                        }
                    }

                    //SINO EXISTE LO AGREGAMOS
                    if($caMatDest==0){
                        $query ="INSERT INTO inventario (INVEMATE, INVEBODE, $canti, $valor)  
                                 VALUES ($cod,$bodD,$can,$val)";
                        $respuesta = $conn->prepare($query) or die ($query);
                        if(!$respuesta->execute()){
                            echo 'Error!';
                        }else{ /*echo 1;*/ }
                    }else{ //SI EXISTE LO ACTUALIZAMOS
                        $total = (int)$caMatDest + (int)$can;
                        $query ="UPDATE inventario 
                                 SET $canti = $total, $valor = $val  
                                 WHERE INVEMATE = $cod AND INVEBODE = $bodD";
                        $respuesta = $conn->prepare($query) or die ($query);
                        if(!$respuesta->execute()){
                            echo 'Error!';
                        }else{ /*echo 1;*/ }
                    }
                //
            }else{ //CUANDO ES ENTRADA DE ALMACEN

                //OBTENEMOS LA CANTIDAD DE MATERIAL EN BODEGA DESTINO
                    $caMat = 0;
                    $query ="SELECT $canti FROM inventario WHERE INVEMATE = $cod AND INVEBODE = $bodD";
                    $respuesta = $conn->prepare($query) or die ($sql);
                    if(!$respuesta->execute()) return false;
                    if($respuesta->rowCount()>0){
                        while ($row=$respuesta->fetch()){
                            $caMat = (int)$row[$canti];
                        }
                    }
                //

                //ACTUALIZAMOS LA CANTIDAD DEL ALMACEN
                    $newCant = $caMat - $can;
                    $query ="UPDATE inventario SET $canti = $newCant 
                             WHERE INVEMATE = $cod AND INVEBODE = $bodD";
                    $respuesta = $conn->prepare($query) or die ($query);
                    if(!$respuesta->execute()){
                        echo 'Error Actualizar Inventario';
                    }else{
                        //echo 1;
                    }
                //

                //VERIFICAMOS QUE LA BODEGA DESTINO TENGA EL MATERIAL
                    $caMatDest = 0;
                    $query ="SELECT $canti FROM inventario WHERE INVEMATE = $cod AND INVEBODE = $bodO";
                    $respuesta = $conn->prepare($query) or die ($sql);
                    if(!$respuesta->execute()) return false;
                    if($respuesta->rowCount()>0){
                        while ($row=$respuesta->fetch()){
                            $caMatDest = (int)$row[$canti];
                        }
                    }

                    //SINO EXISTE LO AGREGAMOS
                    if($caMatDest==0){
                        $query ="INSERT INTO inventario (INVEMATE, INVEBODE, $canti, $valor)  
                                 VALUES ($cod,$bodO,$can,$val)";
                        $respuesta = $conn->prepare($query) or die ($query);
                        if(!$respuesta->execute()){
                            echo 'Error!';
                        }else{ /*echo 1;*/ }
                    }else{ //SI EXISTE LO ACTUALIZAMOS
                        $total = (int)$caMatDest + (int)$can;
                        $query ="UPDATE inventario 
                                 SET $canti = $total, $valor = $val  
                                 WHERE INVEMATE = $cod AND INVEBODE = $bodO";
                        $respuesta = $conn->prepare($query) or die ($query);
                        if(!$respuesta->execute()){
                            echo 'Error!';
                        }else{ /*echo 1;*/ }
                    }
                //
            }
        }
        
    }

?>