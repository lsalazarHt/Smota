<?php 
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="obtener_usuario"){
		$dato='';
		$sw=0;
		$query ="SELECT * FROM tecnico WHERE TECNCODI = ".$_REQUEST["cod"];
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
        	$sw = 1;
            while ($row=$respuesta->fetch()){
            	$dato1 = utf8_encode($row['TECNNOMB']); 
            	
            	$dato2 = $row['TECNCLAS'];
            	//$dato3 = $row['TECNESTA'];                            
            	
            	$dato4 = $row['TECNESTA'];                            
            	$dato5 = $row['TECNFEIN'];                            
            	$dato6 = $row['TECNFERE'];                            
            	$dato7 = '';                            
            	$dato8 = $row['TECNBODE'];                            
            	//$dato9 = $row['USUDEPA'];                            
            	
            	$dato9 = $row['TECNSALA'];                            
            	$dato10 = $row['INDCDORPRDCCION'];
            	
            }

	        //CLASE
	        $query ="SELECT CLTEDESC FROM clastecn WHERE CLTECODI = ".$dato2;
	        $respuesta = $conn->prepare($query) or die ($sql);
	        if(!$respuesta->execute()) return false;
	        if($respuesta->rowCount()>0){
	        	while ($row=$respuesta->fetch()){
	        		$dato3 = $row['CLTEDESC'];  
	        	}
	        }

	        

        }else{
        	$sw = 0;
            $dato1 = '';                            
        	$dato2 = '';                            
        	$dato3 = '';                            
        	$dato4 = '';                            
        	$dato5 = '';                            
        	$dato6 = '';                            
        	$dato7 = '';                            
        	$dato8 = '';                            
        	$dato9 = '';                            
        	$dato10 = '';                            
        	$dato11 = '';
        }
        
        $arr = array($sw,$dato1,$dato2,$dato3,$dato4,$dato5,$dato6,$dato7,$dato8,$dato9,$dato10);
        echo json_encode($arr);
	}
	if($_REQUEST["accion"]=="buscar_clase"){
		$dato='';
		$query ="SELECT CLTEDESC  FROM clastecn WHERE CLTECODI = ".$_REQUEST["cod"];
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                	$dato = $row['CLTEDESC'];                              
                }   
            }
            echo $dato;
	}
	if($_REQUEST["accion"]=="guardar_registros"){
		if($_REQUEST["salar"]==''){
			$_REQUEST["salar"] = 0;
		}
       	$query ="INSERT INTO tecnico (TECNCODI, TECNNOMB,TECNESTA,TECNCLAS,TECNFEIN,TECNFERE,TECNSALA,
       									TECNBODE,INDCDORPRDCCION)
				VALUES (".$_REQUEST["cod"].",'".$_REQUEST["nom"]."','".$_REQUEST["act"]."',
						".$_REQUEST["clas"].",'".$_REQUEST["fIng"]."','".$_REQUEST["fRet"]."',
						".$_REQUEST["salar"].",'".$_REQUEST["bod"]."','".$_REQUEST["devPr"]."'
					)";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
	}
	if($_REQUEST["accion"]=="editar_registros"){
		if($_REQUEST["salar"]==''){
			$_REQUEST["salar"] = 0;
		}
		$query = "UPDATE tecnico SET TECNCODI=".$_REQUEST["cod"].", TECNNOMB='".$_REQUEST["nom"]."',
					TECNESTA='".$_REQUEST["act"]."',TECNCLAS=".$_REQUEST["clas"].",TECNFEIN='".$_REQUEST["fIng"]."',
					TECNFERE='".$_REQUEST["fRet"]."',TECNSALA=".$_REQUEST["salar"].",TECNBODE='".$_REQUEST["bod"]."',
					INDCDORPRDCCION='".$_REQUEST["devPr"]."'
					WHERE TECNCODI = ".$_REQUEST["codOrg"];

        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
	}
	if($_REQUEST["accion"]=="consultar_tenicos"){
    	$dato='';
    	$i=0;
		$query ="SELECT * FROM tecnico";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
            	$i++;
                $dato .='<input type="hidden" id="txtCod'.$i.'" value="'.$row['TECNCODI'].'"><br>';
            }   
        }
       	echo $dato.'<br>
            <input type="hidden" id="txtActual" value="1"><br>
        <input type="hidden" id="txtToltal" value="'.$i.'">';
        //echo $query;
	}
    if($_REQUEST["accion"]=="consultar_ordenes"){
        $cod = $_REQUEST["cod"];
        switch ($_REQUEST["order"]) {
            case 1:
                $order = 'OTNUME';
                break;
            case 2:
                $order = 'OTFEORD';
                break;
            case 3:
                $order = 'OTFEAS';
                break;
            case 4:
                $order = 'OTUSUARIO';
                break;
            case 5:
                $order = 'OTPQRREPO';
                break;
        }
        $table='';
        $i=0;
        $query ="SELECT *  
                 FROM ot 
                 WHERE OTTECN = $cod AND OTESTA = 1
                 ORDER BY $order";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    //USUARIO
                    $usuarioNom = '';
                    $queryUser ='SELECT USUNOMB FROM USUARIOS WHERE USUCODI='.$row['OTUSUARIO'];
                    $respuestaUser = $conn->prepare($queryUser) or die ($sql);
                    if(!$respuestaUser->execute()) return false;
                    if($respuestaUser->rowCount()>0){
                        while ($rowUser=$respuestaUser->fetch()){
                            $usuarioNom = $rowUser['USUNOMB'];
                        }   
                    }
                    //PQR
                    $pqrNom = '';
                    $pqrPlaz = '';
                    if($row['OTPQRREPO']!=''){
                        $queryPqr ='SELECT PQRCODI,PQRDESC,PQRDIBL FROM pqr WHERE PQRCODI='.$row['OTPQRREPO'];
                        $respuestaPqr = $conn->prepare($queryPqr) or die ($sql);
                        if(!$respuestaPqr->execute()) return false;
                        if($respuestaPqr->rowCount()>0){
                            while ($rowPqr=$respuestaPqr->fetch()){
                                $pqrNom = $rowPqr['PQRDESC'];
                                $pqrPlaz = $rowPqr['PQRDIBL'];
                            }   
                        }
                    }

                    $i++;
                    $table .= '
                        <tr id="trSelect'.$i.'" class="trDefault" onClick="trSelect(\'trSelect'.$i.'\','.$row['OTNUME'].')" ondblclick="enviarOrden('.$row['OTNUME'].','.$_REQUEST["cod"].')">
                            <td>'.$row['OTDEPA'].' - '.$row['OTLOCA'].' - '.$row['OTNUME'].'</td>
                            <td>'.$row['OTFEORD'].'</td>
                            <td>'.$row['OTFEAS'].'</td>
                            <td width="70"><strong>'.$row['OTUSUARIO'].'</strong></td>
                            <td width="200">'.$usuarioNom.'</td>
                            <td width="70"><strong>'.$row['OTPQRREPO'].'</strong></td>
                            <td class="text-left">'.$pqrNom.'</td>
                            <td></td>
                            <td>'.$pqrPlaz.'</td>
                        </tr>';
                }   
            }
            echo $table;
    }
    if($_REQUEST["accion"]=="consultar_ordenes_x_certificar"){
        $cod = $_REQUEST["cod"];
        switch ($_REQUEST["order"]) {
            case 1:
                $order = 'OTNUME';
                break;
            case 2:
                $order = 'OTFEORD';
                break;
            case 3:
                $order = 'OTFEAS';
                break;
            case 4:
                $order = 'OTUSUARIO';
                break;
            case 5:
                $order = 'OTPQRREPO';
                break;
        }
        $table='';
        $i=0;
        $query ="SELECT *  
                 FROM ot 
                 WHERE OTTECN = $cod AND OTESTA = 3
                 ORDER BY $order";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    //USUARIO
                    $usuarioNom = '';
                    $queryUser ='SELECT USUNOMB FROM usuarios WHERE USUCODI='.$row['OTUSUARIO'];
                    $respuestaUser = $conn->prepare($queryUser) or die ($sql);
                    if(!$respuestaUser->execute()) return false;
                    if($respuestaUser->rowCount()>0){
                        while ($rowUser=$respuestaUser->fetch()){
                            $usuarioNom = $rowUser['USUNOMB'];
                        }   
                    }
                    //PQR
                    $queryPqr ='SELECT PQRCODI,PQRDESC,PQRDIBL FROM pqr WHERE PQRCODI='.$row['OTPQRREPO'];
                    $respuestaPqr = $conn->prepare($queryPqr) or die ($sql);
                    if(!$respuestaPqr->execute()) return false;
                    if($respuestaPqr->rowCount()>0){
                        while ($rowPqr=$respuestaPqr->fetch()){
                            $pqrNom = $rowPqr['PQRDESC'];
                            $pqrPlaz = $rowPqr['PQRDIBL'];
                        }   
                    }
                    $i++;
                    $table .= '
                        <tr id="trSelect_2'.$i.'" class="trDefault" onClick="trSelect(\'trSelect_2'.$i.'\','.$row['OTNUME'].')" ondblclick="enviarOrden('.$row['OTNUME'].','.$_REQUEST["cod"].')">
                            <td>'.$row['OTDEPA'].' - '.$row['OTLOCA'].' - '.$row['OTNUME'].'</td>
                            <td>'.$row['OTFEORD'].'</td>
                            <td>'.$row['OTCUMP'].'</td>
                            <td width="70"><strong>'.$row['OTUSUARIO'].'</strong></td>
                            <td width="200">'.$usuarioNom.'</td>
                            <td width="70"><strong>'.$row['OTPQRREPO'].'</strong></td>
                            <td class="text-left">'.$pqrNom.'</td>
                            <td></td>
                            <td>'.$pqrPlaz.'</td>
                        </tr>';                            
                }   
            }
            echo $table;
    }
    if($_REQUEST["accion"]=="consultar_ordenes_certificadas"){
        $cod = $_REQUEST["cod"];
        switch ($_REQUEST["order"]) {
            case 1:
                $order = 'OTNUME';
                break;
            case 2:
                $order = 'OTFEORD';
                break;
            case 3:
                $order = 'OTFEAS';
                break;
            case 4:
                $order = 'OTUSUARIO';
                break;
            case 5:
                $order = 'OTPQRREPO';
                break;
        }
        $table='';
        $i=0;
        $query ="SELECT *  
                 FROM ot 
                 WHERE OTTECN = $cod AND OTESTA = 9
                 ORDER BY $order";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    //USUARIO
                    $usuarioNom = '';
                    $queryUser ='SELECT USUNOMB FROM usuarios WHERE USUCODI='.$row['OTUSUARIO'];
                    $respuestaUser = $conn->prepare($queryUser) or die ($sql);
                    if(!$respuestaUser->execute()) return false;
                    if($respuestaUser->rowCount()>0){
                        while ($rowUser=$respuestaUser->fetch()){
                            $usuarioNom = $rowUser['USUNOMB'];
                        }   
                    }
                    //PQR
                    $queryPqr ='SELECT PQRCODI,PQRDESC,PQRDIBL FROM pqr WHERE PQRCODI='.$row['OTPQRREPO'];
                    $respuestaPqr = $conn->prepare($queryPqr) or die ($sql);
                    if(!$respuestaPqr->execute()) return false;
                    if($respuestaPqr->rowCount()>0){
                        while ($rowPqr=$respuestaPqr->fetch()){
                            $pqrNom = $rowPqr['PQRDESC'];
                            $pqrPlaz = $rowPqr['PQRDIBL'];
                        }   
                    }
                    $i++;
                    $table .= '
                        <tr id="trSelect_3'.$i.'" class="trDefault" onClick="trSelect(\'trSelect_3'.$i.'\','.$row['OTNUME'].')" ondblclick="enviarOrden('.$row['OTNUME'].','.$_REQUEST["cod"].')">
                            <td>'.$row['OTDEPA'].' - '.$row['OTLOCA'].' - '.$row['OTNUME'].'</td>
                            <td>'.$row['OTFEORD'].'</td>
                            <td>'.$row['OTCUMP'].'</td>
                            <td width="70"><strong>'.$row['OTUSUARIO'].'</strong></td>
                            <td width="200">'.$usuarioNom.'</td>
                            <td width="70"><strong>'.$row['OTPQRREPO'].'</strong></td>
                            <td class="text-left">'.$pqrNom.'</td>
                            <td></td>
                            <td>'.$pqrPlaz.'</td>
                        </tr>';                            
                }   
            }
            echo $table;
    }
    if($_REQUEST["accion"]=="consultar_ordenes_incumplidas"){
        $cod = $_REQUEST["cod"];
        switch ($_REQUEST["order"]) {
            case 1:
                $order = 'OTNUME';
                break;
            case 2:
                $order = 'OTFEORD';
                break;
            case 4:
                $order = 'OTUSUARIO';
                break;
            case 5:
                $order = 'OTPQRREPO';
                break;
        }
        $table='';
        $i=0;
        $query ="SELECT *  
                 FROM ot 
                 WHERE OTTECN = $cod AND OTESTA = 2
                 ORDER BY $order";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    //USUARIO
                    $usuarioNom = '';
                    $queryUser ='SELECT USUNOMB FROM usuarios WHERE USUCODI='.$row['OTUSUARIO'];
                    $respuestaUser = $conn->prepare($queryUser) or die ($sql);
                    if(!$respuestaUser->execute()) return false;
                    if($respuestaUser->rowCount()>0){
                        while ($rowUser=$respuestaUser->fetch()){
                            $usuarioNom = $rowUser['USUNOMB'];
                        }   
                    }
                    //PQR
                    $queryPqr ='SELECT PQRCODI,PQRDESC,PQRDIBL FROM pqr WHERE PQRCODI='.$row['OTPQRREPO'];
                    $respuestaPqr = $conn->prepare($queryPqr) or die ($sql);
                    if(!$respuestaPqr->execute()) return false;
                    if($respuestaPqr->rowCount()>0){
                        while ($rowPqr=$respuestaPqr->fetch()){
                            $pqrNom = $rowPqr['PQRDESC'];
                            $pqrPlaz = $rowPqr['PQRDIBL'];
                        }   
                    }
                    $i++;
                    $table .= '
                        <tr id="trSelect_4'.$i.'" class="trDefault" onClick="trSelect(\'trSelect_4'.$i.'\','.$row['OTNUME'].')" ondblclick="enviarOrden('.$row['OTNUME'].','.$_REQUEST["cod"].')">
                            <td>'.$row['OTDEPA'].' - '.$row['OTLOCA'].' - '.$row['OTNUME'].'</td>
                            <td>'.$row['OTFEORD'].'</td>
                            <td width="70"><strong>'.$row['OTUSUARIO'].'</strong></td>
                            <td width="200">'.$usuarioNom.'</td>
                            <td width="70"><strong>'.$row['OTPQRREPO'].'</strong></td>
                            <td class="text-left">'.$pqrNom.'</td>
                        </tr>';                            
                }   
            }
            echo $table;
    }
    if($_REQUEST["accion"]=="consultar_ordenes_anuladas"){
        $cod = $_REQUEST["cod"];
        switch ($_REQUEST["order"]) {
            case 1:
                $order = 'OTNUME';
                break;
            case 2:
                $order = 'OTFEORD';
                break;
            case 4:
                $order = 'OTUSUARIO';
                break;
            case 5:
                $order = 'OTPQRREPO';
                break;
        }
        $table='';
        $i=0;
        $query ="SELECT *  
                 FROM ot 
                 WHERE OTTECN = $cod AND OTESTA = 4
                 ORDER BY $order";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    //USUARIO
                    $usuarioNom = '';
                    $queryUser ='SELECT USUNOMB FROM usuarios WHERE USUCODI='.$row['OTUSUARIO'];
                    $respuestaUser = $conn->prepare($queryUser) or die ($sql);
                    if(!$respuestaUser->execute()) return false;
                    if($respuestaUser->rowCount()>0){
                        while ($rowUser=$respuestaUser->fetch()){
                            $usuarioNom = $rowUser['USUNOMB'];
                        }   
                    }
                    //PQR
                    $queryPqr ='SELECT PQRCODI,PQRDESC,PQRDIBL FROM pqr WHERE PQRCODI='.$row['OTPQRREPO'];
                    $respuestaPqr = $conn->prepare($queryPqr) or die ($sql);
                    if(!$respuestaPqr->execute()) return false;
                    if($respuestaPqr->rowCount()>0){
                        while ($rowPqr=$respuestaPqr->fetch()){
                            $pqrNom = $rowPqr['PQRDESC'];
                            $pqrPlaz = $rowPqr['PQRDIBL'];
                        }   
                    }
                    $i++;
                    $table .= '
                        <tr id="trSelect_5'.$i.'" class="trDefault" onClick="trSelect(\'trSelect_5'.$i.'\','.$row['OTNUME'].')" ondblclick="enviarOrden('.$row['OTNUME'].','.$_REQUEST["cod"].')">
                            <td>'.$row['OTDEPA'].' - '.$row['OTLOCA'].' - '.$row['OTNUME'].'</td>
                            <td>'.$row['OTFEORD'].'</td>
                            <td width="70"><strong>'.$row['OTUSUARIO'].'</strong></td>
                            <td width="200">'.$usuarioNom.'</td>
                            <td width="70"><strong>'.$row['OTPQRREPO'].'</strong></td>
                            <td class="text-left">'.$pqrNom.'</td>
                        </tr>';                            
                }   
            }
            echo $table;
    }
    if($_REQUEST["accion"]=="consultar_materiales_legalizados"){
        $cod = $_REQUEST["cod"];
        switch ($_REQUEST["order"]) {
            case 1:
                $order = 'MAOTNUMO';
                break;
            case 2:
                $order = 'MAOTMATE';
                break;
            case 4:
                $order = 'MAOTFECH';
                break;
            case 5: //
                $order = 'OTUSUARIO';
                break;
        }
        $table='';
        $i=0;
        $query ="SELECT maleottr.* ,  ot.OTUSUARIO  
                 FROM maleottr
                    INNER JOIN ot ON ot.OTNUME = maleottr.MAOTNUMO
                 WHERE MAOTTECN = $cod
                 ORDER BY $order";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    //MATERIAL
                    $materialNom = '';
                    $queryMater ='SELECT MATEDESC FROM material WHERE MATECODI='.$row['MAOTMATE'];
                    $respuestaMater = $conn->prepare($queryMater) or die ($sql);
                    if(!$respuestaMater->execute()) return false;
                    if($respuestaMater->rowCount()>0){
                        while ($rowMater=$respuestaMater->fetch()){
                            $materialNom = $rowMater['MATEDESC'];
                        }   
                    }
                    $i++;
                    $table .= '
                        <tr id="trSelect_6'.$i.'" class="trDefault" onClick="trSelect(\'trSelect_6'.$i.'\','.$row['MAOTNUMO'].')" ondblclick="enviarOrden('.$row['MAOTNUMO'].','.$_REQUEST["cod"].')">
                            <td>'.$row['MAOTDEPA'].' - '.$row['MAOTLOCA'].' - '.$row['MAOTNUMO'].'</td>
                            <td>'.$row['MAOTMATE'].'</td>
                            <td>'.$row['MAOTCANT'].'</td>
                            <td class="text-right">'.number_format($row['MAOTVLOR'],0,'.',',').'</td>
                            <td>'.$row['MAOTFECH'].'</td>
                            <td>'.$row['MAOTTILE'].'</td>
                            <td>'.$row['MAOTPROP'].'</td>
                            <td class="text-left">'.$materialNom.'</td>
                            <td>'.$row['OTUSUARIO'].'</td>
                        </tr>';                            
                } 
            }
            echo $table;
    }
    if($_REQUEST["accion"]=="consultar_mano_obra_legalizadas"){
        $cod = $_REQUEST["cod"];
        switch ($_REQUEST["order"]) {
            case 1:
                $order = 'MOOTNUMO';
                break;
            case 2:
                $order = 'MOOTMOBR';
                break;
            case 3:
                $order = 'MOOTFECH';
                break;
            case 4:
                $order = 'OTUSUARIO';
                break;
            case 5:
                $order = 'MOOTACTA';
                break;
        }
        $table='';
        $i=0;
        $query ="SELECT mobrottr.* ,  ot.OTUSUARIO  
                 FROM mobrottr 
                  INNER JOIN ot ON ot.OTNUME = mobrottr.MOOTNUMO
                 WHERE MOOTTECN = $cod
                 ORDER BY $order";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    //MANO DE OBRA
                    $manObraNom = '';
                    $queryManoObr ='SELECT MOBRDESC FROM manobra WHERE MOBRCODI='.$row['MOOTMOBR'];
                    $respuestaManoObr = $conn->prepare($queryManoObr) or die ($sql);
                    if(!$respuestaManoObr->execute()) return false;
                    if($respuestaManoObr->rowCount()>0){
                        while ($rowManoObr=$respuestaManoObr->fetch()){
                            $manObraNom = $rowManoObr['MOBRDESC'];
                        }   
                    }
                    $i++;
                    $table .= '
                        <tr id="trSelect_7'.$i.'" class="trDefault" onClick="trSelect(\'trSelect_7'.$i.'\','.$row['MOOTNUMO'].')" ondblclick="enviarOrden('.$row['MOOTNUMO'].','.$_REQUEST["cod"].')">
                            <td>'.$row['MOOTDEPA'].' - '.$row['MOOTLOCA'].' - '.$row['MOOTNUMO'].'</td>
                            <td><b>'.$row['MOOTMOBR'].'</b></td>
                            <td class="text-left">'.$manObraNom.'</td>
                            <td>'.$row['OTUSUARIO'].'</td>
                            <td>'.$row['MOOTCANT'].'</td>
                            <td class="text-right">'.number_format($row['MOOTVAPA'],0,'.',',').'</td>
                            <td>'.$row['MOOTACTA'].'</td>
                            <td>'.$row['MOOTFECH'].'</td>
                            <td>'.$row['MOOTTILE'].'</td>
                        </tr>'; 
                } 
            }
            echo $table;
    }
    if($_REQUEST["accion"]=="consultar_acta"){
        $cod = $_REQUEST["cod"];
        $table='';
        $query ="SELECT *  
                 FROM acta
                 WHERE ACTATECN = $cod";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){

                    $table .= '
                        <tr>
                            <td>'.$row['ACTANUME'].'</td>
                            <td>'.$row['ACTAFECH'].'</td>
                            <td class="text-right">'.number_format($row['ACTAVABR'],0,'.',',').'</td>
                            <td class="text-right">'.number_format($row['ACTAVANE'],0,'.',',').'</td>
                            <td>'.$row['ACTAESTA'].'</td>
                        </tr>'; 
                } 
            }
            echo $table;
    }
    if($_REQUEST["accion"]=="consultar_mano_obra_acta"){
        $cod = $_REQUEST["cod"];
        $table='';
        $query ="SELECT mobrottr.*
                 FROM mobrottr 
                 WHERE MOOTTECN = $cod";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    //MANO DE OBRA
                    $manObraNom = '';
                    $queryManoObr ='SELECT MOBRDESC FROM manobra WHERE MOBRCODI='.$row['MOOTMOBR'];
                    $respuestaManoObr = $conn->prepare($queryManoObr) or die ($sql);
                    if(!$respuestaManoObr->execute()) return false;
                    if($respuestaManoObr->rowCount()>0){
                        while ($rowManoObr=$respuestaManoObr->fetch()){
                            $manObraNom = $rowManoObr['MOBRDESC'];
                        }   
                    }

                    $table .= '
                        <tr>
                            <td><b>'.$row['MOOTMOBR'].'</b></td>
                            <td class="text-left">'.$manObraNom.'</td>
                            <td>'.$row['MOOTCANT'].'</td>
                            <td class="text-right">'.number_format($row['MOOTVAPA'],0,'.',',').'</td>
                            <td>'.$row['MOOTFECH'].'</td>
                        </tr>'; 
                } 
            }
            echo $table;
    }
    if($_REQUEST["accion"]=="consultar_notas_acta"){
        $cod = $_REQUEST["cod"];
        $table='';
        $query ="SELECT *
                 FROM nota
                 WHERE NOTATECN = $cod";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    //MANO DE OBRA
                    $claseNom = '';
                    $queryClase ='SELECT CLNODESC FROM clasnota WHERE CLNOCODI='.$row['NOTACLAS'];
                    $respuestaClase = $conn->prepare($queryClase) or die ($sql);
                    if(!$respuestaClase->execute()) return false;
                    if($respuestaClase->rowCount()>0){
                        while ($rowClase=$respuestaClase->fetch()){
                            $claseNom = $rowClase['CLNODESC'];
                        }   
                    }

                    $table .= '
                        <tr>
                            <td>'.$row['NOTACODI'].'</td>
                            <td><b>'.$row['NOTACLAS'].'</b></td>
                            <td class="text-left">'.$claseNom.'</td>
                            <td>'.$row['NOTASIGN'].'</td>
                            <td>'.$row['NOTAFECH'].'</td>
                            <td class="text-right">'.number_format($row['NOTAVALO'],0,'.',',').'</td>
                        </tr>'; 
                } 
            }
            echo $table;
    }
    if($_REQUEST["accion"]=="consultar_inventario"){
        $cod = $_REQUEST["cod"];
        $table='';
        $query ="SELECT *
                 FROM inventario 
                 WHERE INVEBODE = $cod";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    //MATERIAL
                    $materialNom = '';
                    $queryMater ='SELECT MATEDESC FROM material WHERE MATECODI='.$row['INVEMATE'];
                    $respuestaMater = $conn->prepare($queryMater) or die ($sql);
                    if(!$respuestaMater->execute()) return false;
                    if($respuestaMater->rowCount()>0){
                        while ($rowMater=$respuestaMater->fetch()){
                            $materialNom = $rowMater['MATEDESC'];
                        }   
                    }

                    $table .= '
                        <tr>
                            <td>'.$row['INVEMATE'].'</td>
                            <td class="text-left">'.$materialNom.'</td>
                            <td>'.$row['INVEMATE'].'</td>
                            <td>'.$row['INVECUPO'].'</td>
                            <td class="text-right">'.number_format($row['INVECAPRO'],0,'.',',').'</td>
                            <td class="text-right">'.number_format($row['INVECAPRE'],0,'.',',').'</td>
                            <td class="text-right">'.number_format($row['INVEVLRPRO'],0,'.',',').'</td>
                            <td class="text-right">'.number_format($row['INVEVLRPRE'],0,'.',',').'</td>
                        </tr>'; 
                } 
            }
            echo $table;
    }
    if($_REQUEST["accion"]=="consultar_notas"){
        $cod = $_REQUEST["cod"];
        $table='';
        $query ="SELECT *
                 FROM nota
                 WHERE NOTATECN = $cod";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    //MANO DE OBRA
                    $claseNom = '';
                    $queryClase ='SELECT CLNODESC FROM CLASNOTA WHERE CLNOCODI='.$row['NOTACLAS'];
                    $respuestaClase = $conn->prepare($queryClase) or die ($sql);
                    if(!$respuestaClase->execute()) return false;
                    if($respuestaClase->rowCount()>0){
                        while ($rowClase=$respuestaClase->fetch()){
                            $claseNom = $rowClase['CLNODESC'];
                        }   
                    }

                    $table .= '
                        <tr>
                            <td>'.$row['NOTACODI'].'</td>
                            <td><b>'.$row['NOTACLAS'].'</b></td>
                            <td class="text-left">'.$claseNom.'</td>
                            <td>'.$row['NOTAFECH'].'</td>
                            <td>'.$row['NOTAFEAP'].'</td>
                            <td class="text-right">'.number_format($row['NOTAVALO'],0,'.',',').'</td>
                            <td>'.$row['NOTAACTA'].'</td>
                            <td>'.$row['NOTAESTA'].'</td>
                            <td>'.$row['NOTASIGN'].'</td>
                        </tr>'; 
                } 
            }
            echo $table;
    }

    if($_REQUEST["accion"]=="consultar_eleprop"){
        $cod = $_REQUEST["cod"];
        $table='';
        $query ="SELECT E.CODMATERIAL,
                M.MATEDESC,
                E.CANTIDAD,
                E.FECHAENTREGA,
                E.FECHAMINREPOS,
                E.FECHAREPOS
                FROM eleprop E INNER JOIN material M ON M.MATECODI = E.CODMATERIAL
                WHERE TIPOELEPROP = 'E' AND CODTECNICO = $cod";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    $table .= '
                        <tr>
                            <td>'.$row['CODMATERIAL'].'</td>
                            <td colspan="2"><b>'.$row['MATEDESC'].'</b></td>
                            <td>'.$row['CANTIDAD'].'</td>
                            <td>'.$row['FECHAENTREGA'].'</td>
                            <td>'.$row['FECHAMINREPOS'].'</td>
                            <td>'.$row['FECHAREPOS'].'</td>
                        </tr>'; 
                } 
            }
            echo $table;
    }

    if($_REQUEST["accion"]=="consultar_herramientas"){
        $cod = $_REQUEST["cod"];
        $table='';
        $query ="SELECT E.CODMATERIAL,
                M.MATEDESC,
                E.CANTIDAD,
                E.FECHAENTREGA,
                E.FECHAMINREPOS,
                E.FECHAREPOS
                FROM eleprop E INNER JOIN material M ON M.MATECODI = E.CODMATERIAL
                WHERE TIPOELEPROP = 'H' AND CODTECNICO = $cod";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    $table .= '
                        <tr>
                            <td>'.$row['CODMATERIAL'].'</td>
                            <td colspan="2"><b>'.$row['MATEDESC'].'</b></td>
                            <td>'.$row['CANTIDAD'].'</td>
                            <td>'.$row['FECHAENTREGA'].'</td>
                            <td>'.$row['FECHAMINREPOS'].'</td>
                            <td>'.$row['FECHAREPOS'].'</td>
                        </tr>'; 
                } 
            }
            echo $table;
    }

?>