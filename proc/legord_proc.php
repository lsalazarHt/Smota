<?php
    $conn = require '../template/sql/conexion.php';

    function obtener_bod_pqr($cod){
        $campo = '';
        $sw = 'N';
        $conn = require '../template/sql/conexion.php';
        $query ="SELECT PQRMAPR FROM pqr WHERE PQRCODI = $cod";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $campo = $row['PQRMAPR'];
            }
        }
        return $campo; 

    }
    function obtener_valor_mate($mat,$tec,$campoTabl){
        $campo = '';
        $conn = require '../template/sql/conexion.php';
        $query ="SELECT $campoTabl FROM inventario WHERE INVEBODE = $tec AND invemate = $mat";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $campo = $row[$campoTabl];
            }
        }
        return $campo; 

    }

    //validar departamento y localidad
    if($_REQUEST["accion"]=="validar_cod_departamento"){
        $cod = $_REQUEST["cod"];
        $query ="SELECT depacodi FROM departam WHERE depacodi = $cod AND depavisi = 1";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            echo 1;   
        }else{
            echo 0;
        }
    }
    if($_REQUEST["accion"]=="validar_cod_localidad"){
        $dep = $_REQUEST["dep"];
        $cod = $_REQUEST["cod"];
        $query ="SELECT locacodi FROM localidad WHERE locadepa = $dep AND locacodi = $cod AND locavisi = 1";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            echo 1;   
        }else{
            echo 0;
        }
    }
    //obtener datos de una orden
    if($_REQUEST["accion"]=="obtener_orden"){
        $dep = $_REQUEST["dep"];
        $loc = $_REQUEST["loc"];
        $num = $_REQUEST["num"];
        //
        $codTecOt = '';
        $estOt = '';
        $fechRecib = '';
        $fechOrdn = '';
        $fechCump = '';
        $fechAsig = '';
        $fechLega = '';

        $pqrReport = '';
        $pqrEncont = '';
        $codUser = '';
        $codEstado = '';

        $horIni = '';
        $minIni = '';
        $horFin = '';
        $minFin = '';
        $horaInicial = '';
        $horaFinal = '';

        $obs = '';
        $asig = '';
        $recb = '';
        $lega = '';

        $query ="SELECT * FROM ot WHERE OTDEPA = $dep AND OTLOCA = $loc AND OTNUME = $num AND OTESTA = 1";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    $codTecOt = $row['OTTECN'];
                    $estOt = $row['OTESTA'];
                    $fechRecib = $row['OTFERECI'];
                    $fechOrdn = $row['OTFEORD'];
                    $fechCump = $row['OTCUMP'];
                    $fechAsig = $row['OTFEAS'];
                    if($row['OTFELE']!=''){
                        $fechLega = $row['OTFELE'];
                    }else{
                        $fechLega = date('Y-m-d');
                    }
                    $pqrReport = $row['OTPQRREPO'];
                    $pqrEncont = $row['OTPQRENCO'];
                    $codUser = $row['OTUSUARIO'];
                    $codEstado = $row['OTESTA'];

                    $horIni = $row['OTHORAIN'];
                    $minIni = $row['OTMIIN'];
                    $horFin = $row['OTHORAFI'];
                    $minFin = $row['OTMIFI'];

                    $obs = $row['OTOBSELE'];

                    $asig = $row['OTUSERASI'];
                    $recb = $row['OTUSERCRE'];
                    $lega = $row['OTUSERLEG'];
                }
            }

        $numPqrRepor='';
        if($pqrReport!=''){
            $query ="SELECT * FROM pqr WHERE PQRCODI = $pqrReport";
                $respuesta = $conn->prepare($query) or die ($sql);
                if(!$respuesta->execute()) return false;
                if($respuesta->rowCount()>0){
                    while ($row=$respuesta->fetch()){
                        $numPqrRepor = $row['PQRDESC'];                              
                    }   
                }
        }

        $numTecn='';
        if($codTecOt!=''){
            $queryTec ="SELECT * FROM tecnico WHERE TECNCODI = $codTecOt";
                $respuestaTec = $conn->prepare($queryTec) or die ($sql);
                if(!$respuestaTec->execute()) return false;
                if($respuestaTec->rowCount()>0){
                    while ($rowTec=$respuestaTec->fetch()){
                        $numTecn = utf8_encode($rowTec['TECNNOMB']);
                    }   
                }
        }

        $numPqrEncont='';
        if($pqrEncont!=''){
            $query ="SELECT * FROM pqr WHERE PQRCODI = $pqrEncont";
                $respuesta = $conn->prepare($query) or die ($sql);
                if(!$respuesta->execute()) return false;
                if($respuesta->rowCount()>0){
                    while ($row=$respuesta->fetch()){
                        $numPqrEncont = $row['PQRDESC'];                              
                    }   
                }
        }

        $nomUser='';
        if($codUser!=''){
            $query ="SELECT * FROM usuarios WHERE USUCODI = $codUser";
                $respuesta = $conn->prepare($query) or die ($sql);
                if(!$respuesta->execute()) return false;
                if($respuesta->rowCount()>0){
                    while ($row=$respuesta->fetch()){
                        $nomUser = $row['USUNOMB'];                              
                    }   
                }
        }
        
        $numEstado='';
        if($codEstado!=''){
            $query ="SELECT * FROM estaot WHERE ESOTCODI = $codEstado";
                $respuesta = $conn->prepare($query) or die ($sql);
                if(!$respuesta->execute()) return false;
                if($respuesta->rowCount()>0){
                    while ($row=$respuesta->fetch()){
                        $numEstado = $row['ESOTDESC'];                              
                    }   
                }
        }

        if($horIni!=''){
            $horaInicial = str_pad($horIni,2,"0",STR_PAD_LEFT).':'.str_pad($minIni,2,"0",STR_PAD_LEFT);
        }else{  $horaInicial=''; }
        if($horFin!=''){
            $horaFinal = str_pad($horFin,2,"0",STR_PAD_LEFT).':'.str_pad($minFin,2,"0",STR_PAD_LEFT);
        }else{  $horaFinal=''; }

        $arr = array($codTecOt,$numTecn,$estOt,$fechRecib,$fechOrdn,$fechCump,$fechAsig,$fechLega,
                     $pqrReport,$numPqrRepor,$pqrEncont,$numPqrEncont,$codUser,$nomUser,$codEstado,
                     $numEstado,$horaInicial,$horaFinal,$obs,$asig,$recb,$lega);
        echo json_encode($arr);
    }

    if($_REQUEST["accion"]=="obtener_mano_obra"){
        $dep = $_REQUEST["dep"];
        $loc = $_REQUEST["loc"];
        $num = $_REQUEST["num"];
        $table = '<tr style="background-color: #3c8dbc; color:white;">
                    <td class="text-right" width="100"></td>
                    <td >Mano de Obra</td>
                    <td class="text-right" width="100">Cantidad</td>
                    <td class="text-right" width="200">Valor</td>
                 </tr>';
        $i=0;
        $query ="SELECT MANOBRA.MOBRCODI, MANOBRA.MOBRDESC, mobrottr.MOOTCANT, mobrottr.MOOTVAPA
                 FROM mobrottr
                    INNER JOIN MANOBRA ON MANOBRA.MOBRCODI = mobrottr.MOOTMOBR
                 WHERE mobrottr.MOOTDEPA = $dep AND mobrottr.MOOTLOCA = $loc AND mobrottr.MOOTNUMO = $num";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $table .= '<tr>
                                <td><input type="text" class="form-control input-sm text-center" value="'.$row['MOBRCODI'].'" readonly></td>
                                <td><input type="text" class="form-control input-sm" value="'.$row['MOBRDESC'].'" readonly></td>
                                <td><input type="text" class="form-control input-sm text-right" value="'.$row['MOOTCANT'].'" readonly></td>
                                <td><input type="text" class="form-control input-sm text-right" value="'.number_format($row['MOOTVAPA'],0,',','.').'" readonly></td>
                            </tr>';
            }   
        }
        echo $table;
    }
    if($_REQUEST["accion"]=="obtener_materiales"){
        $dep = $_REQUEST["dep"];
        $loc = $_REQUEST["loc"];
        $num = $_REQUEST["num"];
        $table = '<tr style="background-color: #3c8dbc; color:white;">
                    <td class="text-right" width="100"></td>
                    <td >Material</td>
                    <td class="text-right" width="100">Cantidad</td>
                    <td class="text-right" width="200">Valor</td>
                 </tr>';
        $i=0;
        $query ="SELECT MATERIAL.MATECODI, MATERIAL.MATEDESC, maleottr.MAOTCANT, maleottr.MAOTVLOR
                    FROM maleottr
                        INNER JOIN MATERIAL ON MATERIAL.MATECODI = maleottr.MAOTMATE
                    WHERE maleottr.MAOTDEPA = $dep AND maleottr.MAOTLOCA = $loc AND maleottr.MAOTNUMO = $num 
                    ";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $table .= '<tr>
                                <td><input type="text" class="form-control input-sm text-center" value="'.$row['MATECODI'].'" readonly></td>
                                <td><input type="text" class="form-control input-sm" value="'.$row['MATEDESC'].'" readonly></td>
                                <td><input type="text" class="form-control input-sm text-right" value="'.$row['MAOTCANT'].'" readonly></td>
                                <td><input type="text" class="form-control input-sm text-right" value="'.number_format($row['MAOTVLOR'],0,',','.').'" readonly></td>
                            </tr>';
            }   
        }
        echo $table;
    }

    if($_REQUEST["accion"]=="guardar_orden"){
        $dep = $_REQUEST["dep"];
        $loc = $_REQUEST["loc"];
        $num = $_REQUEST["num"];
        $obs = $_REQUEST["obs"];
        $leg = $_REQUEST["leg"];
        //
        $fCumpl = $_REQUEST["fCumpl"];
        $pqrEnc = $_REQUEST["pqrEnc"];
        $hi = explode(':',$_REQUEST["horIni"]);
        $hf = explode(':',$_REQUEST["horFin"]);
        //Falta cambiar estado
        $estado = 3;

        $query ="UPDATE ot 
                 SET OTOBSELE = '$obs', OTUSERLEG = '$leg', OTCUMP = '$fCumpl', OTPQRENCO = '$pqrEnc',
                 OTHORAIN = ".$hi[0].",OTMIIN = ".$hi[1].",OTHORAFI = ".$hf[0].",OTMIFI = ".$hf[1].",
                 OTESTA = $estado
                 WHERE OTDEPA = $dep AND OTLOCA = $loc AND OTNUME = $num";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }
    if($_REQUEST["accion"]=="actualizar_orden"){
        $dato='';
        $query ='SELECT ot.* , usuarios.USUNOMB
                 FROM ot
                    INNER JOIN usuarios ON  ot.OTUSUARIO = usuarios.USUCODI
                 WHERE OTESTA = 1                                                           
                 ';
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $dato .=  
                    '<tr onclick="buscarOrden('.$row['OTDEPA'].','.$row['OTLOCA'].','.$row['OTNUME'].')">
                        <td class="text-center" width="100">'.$row['OTDEPA'].'-'.$row['OTLOCA'].'-'.$row['OTNUME'].'</td>
                        <td>'.$row['USUNOMB'].'</td>
                    </tr>';                                   
            }   
        }
        echo $dato;
    }

    //Pqr Encontrada
    if($_REQUEST["accion"]=="buscar_trabajo"){
        $dato='';
        $cod = $_REQUEST["cod"];
        $tec = $_REQUEST["tec"];

        $query ="SELECT * FROM pqrxtecn WHERE PQTETECN = $tec AND PQTEPQR = $cod";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                //pqr datos
                $queryU ="SELECT * FROM pqr WHERE PQRCODI = ".$row['PQTEPQR'];
                $respuestaU = $conn->prepare($queryU) or die ($sql);
                if(!$respuestaU->execute()) return false;
                if($respuestaU->rowCount()>0){
                    while ($rowU=$respuestaU->fetch()){
                        $dato = utf8_encode($rowU['PQRDESC']);
                    }   
                }
                //End pqr
            }   
        }
        echo $dato;
    }
    if($_REQUEST["accion"]=="buscar_pqrxtecnico"){
        $tabla='';
        $cod = $_REQUEST["cod"];
        $query ="SELECT * FROM pqrxtecn WHERE PQTETECN = $cod";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                //pqr datos
                $queryU ="SELECT * FROM pqr WHERE PQRCODI = ".$row['PQTEPQR'];
                $respuestaU = $conn->prepare($queryU) or die ($sql);
                if(!$respuestaU->execute()) return false;
                if($respuestaU->rowCount()>0){
                    while ($rowU=$respuestaU->fetch()){
                        $tabla .='<tr onclick="buscarTrabajo(\''.$rowU['PQRCODI'].'\','.$cod.')">
                                        <td class="text-center">'.$rowU['PQRCODI'].'</td>
                                        <td>'.utf8_encode($rowU['PQRDESC']).'</td>
                                    </tr>';
                    }   
                }
                //End pqr
            }   
        }
        echo $tabla;
    }

    //Mano de Obra x Pqr
    if($_REQUEST["accion"]=="buscar_manoObra"){
        $dato='';
        $query ="SELECT * FROM manobra WHERE MOBRCODI = ".$_REQUEST["cod"];
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    $dato = utf8_encode($row['MOBRDESC']);                              
                }   
            }
            echo $dato;
    }
    if($_REQUEST["accion"]=="buscar_manoObraxpqr"){
        $dato='';
        //$arr='';
        $cod = $_REQUEST["cod"];

        $query ="SELECT * FROM manobpqr WHERE MOPQPQR = $cod";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                //pqr datos
                $queryU ="SELECT * FROM manobra WHERE MOBRCODI = ".$row['MOPQMOBR'];
                $respuestaU = $conn->prepare($queryU) or die ($sql);
                if(!$respuestaU->execute()) return false;
                if($respuestaU->rowCount()>0){
                    while ($rowU=$respuestaU->fetch()){
                        $dato = utf8_decode($rowU['MOBRDESC']);
                    }   
                }
                //$arr = array($dato,$row['MOPQCANT'],$row['MAPQVLOR']);
                //End pqr
            }   
        }
        echo $dato;
        //echo json_encode($arr);;
    }
    if($_REQUEST["accion"]=="buscar_manoObraxCant"){
        $dato='';
        $cant='';
        $valo='';
        $pqr = $_REQUEST["pqr"];
        $cod = $_REQUEST["cod"];

        $query ="SELECT * FROM manobpqr WHERE MOPQPQR = $pqr AND MOPQMOBR = $cod";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $cant = $row['MOPQCANT'];
                $valo = $row['MAPQVLOR'];
                //pqr datos
                $queryU ="SELECT * FROM manobra WHERE MOBRCODI = ".$row['MOPQMOBR'];
                $respuestaU = $conn->prepare($queryU) or die ($sql);
                if(!$respuestaU->execute()) return false;
                if($respuestaU->rowCount()>0){
                    while ($rowU=$respuestaU->fetch()){
                        $dato = utf8_decode($rowU['MOBRDESC']);
                    }   
                }
                //End pqr
            }   
        }
        //echo $dato;
        $arr = array($dato,$cant,$valo);
        echo json_encode($arr);
    }
    if($_REQUEST["accion"]=="actualiza_manoObraxpqr"){
        $dato='';
        $cod = $_REQUEST["cod"];

        $query ="SELECT * FROM manobpqr WHERE MOPQPQR = $cod";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                //pqr datos
                $queryU ="SELECT * FROM manobra WHERE MOBRCODI = ".$row['MOPQMOBR'];
                $respuestaU = $conn->prepare($queryU) or die ($sql);
                if(!$respuestaU->execute()) return false;
                if($respuestaU->rowCount()>0){
                    while ($rowU=$respuestaU->fetch()){
                        $dato .= '<tr onclick="buscarManoObra('.$row['MOPQMOBR'].','.$row['MOPQCANT'].','.$row['MAPQVLOR'].')">
                                    <td>'.$row['MOPQMOBR'].'</td>
                                    <td>'.utf8_encode($rowU['MOBRDESC']).'</td>
                                  </tr>';
                        //$dato .= utf8_encode($rowU['MOBRDESC']);
                    }   
                }
                //End pqr
            }   
        }
        echo $dato;
    }
    if($_REQUEST["accion"]=="guardar_mo_ot"){
        if($_REQUEST["codTec"]==''){ $_REQUEST["codTec"]=0; }
        
        $queryInsert = "INSERT INTO mobrottr (MOOTMOBR,MOOTDEPA,MOOTLOCA,MOOTNUMO,MOOTCANT,MOOTVAPA,MOOTTECN,MOOTTILE,MOOTFECH) 
                        VALUES (".$_REQUEST["cod"].",".$_REQUEST["dep"].",".$_REQUEST["loc"].",
                                ".$_REQUEST["num"].",".$_REQUEST["can"].",".$_REQUEST["val"].",
                                ".$_REQUEST["codTec"].",'D','".date('Y-m-d')."')";

        $respuestaInsert = $conn->prepare($queryInsert) or die ($queryInsert);
        if(!$respuestaInsert->execute()){
            echo $queryInsert;
        }else{
            echo 1;
        }
    }
    //Materiales x Pqr
    if($_REQUEST["accion"]=="buscar_materiales"){
        $dato='';
        $query ="SELECT * FROM material WHERE MATECODI = ".$_REQUEST["cod"];
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    $dato = $row['MATEDESC'];                              
                }   
            }
            echo $dato;
    }
    if($_REQUEST["accion"]=="actualiza_materialesxpqr"){
        $dato='';
        $bod='';
        $cod = $_REQUEST["cod"];
        $tec = $_REQUEST["tec"];

        $query ="SELECT * FROM matepqr WHERE MAPQPQR = $cod";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $cant = $row['MAPQCANT'];
                $cantFija = $row['MAPQFIJO'];
                $mate = $row['MAPQMATE'];

                //obtener numero de bodega
                    $queryTec ="SELECT * FROM tecnico WHERE TECNCODI = ".$tec;
                    $respuestaTec = $conn->prepare($queryTec) or die ($sql);
                    if(!$respuestaTec->execute()) return false;
                    if($respuestaTec->rowCount()>0){
                        while ($rowTec=$respuestaTec->fetch()){
                            $bod = $rowTec['TECNBODE'];  
                        }
                    }
                //
                //verificar inventario
                    $campoBod = obtener_bod_pqr($cod);
                    if($campoBod){
                        $cantUsar = 'INVECAPRO';
                        $valoUsar = 'INVEVLRPRO';
                    }else{
                        $cantUsar = 'INVECAPRE';
                        $valoUsar = 'INVEVLRPRE';
                    }

                    $queryInv ="SELECT $cantUsar, $valoUsar FROM inventario WHERE INVEBODE = $bod AND INVEMATE = $mate";
                    $respuestaInv = $conn->prepare($queryInv) or die ($sql);
                    if(!$respuestaInv->execute()) return false;
                    if($respuestaInv->rowCount()>0){
                        while ($rowInv=$respuestaInv->fetch()){
                            
                            $cantMat_inv = (int)$rowInv[$cantUsar];
                            $valoMat_inv = (int)$rowInv[$valoUsar];
                            
                            $valor_und = ($valoMat_inv)/($cantMat_inv);
                            
                            //materiales datos
                            $queryU ="SELECT * FROM material WHERE MATECODI = $mate";
                            $respuestaU = $conn->prepare($queryU) or die ($sql);
                            if(!$respuestaU->execute()) return false;
                            if($respuestaU->rowCount()>0){
                                while ($rowU=$respuestaU->fetch()){
                                    $dato .= '<tr onclick="buscarMaterial('.$rowU['MATECODI'].',\''.$cantFija.'\','.$cant.','.$cantMat_inv.','.round($valor_und,2).')">
                                                <td class="text-center">'.$rowU['MATECODI'].'</td>
                                                <td>'.utf8_encode($rowU['MATEDESC']).'</td>
                                                <td class="text-right">'.$cant.'</td>
                                                <td class="text-right">'.$cantMat_inv.'</td>
                                                <td class="text-right">'.round($valor_und,2).'</td>
                                              </tr>';
                                    //$dato .= utf8_encode($rowU['MOBRDESC']);
                                }   
                            }
                            //End materiales
                        }
                    }
            }   
        }
        echo $dato;
    }
    if($_REQUEST["accion"]=="buscar_materialesxcant"){
        $dato='';
        $bod='';
        $cant='';
        $cantFija='';
        $invVal='';
        $invCant='';
        $cod = $_REQUEST["cod"];
        $pqr = $_REQUEST["pqr"];
        $tec = $_REQUEST["tec"];

        $query ="SELECT * FROM matepqr WHERE MAPQPQR = $pqr AND MAPQMATE = $cod";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $cant = $row['MAPQCANT'];
                $cantFija = $row['MAPQFIJO'];
                $mate = $row['MAPQMATE'];

                //obtener numero de bodega
                    $queryTec ="SELECT * FROM tecnico WHERE TECNCODI = ".$tec;
                    $respuestaTec = $conn->prepare($queryTec) or die ($sql);
                    if(!$respuestaTec->execute()) return false;
                    if($respuestaTec->rowCount()>0){
                        while ($rowTec=$respuestaTec->fetch()){
                            $bod = $rowTec['TECNBODE'];  
                        }
                    }
                //


                //verificar inventario
                    $campoBod = obtener_bod_pqr($pqr);
                    if($campoBod){
                        $cantUsar = 'INVECAPRO';
                        $valoUsar = 'INVEVLRPRO';
                    }else{
                        $cantUsar = 'INVECAPRE';
                        $valoUsar = 'INVEVLRPRE';
                    }

                    $queryInv ="SELECT $cantUsar, $valoUsar  FROM inventario WHERE INVEBODE = $bod AND INVEMATE = $mate";
                    $respuestaInv = $conn->prepare($queryInv) or die ($sql);
                    if(!$respuestaInv->execute()) return false;
                    if($respuestaInv->rowCount()>0){
                        while ($rowInv=$respuestaInv->fetch()){
                            
                            $cantMat_inv = (int)$rowInv[$cantUsar];
                            $valoMat_inv = (int)$rowInv[$valoUsar];
                            
                            $valor_und = ($valoMat_inv)/($cantMat_inv);

                            //materiales datos
                                $queryU ="SELECT * FROM material WHERE MATECODI = $mate";
                                $respuestaU = $conn->prepare($queryU) or die ($sql);
                                if(!$respuestaU->execute()) return false;
                                if($respuestaU->rowCount()>0){
                                    while ($rowU=$respuestaU->fetch()){
                                        $dato = utf8_encode($rowU['MATEDESC']);
                                    }   
                            }
                            //End materiales
                        }
                    }
            }   
        }
        $arr = array($dato,$cant,$cantFija,round($valor_und,2),$cantMat_inv);
        echo json_encode($arr);
    }
    if($_REQUEST["accion"]=="guardar_ma_ot"){
        $bod     = '';
        $tec     = $_REQUEST["codTec"];
        $cantInv = $_REQUEST["cantInv"];
        $cant    = $_REQUEST["can"];
        $cod     = $_REQUEST["cod"];
        $val     = $_REQUEST["val"];
        $pqrEnc  = $_REQUEST["pqrEnc"];
        $user    = $_SESSION['user'];

        $campoBod = obtener_bod_pqr($pqrEnc);

        $queryInsert = "INSERT INTO maleottr (MAOTMATE,MAOTDEPA,MAOTLOCA,MAOTNUMO,MAOTCANT,MAOTVLOR,MAOTTECN,MAOTTILE,MAOTFECH,MAOTPROP,MAOTUSER) 
                        VALUES (".$_REQUEST["cod"].",".$_REQUEST["dep"].",".$_REQUEST["loc"].",
                                ".$_REQUEST["num"].",".$_REQUEST["can"].",".$_REQUEST["val"].",
                                ".$_REQUEST["codTec"].",'D','".date('Y-m-d')."','$campoBod','$user')";

        $respuestaInsert = $conn->prepare($queryInsert) or die ($queryInsert);
        if(!$respuestaInsert->execute()){
            echo $queryInsert;
        }else{
            //echo 1;
            //obtener numero de bodega
                $queryTec ="SELECT * FROM tecnico WHERE TECNCODI = ".$tec;
                $respuestaTec = $conn->prepare($queryTec) or die ($sql);
                if(!$respuestaTec->execute()) return false;
                if($respuestaTec->rowCount()>0){
                    while ($rowTec=$respuestaTec->fetch()){
                        $bod = $rowTec['TECNBODE'];  
                    }
                }
            //

            $campoBod = obtener_bod_pqr($pqrEnc);
            if($campoBod=='S'){
                $cantUsar = 'INVECAPRO';
                $valoUsar = 'INVEVLRPRO';
            }else{
                $cantUsar = 'INVECAPRE';
                $valoUsar = 'INVEVLRPRE';
            }

            //obtner inventario
                $query ="SELECT $cantUsar, $valoUsar FROM inventario WHERE INVEBODE = $bod AND invemate = $cod";
                $respuesta = $conn->prepare($query) or die ($sql);
                if(!$respuesta->execute()) return false;
                if($respuesta->rowCount()>0){
                    while ($row=$respuesta->fetch()){
                        $cant_invent = (int)$row[$cantUsar];
                        $val_invent  = $row[$valoUsar];
                    }
                }
            //

            //Actualizar Inventario
                //Nueva cantidad en inventario
                $newCant = $cant_invent - (int)$cant;
                $newVal = $val_invent  - (int)$val;

                $query_inventario = "UPDATE inventario 
                                     SET $cantUsar = $newCant, $valoUsar = $newVal 
                                     WHERE INVEBODE = $bod AND INVEMATE = $cod";

                $respuesta_inventario = $conn->prepare($query_inventario) or die ($query_inventario);
                if(!$respuesta_inventario->execute()){
                    echo $query_inventario;
                }else{
                    echo 1;
                }
            //
        }
    }
    
    //verificar si la pqr tiene materiales fijo
    if($_REQUEST["accion"]=="verificar_pqr_material_obligatorio"){
        $pqr = $_REQUEST["pqr"];

        $query ="SELECT mapqfijo FROM matepqr WHERE mapqpqr = $pqr AND mapqfijo = 'S'";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            echo 'S';
        }else{
            echo 'N';
        }
    }
    //contar el numero de veces que un material es obligario
    if($_REQUEST["accion"]=="cont_pqr_material_obligatorio"){
        $cont = 0;
        $pqr = $_REQUEST["pqr"];
        $query ="SELECT COUNT(mapqfijo) AS cont FROM matepqr WHERE mapqpqr = $pqr AND mapqfijo = 'S'";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $cont = $row['cont'];
            }
        }
        echo $cont;
    }
    //verificar material a legalizar
    if($_REQUEST["accion"]=="verificar_material_obligatorio"){
        $sw='';
        $mat = $_REQUEST["cod"];
        $pqr = $_REQUEST["pqrEnc"];

        $query ="SELECT mapqfijo FROM matepqr WHERE mapqpqr = $pqr AND mapqmate = $mat AND mapqfijo = 'S'";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            echo 'S';
        }else{
            echo 'N';
        }
    }
?>