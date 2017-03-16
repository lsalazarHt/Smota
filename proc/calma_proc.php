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

        $arr = array($data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8,$data9,$data10,$data11,$data12,$data13,$data14);
        echo json_encode($arr);
    }
?>