<?php 
	$conn = require '../template/sql/conexion.php';
	
	if($_REQUEST["accion"]=="buscar_tecnico"){
		$dato='';
		$query ="SELECT TECNCODI,TECNNOMB FROM tecnico WHERE TECNCODI = ".$_REQUEST["codTec"]." AND TECNESTA='A'";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                	$dato = $row['TECNNOMB'];                              
                }   
            }
            echo $dato;
	}

	if($_REQUEST["accion"]=="buscar_prq"){

		$query ="SELECT * FROM pqr WHERE PQRCODI = ".$_REQUEST["codPqr"];
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
            	$dato1 = $row['PQRCODI']; 
            	$dato2 = $row['PQRDESC']; 
            	$dato3 = $row['PQRDIBL']; 
            	$dato4 = $row['PQRSAIN']; 
            	$dato5 = $row['PQRPOIN']; 
            	$dato6 = $row['PQRCECO'];
            	$dato7 = $row['PQRMAPR']; 
            	$dato8 = $row['PQRLEAR'];
            	$dato9 = $row['PQRESTA']; 
            	$dato10 = $row['PQRTECN']; 
            	$dato11 = $row['PQRBLOQ']; 
            	$dato12 = $row['PQRMATEEX']; 
            	$dato13 = $row['PQRNOCALE']; 
            	$dato14 = $row['PQRPRIO']; 
            	$dato15 = $row['PQRLEMA']; 
            	$dato16 = $row['PQRVALORTPTE']; 
            	$dato17 = $row['PQRVALORTPTEFUERA']; 
            }   
        }
        $arr = array($dato1,$dato2,$dato3,$dato4,$dato5,$dato6,$dato7,$dato8,$dato9,$dato10
        				,$dato11,$dato12,$dato13,$dato14,$dato15,$dato16,$dato17);
        echo json_encode($arr);
        //echo $query;
	}

	if($_REQUEST["accion"]=="guardar_registros"){
		if($_REQUEST["cTec"]==''){
			$_REQUEST["cTec"] = 0;
		}
       	$query ="INSERT INTO pqr (PQRCODI,PQRDESC,PQRDIBL,PQRSAIN,PQRPOIN,PQRCECO,PQRMAPR,
        		PQRLEAR,PQRESTA,PQRTECN,PQRBLOQ,PQRMATEEX,PQRNOCALE,PQRPRIO,PQRLEMA,PQRVALORTPTE,
        		PQRVALORTPTEFUERA)
				VALUES (".$_REQUEST["cod"].",'".$_REQUEST["nom"]."',".$_REQUEST["dia"].",
					'".$_REQUEST["sCert"]."',".$_REQUEST["pInsp"].",".$_REQUEST["cCost"].",
					'".$_REQUEST["lMatPro"]."','".$_REQUEST["lArch"]."','".$_REQUEST["act"]."',
					".$_REQUEST["cTec"].",'".$_REQUEST["aDesb"]."','".$_REQUEST["iUtil"]."',
					'N',".$_REQUEST["prio"].",'".$_REQUEST["lMater"]."',
					".$_REQUEST["vTdentro"].",".$_REQUEST["vTfuera"]."
					)";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
	}

	if($_REQUEST["accion"]=="editar_registros"){
        if($_REQUEST["cTec"]==''){
			$_REQUEST["cTec"] = 0;
		}
        $query ="UPDATE pqr 
        		 SET PQRCODI=".$_REQUEST["cod"].", PQRDESC='".$_REQUEST["nom"]."',
        		 	 PQRDIBL=".$_REQUEST["dia"].", PQRSAIN='".$_REQUEST["sCert"]."',
        		 	 PQRPOIN=".$_REQUEST["pInsp"].", PQRCECO=".$_REQUEST["cCost"].",
        		 	 PQRMAPR='".$_REQUEST["lMatPro"]."', PQRLEAR='".$_REQUEST["lArch"]."',
        		 	 PQRESTA='".$_REQUEST["act"]."', PQRTECN=".$_REQUEST["cTec"].",
        		 	 PQRBLOQ='".$_REQUEST["aDesb"]."', PQRMATEEX='".$_REQUEST["iUtil"]."',
        		 	 PQRNOCALE='N', PQRPRIO=".$_REQUEST["prio"].", PQRLEMA='".$_REQUEST["lMater"]."',
        		 	 PQRVALORTPTE=".$_REQUEST["vTdentro"].", PQRVALORTPTEFUERA=".$_REQUEST["vTfuera"]."
        		 WHERE PQRCODI=".$_REQUEST["codOrg"];
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }

    if($_REQUEST["accion"]=="consultar_prq"){
    	$dato='';
    	$i=0;
		$query ="SELECT * FROM pqr";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
            	$i++;
                $dato .='<input type="hidden" id="txtCodPqr'.$i.'" value="'.$row['PQRCODI'].'"><br>';
            }   
        }
       	echo $dato.'<br>
            <input type="hidden" id="txtActualPqr" value="1"><br>
        <input type="hidden" id="txtToltalPqr" value="'.$i.'">';
        //echo $query;
	}
?>