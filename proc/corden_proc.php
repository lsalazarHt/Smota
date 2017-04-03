<?php
	session_start();
	date_default_timezone_set('America/Bogota');
	$conn = require '../template/sql/conexion.php';
	
	if($_REQUEST["accion"]=="consultar_ordenes"){
    	$dato='';
    	$i=0;
		
		$depOt  = $_REQUEST["dep"];
		$locOt  = $_REQUEST["loc"];
		$numOt  = $_REQUEST["num"];
		$tecnic = $_REQUEST["tec"];
		$pqrRep = $_REQUEST["pqrR"];
		$pqrEnc = $_REQUEST["pqrE"];
		$usuCod = $_REQUEST["usu"];
		$estCod = $_REQUEST["est"];

		$swWhere = false;
		//generar where
			$sqlDep = '';
			$sqlLoc = '';
			$sqlNum = '';
			$sqlTec = '';
			$sqlPqrRep = '';
			$sqlPqrEnc = '';
			$sqlUsu = '';
			$sqlEst = '';
			if($depOt!=''){//departamento
				$sqlDep = "OTDEPA = $depOt";
				$swWhere = true;
			}

			if($locOt!=''){//localidad
				if($depOt!=''){
					$sqlLoc = "AND OTLOCA = $locOt";					
				}else{
					$sqlLoc = "OTLOCA = $locOt";
				}
				$swWhere = true;
			}

			if($numOt!=''){//numero ot
				if( ($depOt!='') || ($locOt!='') ){
					$sqlNum = "AND OTNUME = $numOt";					
				}else{
					$sqlNum = "OTNUME = $numOt";
				}
				$swWhere = true;
			}

			if($tecnic!=''){//tecnico
				if( ($depOt!='') || ($locOt!='') || ($numOt!='') ){
					$sqlTec = "AND OTTECN = $tecnic";					
				}else{
					$sqlTec = "OTTECN = $tecnic";
				}
				$swWhere = true;
			}

			if($pqrRep!=''){//pqr reportada
				if( ($depOt!='') || ($locOt!='') || ($numOt!='') || ($tecnic!='') ){
					$sqlPqrRep = "AND OTPQRREPO = $pqrRep";					
				}else{
					$sqlPqrRep = "OTPQRREPO = $pqrRep";
				}
				$swWhere = true;
			}

			if($pqrEnc!=''){//pqr encontrada
				if( ($depOt!='') || ($locOt!='') || ($numOt!='') || ($tecnic!='') || ($pqrRep!='') ){
					$sqlPqrEnc = "AND OTPQRENCO = $pqrEnc";					
				}else{
					$sqlPqrEnc = "OTPQRENCO = $pqrEnc";
				}
				$swWhere = true;
			}

			if($usuCod!=''){//usuario
				if( ($depOt!='') || ($locOt!='') || ($numOt!='') || ($tecnic!='') || ($pqrRep!='') || ($pqrEnc!='') ){
					$sqlUsu = "AND OTUSUARIO = $usuCod";					
				}else{
					$sqlUsu = "OTUSUARIO = $usuCod";
				}
				$swWhere = true;
			}

			if($estCod!=''){//estado
				if( ($depOt!='') || ($locOt!='') || ($numOt!='') || ($tecnic!='') || ($pqrRep!='') || ($pqrEnc!='') || ($usuCod!='')){
					$sqlEst = "AND OTESTA = $estCod";					
				}else{
					$sqlEst = "OTESTA = $estCod";
				}
				$swWhere = true;
			}
		//
		$sqlWhere = '';
		if($swWhere){ $sqlWhere = 'WHERE '; }
		$query ="SELECT OTDEPA,OTLOCA,OTNUME FROM ot $sqlWhere $sqlDep $sqlLoc $sqlNum $sqlTec $sqlPqrRep $sqlPqrEnc $sqlUsu $sqlEst ";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
            	$i++;
                $dato .='<input type="hidden" id="txtCod_consulta_dep'.$i.'" value="'.$row['OTDEPA'].'">';
                $dato .='<input type="hidden" id="txtCod_consulta_loc'.$i.'" value="'.$row['OTLOCA'].'">';
                $dato .='<input type="hidden" id="txtCod_consulta_nun'.$i.'" value="'.$row['OTNUME'].'"><br>';
            }   
        }
       	echo $dato.'<br>
            <input type="hidden" id="txtActual_consulta" value="1"><br>
        <input type="hidden" id="txtToltal_consulta" value="'.$i.'">';
	}
	
	if($_REQUEST["accion"]=="buscar_orden"){
		$depOt  = $_REQUEST["dep"];
		$locOt  = $_REQUEST["loc"];
		$numOt  = $_REQUEST["num"];
		$tecnic = '';
		$pqrRep = '';
		$pqrEnc = '';
		$usuCod = '';
		$estCod = '';

		//variables
			$tecnicNomb	= "";
			$fecRec = "";
			$fecOrd = "";
			$fecCum = "";
			$fecAsi = "";
			$fecLeg = "";

			$pqrRepoNomb = "";

			$pqrEncoNomb = "";

			$canoa = "";
			$atencionNomb = "";

			$causlec = "";
			$atencionNoNomb = "";

			$usuarioNomb = "";
			$usuarioDirec = "";
			$usuarioMedidor = "";

			$recibidor = "";
			$metodoCorte = 1;
			$asignador = "";
			$legalizacion = "";

			$lectura = "";
			$causaLect = "";
			$obsLectu = "";

			$estado = "";
			$estadoNomb = "";

			$horaInicial = "";
			$horaFinal = "";

			$objDeOrden = "";
			$objDeAsign = "";
			$objDeLegal = "";
			$objDeCerti = "";
		//

		$query ="SELECT * FROM ot 
				 WHERE OTDEPA = $depOt AND  OTLOCA = $locOt AND OTNUME = $numOt";
	    $respuesta = $conn->prepare($query) or die ($sql);
	    if(!$respuesta->execute()) return false;
	    if($respuesta->rowCount()>0){
	    	while ($row=$respuesta->fetch()){
	    		$dep = $row['OTDEPA'];
	    		$loc = $row['OTLOCA'];

	    		//tecnico
		    		$tecnic = (int)$row['OTTECN'];
		    		if( ($tecnic!='') && ($tecnic!=0) ){
				        $queryTecnico ="SELECT * FROM tecnico WHERE TECNCODI = $tecnic";
				        $respuestaTecnico = $conn->prepare($queryTecnico) or die ($sql);
				        if(!$respuestaTecnico->execute()) return false;
				        if($respuestaTecnico->rowCount()>0){
				        	while ($rowTecnico=$respuestaTecnico->fetch()){
				        		$tecnicNomb = utf8_encode($rowTecnico['TECNNOMB']);  
				        	}
				        }
		    		}else{ $tecnic = ''; $tecnicNomb = ''; }
				//
		    	//fechas
		    		$fecRec = $row['OTFERECI'];
		    		$fecOrd = $row['OTFEORD'];
		    		$fecCum = $row['OTCUMP'];
		    		$fecAsi = $row['OTFEAS'];
		    		$fecLeg = $row['OTFELE'];
				//
				//pqr
			    	$pqrRepo = $row['OTPQRREPO'];
		    		if($pqrRepo!=''){
			    		$pqrRepoNomb='';
				    		$queryPQRRepo ="SELECT PQRDESC FROM pqr WHERE PQRCODI = ".$pqrRepo;
					        $respuestaPQRRepo = $conn->prepare($queryPQRRepo) or die ($sql);
					        if(!$respuestaPQRRepo->execute()) return false;
					        if($respuestaPQRRepo->rowCount()>0){
					        	while ($rowPQRRepo=$respuestaPQRRepo->fetch()){
					        		$pqrRepoNomb = $rowPQRRepo['PQRDESC'];  
					        	}
					        }
		    		}else{ $pqrRepoNomb=''; }

		    		$pqrEnco = $row['OTPQRENCO'];
		    		if($pqrEnco!=''){
			    		$pqrEncoNomb='';
				    		$querypqrEnco ="SELECT PQRDESC FROM pqr WHERE PQRCODI = ".$pqrEnco;
					        $respuestapqrEnco = $conn->prepare($querypqrEnco) or die ($sql);
					        if(!$respuestapqrEnco->execute()) return false;
					        if($respuestapqrEnco->rowCount()>0){
					        	while ($rowpqrEnco=$respuestapqrEnco->fetch()){
					        		$pqrEncoNomb = $rowpqrEnco['PQRDESC'];  
					        	}
					        }
		    		}else{ $pqrEncoNomb=''; }
				//
		    	//causal
		    		$canoa = $row['OTCAAT'];
		    		if($canoa!=''){
			    		$atencionNomb='';
				    		$queryAtencion ="SELECT CAATDESC FROM causaten WHERE CAATCODI = ".$canoa;
					        $respuestaAtencion = $conn->prepare($queryAtencion) or die ($sql);
					        if(!$respuestaAtencion->execute()) return false;
					        if($respuestaAtencion->rowCount()>0){
					        	while ($rowAtencion=$respuestaAtencion->fetch()){
					        		$atencionNomb = $rowAtencion['CAATDESC'];  
					        	}
					        }
		    		}else{ $atencionNomb='Causa de atencion idefinida'; }

		    		$causlec = $row['OTCANOA'];
		    		if($causlec!=''){
			    		$atencionNoNomb='';
				    		$queryNoAtencion ="SELECT CANADESC FROM causnoaten WHERE CANACODI = ".$causlec;
					        $respuestaNoAtencion = $conn->prepare($queryNoAtencion) or die ($sql);
					        if(!$respuestaNoAtencion->execute()) return false;
					        if($respuestaNoAtencion->rowCount()>0){
					        	while ($rowNoAtencion=$respuestaNoAtencion->fetch()){
					        		$atencionNoNomb = $rowNoAtencion['CANADESC'];  
					        	}
					        }
		    		}else{ $atencionNoNomb='Causa de NO atencion idefinida'; }
				//
		    	//usuario
		    		$usuarioCodigo = $row['OTUSUARIO'];
		    		$usuarioNomb = '';  
		    		$usuarioDirec = '';
		    		$usuarioMedidor = '';
		    		if($usuarioCodigo!=''){
			    		$queryUsuario ="SELECT USUNOMB,USUDIRE,USUMEDI FROM usuarios WHERE USUCODI = ".$usuarioCodigo;
				        $respuestaUsuario = $conn->prepare($queryUsuario) or die ($sql);
				        if(!$respuestaUsuario->execute()) return false;
				        if($respuestaUsuario->rowCount()>0){
				        	while ($rowUsuario=$respuestaUsuario->fetch()){
				        		$usuarioNomb = $rowUsuario['USUNOMB'];  
				        		$usuarioDirec = $rowUsuario['USUDIRE'];
				        		$usuarioMedidor = $rowUsuario['USUMEDI'];
				        	}
				        }
		    		}
				//

			    //user
			    	$recibidor = $row['OTUSERCRE'];
			    	if($row['OTMECO']==null){
		    			$metodoCorte = 0;
			    	}
		    		$asignador = $row['OTUSERASI'];
		    		$legalizacion = $row['OTUSERLEG'];
				//
		    	//lectura
		    		$lectura = $row['OTLECT'];
		    		$causaLect = $row['OTCAUSLEC'];
		    		$obsLectu = $row['OTOBSELEC'];
				//
		    	//estado
		    		$estado = $row['OTESTA'];
		    		$estadoNomb='';
		    		if($estado!=''){
			    		$queryEstado ="SELECT ESOTDESC FROM estaot WHERE ESOTCODI = ".$estado;
			    			$respuestaEstado = $conn->prepare($queryEstado) or die ($sql);
					        if(!$respuestaEstado->execute()) return false;
					        if($respuestaEstado->rowCount()>0){
					        	while ($rowEstado=$respuestaEstado->fetch()){
					        		$estadoNomb = $rowEstado['ESOTDESC'];  
					        	}
					        }
		    		}
				//
		    	//hora
				    $horaInicial = str_pad($row['OTHORAIN'],2,"0",STR_PAD_LEFT).':'.str_pad($row['OTMIIN'],2,"0",STR_PAD_LEFT);
				    $horaFinal = str_pad($row['OTHORAFI'],2,"0",STR_PAD_LEFT).':'.str_pad($row['OTMIFI'],2,"0",STR_PAD_LEFT);
	    		//
	    		//observaciones
				    $objDeOrden = $row['OTOBSEAS'];
				    $objDeAsign = $row['OTOBSERVAS'];
				    $objDeLegal = $row['OTOBSELE'];
				    $objDeCerti = $row['OTOBSCER'];
				//
	    	}
	    }
	    $arr = array($dep,$loc,$tecnic,$tecnicNomb,$fecRec,$fecOrd,$fecCum,$fecAsi,$fecLeg,$pqrRepo,$pqrRepoNomb,$pqrEnco,$pqrEncoNomb,$canoa,$atencionNomb,$causlec,$atencionNoNomb,$usuarioCodigo,$usuarioNomb,$usuarioDirec,$usuarioMedidor,$recibidor,$metodoCorte,$asignador,$legalizacion,$lectura,$causaLect,$obsLectu,$estado,$estadoNomb,$horaInicial,$horaFinal,$objDeOrden,$objDeAsign,$objDeLegal,$objDeCerti);
		echo json_encode($arr);
	}

	if($_REQUEST["accion"]=="obtener_mano_obra"){
		$num = $_REQUEST["num"];
		$table = "";
		$query ="SELECT MOOTMOBR, manobra.MOBRDESC, MOOTCANT, MOOTVAPA, MOOTTECN
				 FROM mobrottr INNER JOIN manobra ON manobra.MOBRCODI = mobrottr.MOOTMOBR
				 WHERE MOOTNUMO = $num";
	    $respuesta = $conn->prepare($query) or die ($sql);
	    if(!$respuesta->execute()) return false;
	    if($respuesta->rowCount()>0){
	    	while ($row=$respuesta->fetch()){
	    		$table .= '
					<tr>
						<td class="text-center">'.$row['MOOTMOBR'].'</td>
						<td class="text-left">'.$row['MOBRDESC'].'</td>
						<td class="text-right">'.$row['MOOTCANT'].'</td>
						<td class="text-right">'.$row['MOOTVAPA'].'</td>
						<td class="text-center">'.$row['MOOTTECN'].'</td>
					</tr>
	    		';
	    	}
	    }
	    echo $table;
	}

	if($_REQUEST["accion"]=="obtener_materiales"){
		$num = $_REQUEST["num"];
		$table = "";
		$query ="SELECT MAOTMATE, MATEDESC, MAOTCANT, MAOTVLOR, MAOTTILE, MAOTPROP
				 FROM maleottr INNER JOIN material ON material.`MATECODI` = maleottr.MAOTMATE
				 WHERE MAOTNUMO = $num";
	    $respuesta = $conn->prepare($query) or die ($sql);
	    if(!$respuesta->execute()) return false;
	    if($respuesta->rowCount()>0){
	    	while ($row=$respuesta->fetch()){
	    		$table .= '
					<tr>
						<td class="text-center">'.$row['MAOTMATE'].'</td>
						<td class="text-left">'.$row['MATEDESC'].'</td>
						<td class="text-right">'.$row['MAOTCANT'].'</td>
						<td class="text-right">'.$row['MAOTVLOR'].'</td>
						<td class="text-center">'.$row['MAOTTILE'].'</td>
						<td class="text-center requerido">'.$row['MAOTPROP'].'</td>
					</tr>
	    		';
	    	}
	    }
	    echo $table;
	}

	if($_REQUEST["accion"]=="buscar_orden_2"){
		$num = $_REQUEST["num"];
		
		$query ="SELECT * FROM ot WHERE OTNUME = '$num'";
	    $respuesta = $conn->prepare($query) or die ($sql);
	    if(!$respuesta->execute()) return false;
	    if($respuesta->rowCount()>0){
	    	while ($row=$respuesta->fetch()){
	    		//$usuarioCodigo = $row['OTUSUARIO'];

	    		//TECNICO
		    		$tecnic = $row['OTTECN'];
		    		$tecnicNomb='';
		    		if( ($tecnic!='') && ($tecnic!=0) ){
				        $queryTecnico ="SELECT TECNNOMB FROM TECNICO WHERE TECNCODI = ".$tecnic;
				        $respuestaTecnico = $conn->prepare($queryTecnico) or die ($sql);
				        if(!$respuestaTecnico->execute()) return false;
				        if($respuestaTecnico->rowCount()>0){
				        	while ($rowTecnico=$respuestaTecnico->fetch()){
				        		$tecnicNomb = $rowTecnico['TECNNOMB'];  
				        	}
				        }
		    		}else{ $tecnic = ''; }

			    //fechas
				    if($row['OTFERECI']!=''){
				    	$f_Recibo = explode('-', $row['OTFERECI']);
		    			$fRecibo = $f_Recibo[2].'/'.$f_Recibo[1].'/'.$f_Recibo[0];
				    }else{ $fRecibo=''; }

				    if($row['OTFEORD']!=''){
				    	$f_Orden = explode('-', $row['OTFEORD']);
		    			$fOrden = $f_Orden[2].'/'.$f_Orden[1].'/'.$f_Orden[0];
				    }else{ $fOrden=''; }

				    if($row['OTCUMP']!=''){
				    	$f_Cumpli = explode('-', $row['OTCUMP']);
		    			$fCumpli = $f_Cumpli[2].'/'.$f_Cumpli[1].'/'.$f_Cumpli[0];
				    }else{ $fCumpli=''; }

				    if($row['OTFEAS']!=''){
				    	$f_Asigna = explode('-', $row['OTFEAS']);
		    			$fAsigna = $f_Asigna[2].'/'.$f_Asigna[1].'/'.$f_Asigna[0];
				    }else{ $fAsigna=''; }

				    if($row['OTFELE']!=''){
				    	$f_Legali = explode('-', $row['OTFELE']);
		    			$fLegali = $f_Legali[2].'/'.$f_Legali[1].'/'.$f_Legali[0];
				    }else{ $fLegali=''; }

	    		//PQR´s
			    	/*$pqrRepo = $row['OTPQRREPO'];
		    		if($pqrRepo!=''){
			    		$pqrRepoNomb='';
				    		$queryPQRRepo ="SELECT PQRDESC FROM PQR WHERE PQRCODI = ".$pqrRepo;
					        $respuestaPQRRepo = $conn->prepare($queryPQRRepo) or die ($sql);
					        if(!$respuestaPQRRepo->execute()) return false;
					        if($respuestaPQRRepo->rowCount()>0){
					        	while ($rowPQRRepo=$respuestaPQRRepo->fetch()){
					        		$pqrRepoNomb = $rowPQRRepo['PQRDESC'];  
					        	}
					        }
		    		}else{ $pqrRepoNomb=''; }

		    		$pqrEnco = $row['OTPQRENCO'];
		    		if($pqrEnco!=''){
			    		$pqrEncoNomb='';
				    		$querypqrEnco ="SELECT PQRDESC FROM PQR WHERE PQRCODI = ".$pqrEnco;
					        $respuestapqrEnco = $conn->prepare($querypqrEnco) or die ($sql);
					        if(!$respuestapqrEnco->execute()) return false;
					        if($respuestapqrEnco->rowCount()>0){
					        	while ($rowpqrEnco=$respuestapqrEnco->fetch()){
					        		$pqrEncoNomb = $rowpqrEnco['PQRDESC'];  
					        	}
					        }
		    		}else{ $pqrEncoNomb=''; }
	    		
	    		//CAUSAS
		    		$canoa = $row['OTCAAT'];
		    		if($canoa!=''){
			    		$atencionNomb='';
				    		$queryAtencion ="SELECT CAATDESC FROM CAUSATEN WHERE CAATCODI = ".$canoa;
					        $respuestaAtencion = $conn->prepare($queryAtencion) or die ($sql);
					        if(!$respuestaAtencion->execute()) return false;
					        if($respuestaAtencion->rowCount()>0){
					        	while ($rowAtencion=$respuestaAtencion->fetch()){
					        		$atencionNomb = $rowAtencion['CAATDESC'];  
					        	}
					        }
		    		}else{ $atencionNomb='Causa de atencion idefinida'; }

		    		$causlec = $row['OTCANOA'];
		    		if($causlec!=''){
			    		$atencionNoNomb='';
				    		$queryNoAtencion ="SELECT CANADESC FROM CAUSNOATEN WHERE CANACODI = ".$causlec;
					        $respuestaNoAtencion = $conn->prepare($queryNoAtencion) or die ($sql);
					        if(!$respuestaNoAtencion->execute()) return false;
					        if($respuestaNoAtencion->rowCount()>0){
					        	while ($rowNoAtencion=$respuestaNoAtencion->fetch()){
					        		$atencionNoNomb = $rowNoAtencion['CANADESC'];  
					        	}
					        }
		    		}else{ $atencionNoNomb='Causa de NO atencion idefinida'; }

	    		//USUARIO
		    		$usuarioNomb = '';  
		    		$usuarioDirec = '';
		    		$usuarioMedidor = '';
		    		if($usuarioCodigo!=''){
			    		$queryUsuario ="SELECT USUNOMB,USUDIRE,USUMEDI FROM USUARIOS WHERE USUCODI = ".$usuarioCodigo;
				        $respuestaUsuario = $conn->prepare($queryUsuario) or die ($sql);
				        if(!$respuestaUsuario->execute()) return false;
				        if($respuestaUsuario->rowCount()>0){
				        	while ($rowUsuario=$respuestaUsuario->fetch()){
				        		$usuarioNomb = $rowUsuario['USUNOMB'];  
				        		$usuarioDirec = $rowUsuario['USUDIRE'];
				        		$usuarioMedidor = $rowUsuario['USUMEDI'];
				        	}
				        }
		    		}
	    		
			    
	    		$recibidor = $row['OTUSERCRE'];
	    		$metodoCorte = $row['OTMECO'];
	    		$asignador = $row['OTUSERASI'];
	    		$legalizacion = $row['OTUSERLEG'];

	    		$lectura = $row['OTLECT'];
	    		$causaLect = $row['OTCAUSLEC'];
	    		$obsLectu = $row['OTOBSELEC'];

	    		$estado = $row['OTESTA'];
	    		$estadoNomb='';
	    		if($estado!=''){
		    		$queryEstado ="SELECT ESOTDESC FROM ESTAOT WHERE ESOTCODI = ".$estado;
		    			$respuestaEstado = $conn->prepare($queryEstado) or die ($sql);
				        if(!$respuestaEstado->execute()) return false;
				        if($respuestaEstado->rowCount()>0){
				        	while ($rowEstado=$respuestaEstado->fetch()){
				        		$estadoNomb = $rowEstado['ESOTDESC'];  
				        	}
				        }
	    		}

			    $horaInicial = str_pad($row['OTHORAIN'],2,"0",STR_PAD_LEFT).':'.str_pad($row['OTMIIN'],2,"0",STR_PAD_LEFT);
			    $horaFinal = str_pad($row['OTHORAFI'],2,"0",STR_PAD_LEFT).':'.str_pad($row['OTMIFI'],2,"0",STR_PAD_LEFT);
	    	
			    $objDeOrden = $row['OTOBSEAS'];
			    $objDeAsign = $row['OTOBSERVAS'];
			    $objDeLegal = $row['OTOBSELE'];
			    $objDeCerti = $row['OTOBSCER'];

			    */
	    	}
	    }

        $arr = array($tecnic,$tecnicNomb,$fRecibo,$fOrden,$fCumpli,$fAsigna,$fLegali);
	    echo json_encode($arr);
	    //echo $tecnic.' | '.$tecnicNomb.' | '.$fRecibo.' | '.$fOrden.' | '.$fCumpli.' | '.$fAsigna.' | '.$fLegali;
	}
?>