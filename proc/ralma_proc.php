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
    function obtener_tipo_movimiento_bodega_destino($id){
    	$tipoMov = null;
        $conn = require '../template/sql/conexion.php';
        $query ="SELECT TIMVCLBO FROM tipomovi WHERE timocodi = $id";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $tipoMov = $row['TIMVCLBO'];
            }
        }
        return $tipoMov;
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
    function afecta_inventario_propio($id){
    	$tipoMov = null;
        $conn = require '../template/sql/conexion.php';
        $query ="SELECT TIMOPROP FROM tipomovi WHERE timocodi = $id";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $tipoMov = $row['TIMOPROP'];
            }
        }
        return $tipoMov;
    }
    function afecta_cupo_bodega($id){
        $tipoMov = 'N';
        $conn = require '../template/sql/conexion.php';
        $query ="SELECT TIMVCLBO FROM tipomovi WHERE timocodi = $id AND TIMVCLBO = 1";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            $tipoMov = 'S';
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
        $dato0 = '';
        $dato1 = '';
        $dato2 = '';
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
        $fecha  = date('Y-m-d H:i:s');
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
        $codMatAgr  = $_REQUEST["codMat"]; //codigo de material
        $cantMatAgr = (int)$_REQUEST["cantMat"]; //cantidad de material
        $codBodOri  = $_REQUEST["bod"]; //bodega origen
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
            $tipo_de_bodega = 0;
            $tipo_movi_e_s = obtener_tipo_movimiento_ent_sal($tMo);
            if($tipo_movi_e_s=='E'){ //entrada
                $codeVal_Disponible = $codBodDes;
                $codeVal_Destino = $codBodOri;
                $tipo_de_bodega = obtener_tipo_movimiento_bodega_destino($tMo);
            }else{//salida
                $codeVal_Disponible = $codBodOri;
                $codeVal_Destino = $codBodDes;
            }
        //

        $canMatOrig = 0; //cantidad material origen
        $valMatOrig = 0; //valor material origen

        $cupMatDes = 0; //cupo bodega destino
        $canMatDes = 0; //cantidad materia destino

        $canTotMat = 0; //total cantidad material
        $valTotMat = 0; //total valor material
        $swResult = 0; //sw resultado

        //verificamos si es entrada de una bodega 5(proveedor) o 6 (gasera)
        if(($tipo_movi_e_s=='E') && ($tipo_de_bodega==5 || $tipo_de_bodega==6)){
            $swResult = 4;
        }else{
            //Disponibilidad de origen
                $query ="SELECT $canti, $valor FROM inventario WHERE INVEMATE = $codMatAgr AND INVEBODE = $codeVal_Disponible";
                $respuesta = $conn->prepare($query) or die ($sql);
                if(!$respuesta->execute()) return false;
                if($respuesta->rowCount()>0){
                    while ($row=$respuesta->fetch()){
                        $canMatOrig = (int)$row[$canti];
                        $valMatOrig = (int)$row[$valor];
                    }
                }
            //

            //Disponibilidad de cupo
                $query ="SELECT $canti, INVECUPO FROM inventario WHERE INVEMATE = $codMatAgr AND INVEBODE = $codeVal_Destino";
                $respuesta = $conn->prepare($query) or die ($sql);
                if(!$respuesta->execute()) return false;
                if($respuesta->rowCount()>0){
                    while ($row=$respuesta->fetch()){
                        $cupMatDes = (int)$row['INVECUPO'];
                        $canMatDes = (int)$row[$canti];
                    }
                }
            //

            //Validamos la cantidad agregar no es mayor al cupo
                $canTotMat = $cantMatAgr + $canMatDes;
                if($canTotMat > $cupMatDes){
                    $swResult = 3;
                }else{
                    //validamos cantidad de material en inventario
                        if($canMatOrig >= $cantMatAgr){
                            $swResult = 1;
                            $valorMaterial = ceil($valMatOrig/$canMatOrig);
                            $valTotMat = $cantMatAgr * $valorMaterial;
                        }else{
                            $swResult = 2;
                        }
                    //
                }
            //
        }

        $arr = array($swResult,$valTotMat);
        echo json_encode($arr);
    }

    if($_REQUEST["accion"]=="guardar_materiales_movimiento_inventario"){
        $codMov = $_REQUEST["codMov"]; //id movimiento
        $cod    = $_REQUEST["cod"]; // codigo matrial
        $can    = (int)$_REQUEST["can"]; //cantidad agregar
        $val    = $_REQUEST["val"]; //valor agregar
        $tipo   = $_REQUEST["tipo"]; //E/S
        $bodO   = $_REQUEST["bodO"]; //bodega origen
        $bodD   = $_REQUEST["bodD"]; //bodega destino
        $codTip = $_REQUEST["codTip"]; //codigo tipo movimiento

        //Verificamos el tipo de movimiento
            $tipo_movi = obtener_tipo_movimiento($codTip);
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
            $tipo_movi_e_s = obtener_tipo_movimiento_ent_sal($codTip);
            if($tipo_movi_e_s=='E'){ //entrada
                $codeVal_Disponible = $bodD;
                $codeVal_Destino = $bodO;
            }else{//salida
                $codeVal_Disponible = $bodO;
                $codeVal_Destino = $bodD;
            }
        //
        
        //ADD MOVIMIENTOS A TABLA MOVIMIENTOS DE MATERIALES
        $afecta_inv_prop = afecta_inventario_propio($codTip);
        $afecta_cupo = afecta_cupo_bodega($codTip);
        $query ="INSERT INTO matemoin (MAMIMOIN, MAMIMATE, MAMICANT, MAMIVLOR, MAMIPROP, MAMIAFCU)  
                 VALUES ($codMov,$cod,$can,$val,'$afecta_inv_prop','$afecta_cupo')";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            //MOVIMIENTO DE INVENTARIO
            //OBTENEMOS LA CANTIDAD Y VALOR  DE MATERIAL EN BODEGA ORIGEN
                $canMatOrigen = 0; //cantidad de material en Origen
                $valMatOrigen = 0; //valor de material en Origen
                $query ="SELECT $canti, $valor FROM inventario WHERE INVEMATE = $cod AND INVEBODE = $codeVal_Disponible";
                $respuesta = $conn->prepare($query) or die ($sql);
                if(!$respuesta->execute()) return false;
                if($respuesta->rowCount()>0){
                    while ($row=$respuesta->fetch()){
                        $canMatOrigen = (int)$row[$canti];
                        $valMatOrigen = (int)$row[$valor];
                    }
                }
            //

            //ACTUALIZAMOS LA BODEGA ORIGEN
                $newCant = $canMatOrigen - $can;
                $newValo = $valMatOrigen - $val;
                $query ="UPDATE inventario SET $canti = $newCant, $valor = $newValo
                            WHERE INVEMATE = $cod AND INVEBODE = $codeVal_Disponible";
                $respuesta = $conn->prepare($query) or die ($query);
                if(!$respuesta->execute()){
                    echo 'Error Actualizar Inventario';
                }else{
                    //echo 1;
                }
            //

            //VERIFICAMOS QUE LA BODEGA DESTINO TENGA EL MATERIAL
                $caMatDest = 0;
                $vlMatDest = 0;
                $query ="SELECT $canti, $valor  FROM inventario WHERE INVEMATE = $cod AND INVEBODE = $codeVal_Destino";
                $respuesta = $conn->prepare($query) or die ($sql);
                if(!$respuesta->execute()) return false;
                if($respuesta->rowCount()>0){
                    while ($row=$respuesta->fetch()){
                        $caMatDest = (int)$row[$canti];
                        $vlMatDest = (int)$row[$valor];
                    }
                }

                //SINO EXISTE LO AGREGAMOS
                if($caMatDest==0){
                    $query ="INSERT INTO inventario (INVEMATE, INVEBODE, $canti, $valor)  
                                VALUES ($cod, $codeVal_Destino, $can, $val)";
                    $respuesta = $conn->prepare($query) or die ($query);
                    if(!$respuesta->execute()){
                        echo 'Error!';
                    }else{  }
                }else{ //SI EXISTE LO ACTUALIZAMOS
                    $totalcan = (int)$caMatDest + (int)$can;
                    $totalval = (int)$vlMatDest + (int)$val;
                    $query ="UPDATE inventario 
                                SET $canti = $totalcan , $valor = $totalval
                                WHERE INVEMATE = $cod AND INVEBODE = $codeVal_Destino";
                    $respuesta = $conn->prepare($query) or die ($query);
                    if(!$respuesta->execute()){
                        echo 'Error!';
                    }else{  }
                }
            //
            
            echo 1;
        }
    }

    if($_REQUEST["accion"]=="verificar_documento_soporte"){ 
        $sw = 0;
        $cod = $_REQUEST["cod"];
        $query ="SELECT TIMOMVSO FROM tipomovi WHERE TIMOCODI = $cod AND TIMOMVSO IS NOT NULL";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $sw = $row['TIMOMVSO'];
            }   
        }
        echo $sw;
    }
?>