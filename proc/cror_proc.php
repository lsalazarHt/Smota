<?php
	session_start();
	date_default_timezone_set('America/Bogota');
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="buscar_cuadrilla"){
		$dato='';
		$query ="SELECT * FROM cuadrilla WHERE CUADCODI = ".$_REQUEST["cod"];
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                	$dato = $row['CUADNOMB'];                              
                }   
            }
            echo $dato;
	}
	if($_REQUEST["accion"]=="buscar_tecnico"){
		$dato='';
		$query ="SELECT * FROM tecnico WHERE TECNCODI = ".$_REQUEST["cod"];
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                	$dato = utf8_encode($row['TECNNOMB']);                              
                }   
            }
            echo $dato;
	}
	if($_REQUEST["accion"]=="buscar_usuario"){
		$dato='';
		$query ="SELECT * FROM usuarios WHERE USUCODI = ".$_REQUEST["cod"];
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                	$dato = $row['USUNOMB'];                            
                }   
            }
            echo $dato;
	}
	if($_REQUEST["accion"]=="buscar_direc_usuario"){
		$dato='';
		$query ="SELECT * FROM usuarios WHERE USUCODI = ".$_REQUEST["cod"];
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                	$dato = $row['USUDIRE'];                            
                }   
            }
            echo $dato;
	}
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

	if($_REQUEST["accion"]=="guardar_ot"){
		$ordTip = $_REQUEST["ordTip"];
		if($ordTip=='p'){
			$swTip = 'N';
			$_REQUEST["dPadre"]='0';
			$_REQUEST["lPadre"]='0';
			$_REQUEST["nPadre"]='0';
		}else{
			$swTip = 'S';
		}
		if($_REQUEST["codTec"]==''){
			$_REQUEST["estad"] = 0;
			$_REQUEST["codTec"] = 0;
			$fecAsig = NULL;
			$fecCum = NULL;
		}else{
			if($_REQUEST["estad"]!=3){
				$_REQUEST["estad"] = 1;
				$fecCum = '';
				$leg = '';
			}else{
				$fecCum = date('Y-m-d');
				$leg = $_SESSION['user'];
			}
			$obsOrd = $_REQUEST["obsOrd"];
			$fecAsig = date('Y-m-d');

		}
		$hi = explode(':',$_REQUEST["horIni"]);
		$hf = explode(':',$_REQUEST["horFin"]);
		$queryInsert = "INSERT INTO ot (OTDEPA,OTLOCA,OTNUME,OTFEORD,OTCUAD,OTTECN,OTUSUARIO,OTESTA,OTPQRREPO,
										OTHORAIN,OTMIIN,OTHORAFI,OTMIFI,OTOBSEAS,OTFEAS,OTCUMP,OTHIJA,OTDEPAPA,
										OTLOCAPA,OTNUMEPA,OTUSERLEG) 
						VALUES (".$_REQUEST["dOrd"].",".$_REQUEST["lOrd"].",".$_REQUEST["nOrd"].",
								'".$_REQUEST["fecOrd"]."',".$_REQUEST["codCua"].",".$_REQUEST["codTec"].",
								".$_REQUEST["codUsu"].",".$_REQUEST["estad"].",".$_REQUEST["codTra"].",
								".$hi[0].",".$hi[1].",".$hf[0].",".$hf[1].",'".$obsOrd."',
								'".$fecAsig."','".$fecCum."','".$swTip."',".$_REQUEST["dPadre"].",
								".$_REQUEST["lPadre"].",".$_REQUEST["nPadre"].",'".$leg."')";

        $respuestaInsert = $conn->prepare($queryInsert) or die ($queryInsert);
        if(!$respuestaInsert->execute()){
            echo $queryInsert;
        }else{
           	echo 1;
        }
	}
	if($_REQUEST["accion"]=="guardar_mo_ot"){
		if($_REQUEST["codTec"]==''){ $_REQUEST["codTec"]=0; }
		
		$queryInsert = "INSERT INTO mobrottr (MOOTMOBR,MOOTDEPA,MOOTLOCA,MOOTNUMO,MOOTCANT,MOOTVAPA,MOOTTECN,MOOTTILE,MOOTFECH) 
						VALUES (".$_REQUEST["cod"].",".$_REQUEST["dOrd"].",".$_REQUEST["lOrd"].",
								".$_REQUEST["nOrd"].",".$_REQUEST["can"].",".$_REQUEST["val"].",
								".$_REQUEST["codTec"].",'D','".date('Y-m-d')."')";

        $respuestaInsert = $conn->prepare($queryInsert) or die ($queryInsert);
        if(!$respuestaInsert->execute()){
            echo $queryInsert;
        }else{
           	echo 1;
        }
	}
	if($_REQUEST["accion"]=="guardar_ma_ot"){
		$bod = '';
		$tec = $_REQUEST["codTec"];
		$cantInv = $_REQUEST["cantInv"];
		$cant = $_REQUEST["can"];
		$cod = $_REQUEST["cod"];

		$queryInsert = "INSERT INTO maleottr (MAOTMATE,MAOTDEPA,MAOTLOCA,MAOTNUMO,MAOTCANT,MAOTVLOR,MAOTTECN,MAOTTILE,MAOTFECH) 
						VALUES (".$_REQUEST["cod"].",".$_REQUEST["dOrd"].",".$_REQUEST["lOrd"].",
								".$_REQUEST["nOrd"].",".$_REQUEST["can"].",".$_REQUEST["val"].",
								".$_REQUEST["codTec"].",'D','".date('Y-m-d')."')";

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

           	//Actualizar Inventario
		    	//Nueva cantidad en inventario
		    	$newCant = ((int)$cantInv) - ((int)$cant);
           	$query_inventario = "UPDATE inventario SET INVECAPRO = $newCant WHERE INVEBODE = $bod AND INVEMATE = $cod";

	        $respuesta_inventario = $conn->prepare($query_inventario) or die ($query_inventario);
	        if(!$respuesta_inventario->execute()){
	            echo $query_inventario;
	        }else{
	           	echo 1;
	        }
        }
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
			    //verificar inventario
			        $queryInv ="SELECT * FROM inventario WHERE INVEBODE = $bod AND INVEMATE = $mate AND INVECAPRO > 0";
			        $respuestaInv = $conn->prepare($queryInv) or die ($sql);
			        if(!$respuestaInv->execute()) return false;
			        if($respuestaInv->rowCount()>0){
			        	while ($rowInv=$respuestaInv->fetch()){
			        		
			            	//materiales datos
			            	$queryU ="SELECT * FROM material WHERE MATECODI = $mate";
					        $respuestaU = $conn->prepare($queryU) or die ($sql);
					        if(!$respuestaU->execute()) return false;
					        if($respuestaU->rowCount()>0){
					            while ($rowU=$respuestaU->fetch()){
					            	$dato .= '<tr onclick="buscarMaterial('.$rowU['MATECODI'].',\''.$cantFija.'\','.$cant.','.$rowInv['INVECAPRO'].','.$rowInv['INVEVLRPRO'].')">
					            				<td class="text-center">'.$rowU['MATECODI'].'</td>
					            				<td>'.utf8_encode($rowU['MATEDESC']).'</td>
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
			    //verificar inventario
			        $queryInv ="SELECT * FROM inventario WHERE INVEBODE = $bod AND INVEMATE = $mate AND INVECAPRO > 0";
			        $respuestaInv = $conn->prepare($queryInv) or die ($sql);
			        if(!$respuestaInv->execute()) return false;
			        if($respuestaInv->rowCount()>0){
			        	while ($rowInv=$respuestaInv->fetch()){
			        		$invVal = $rowInv['INVECAPRO'];
			        		$invCant = $rowInv['INVEVLRPRO'];
			        		
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
        $arr = array($dato,$cant,$cantFija,$invVal,$invCant);
        echo json_encode($arr);
	}
?>