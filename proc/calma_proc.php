<?php
    session_start();
	date_default_timezone_set('America/Bogota');
	$conn = require '../template/sql/conexion.php';

    if($_REQUEST["accion"]=="obtener_movimiento"){
        
        $txtMovCod = $_REQUEST["txtMovCod"]; //codigo del movimiento
        
        $query ="SELECT moviinve.MOINCODI AS codMov, moviinve.MOINFECH AS fechaMov, tipomovi.TIMOCODI AS codTipo, tipomovi.TIMODESC AS nomTipo,
                    tipomovi.TIMOSAEN AS tipoTipo, orig.BODECODI AS codOrg, orig.BODENOMB AS nomOrg, dest.BODECODI AS codDes, dest.BODENOMB AS nomDes, 
                    moviinve.MOINVLOR AS valor, moviinve.MOINSOPO AS soport, moviinve.MOINDOSO AS docSopo, moviinve.MOINUSUA AS usuReg, moviinve.MOINOBSE AS obs
                FROM moviinve
                    JOIN bodega AS orig ON orig.BODECODI = moviinve.MOINBOOR
                    JOIN bodega AS dest ON dest.BODECODI = moviinve.MOINBODE
                    JOIN tipomovi ON tipomovi.TIMOCODI =  moviinve.MOINTIMO
                WHERE moviinve.MOINCODI = $txtMovCod";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $data1 = $row['codMov'];
                $data2 = $row['fechaMov'];
                $data3 = $row['codTipo'];
                $data4 = $row['nomTipo'];
                $data5 = $row['tipoTipo'];
                $data6 = $row['codOrg'];
                $data7 = utf8_encode($row['nomOrg']);
                $data8 = $row['codDes'];
                $data9 = utf8_encode($row['nomDes']);
                $data10 = $row['valor'];
                $data11 = $row['soport'];
                $data12 = $row['docSopo'];
                $data13 = $row['usuReg'];
                $data14 = $row['obs'];
            }
        }

        if($data11==0){ $data11 = ''; }
        if($data12==0){ $data12 = ''; }

        $arr = array($data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8,$data9,$data10,$data11,$data12,$data13,$data14);
        echo json_encode($arr);
    }

    if($_REQUEST["accion"]=="obtener_materiales_movimiento"){
        $table = '';
        $txtMovCod = $_REQUEST["txtMovCod"]; //codigo del movimiento
        $query ="SELECT material.MATECODI, material.MATEDESC, matemoin.MAMIPROP, matemoin.MAMIAFCU, matemoin.MAMICANT, matemoin.MAMIVLOR
                 FROM matemoin
                    JOIN material ON material.MATECODI = matemoin.MAMIMATE
                 WHERE matemoin.MAMIMOIN = $txtMovCod";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                if($row["MAMIPROP"]=='S'){
                    $MAMIPROP = 'Movio Inventario Propio';
                }else{
                    $MAMIPROP = 'No Movio Inventario Propio';
                }

                if($row["MAMIAFCU"]=='S'){
                    $MAMIAFCU = 'Afecto Cupo';
                }else{
                    $MAMIAFCU = 'No Afecto Cupo';
                }

                $table .= 
                    '<tr>
                        <td><input type="text" class="form-control input-sm text-center" value="'.$row["MATECODI"].'" readonly></td>
                        <td><input type="text" class="form-control input-sm" value="'.$row["MATEDESC"].'" readonly></td>
                        <td><input type="text" class="form-control input-sm text-center" value="'.$MAMIPROP.'" readonly></td>
                        <td><input type="text" class="form-control input-sm text-center" value="'.$MAMIAFCU.'" readonly></td>
                        <td><input type="text" class="form-control input-sm text-right" value="'.$row["MAMICANT"].'" readonly></td>
                        <td><input type="text" class="form-control input-sm text-right" value="'.$row["MAMIVLOR"].'" readonly></td>
                    </tr>';                                   
            }   
        }
        echo $table;
    }
    
    if($_REQUEST["accion"]=="cargar_movimientos"){
        $dato='';
        
        $tm = trim($_REQUEST["tm"]);
        $sw = trim($_REQUEST["sw"]);
        $en = trim($_REQUEST["en"]);
        $de = trim($_REQUEST["de"]);
        $sp = trim($_REQUEST["sp"]);
        $ds = trim($_REQUEST["ds"]);

        $cont = 0;
        
        //generar where
        $sqlTm = ($tm!='') ? "moviinve.MOINTIMO =  $tm ":"";
        $sqlSw = ($sw!='') ? "tipomovi.timosaen = '$sw'":"";
        $sqlEn = ($en!='') ? "moviinve.moinboor =  $en ":"";
        $sqlDe = ($de!='') ? "moviinve.moinbode =  $de ":"";
        $sqlSp = ($sp!='') ? "moviinve.moinsopo =  $sp ":"";
        $sqlDs = ($ds!='') ? "moviinve.moindoso =  $ds ":"";
        if( ($tm!='') || ($sw!='') || ($en!='') || ($de!='') || ($sp!='') || ($ds!='') ){
            $where = 'WHERE ';
            if($sqlTm!=''){ $where .= "$sqlTm AND ";}
            if($sqlSw!=''){ $where .= "$sqlSw AND ";}
            if($sqlEn!=''){ $where .= "$sqlEn AND ";}
            if($sqlDe!=''){ $where .= "$sqlDe AND ";}
            if($sqlSp!=''){ $where .= "$sqlSp AND ";}
            if($sqlDs!=''){ $where .= "$sqlDs AND ";}
            $where = substr($where, 0, -4);
        }else{ $where = ''; }

        $i=0;
        $query ="SELECT moviinve.moincodi 
                 from moviinve
                    join tipomovi on tipomovi.timocodi = moviinve.MOINTIMO
                 $where";
        
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $i++;
                $dato .='<input type="hidden" id="txt_CodMov'.$i.'" value="'.$row['moincodi'].'">';
            }   
        }
        echo $dato.'<br>
            <input type="hidden" id="txt_ActualMov" value="1">
            <input type="hidden" id="txt_ToltalMov" value="'.$i.'">';
    }

    if($_REQUEST["accion"]=="buscar_bodega_destino"){
        $cod = $_REQUEST["cod"];

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

    if($_REQUEST["accion"]=="buscar_tipo_mov_soporte"){
        $cod = $_REQUEST["cod"];

        $query ="SELECT timocodi,timodesc
                 FROM tipomovi 
                 WHERE timocodi =  $cod";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $dato = utf8_encode($row['timodesc']);
            }   
        }
        echo $dato;
    }
?>