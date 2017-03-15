<?php
	if(!isset($_REQUEST["txtIdUsuarioPost"])){
		header('Location: cusu.php');
	}
	$usuarioCodigo = $_REQUEST["txtIdUsuarioPost"];
	$conn = require 'template/sql/conexion.php';

	//
		$depart = "";
		$locali = "";
		$usuarioCodigo = "";
		$tecnic = "";
		$tecnicNomb = "";
		$fRecibo = "";
		$fOrden = "";
		$fCumpli = "";
		$fAsigna = "";
		$fLegali = "";
		$pqrRepo = "";
		$pqrRepoNomb = "";
		$pqrEnco = "";
		$pqrEncoNomb = "";
		$canoa = "";
		$atencionNomb = "";
		$causlec = "";
		$atencionNoNomb = "";
		$usuarioNomb = "";
		$usuarioDirec = "";
		$usuarioMedidor = "";
		$recibidor = "";
		$metodoCorte = "";
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

	$query ="SELECT * FROM ot WHERE OTNUME = ".$_REQUEST["txtIdOrdenPost"];
    $respuesta = $conn->prepare($query) or die ($sql);
    if(!$respuesta->execute()) return false;
    if($respuesta->rowCount()>0){
    	while ($row=$respuesta->fetch()){
    		$depart = $row['OTDEPA'];
    		$locali = $row['OTLOCA'];
    		$usuarioCodigo = $row['OTUSUARIO'];

    		//TECNICO
    		$tecnic = $row['OTTECN'];
    		$tecnicNomb='';
    		if( ($tecnic!='') && ($tecnic!=0) ){
		        $queryTecnico ="SELECT TECNNOMB FROM tecnico WHERE TECNCODI = ".$tecnic;
		        $respuestaTecnico = $conn->prepare($queryTecnico) or die ($sql);
		        if(!$respuestaTecnico->execute()) return false;
		        if($respuestaTecnico->rowCount()>0){
		        	while ($rowTecnico=$respuestaTecnico->fetch()){
		        		$tecnicNomb = $rowTecnico['TECNNOMB'];  
		        	}
		        }
    		}else{ $tecnic = ''; }

		    
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
    		
    		//CAUSAS
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
    		//USUARIO
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
	    		$queryEstado ="SELECT ESOTDESC FROM estaot WHERE ESOTCODI = ".$estado;
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
    	}
    }
?>
<?php require 'template/start.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">
		<?php require 'template/menu.php'; ?>
		<div class="content-wrapper">
			<div class="container">
				
				<section class="content-header">
	             	<?php include 'template/sub_menu.php' ?>
					<!--
					<a id="btnSalida" onclick="enviarOrden()" class="btn btn-info btn-xs" data-toggle="tooltip" data-original-title="Salir"><i class="fa fa-sign-out"></i></a>
	            	-->
	            	<ol class="breadcrumb">
	                	<li><a href="#">Informacion Basica</a></li>
	                	<li class="active">Consulta de Usuarios</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Orden de Trabajo</h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body">
			                    	<input type="hidden" id="swEstadoPqr" value="0" readonly>
			                   	 	<div id="divConsultarPqrs" class="display-none"></div>
			                    	<div class="row">
					                	<div class="form-group">
					                     	<div class="col-sm-12">
					                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Orden</label>
				                        		<input <?php echo 'value="'.$depart.'"'; ?> type="text" class="form-control input-sm" readonly style="margin-left: 8px; width:50px; float: left;">
				                        		<input <?php echo 'value="'.$locali.'"'; ?> type="text" class="form-control input-sm" readonly style="width:50px; float: left; margin-left: 8px;">
				                        		<input <?php echo 'value="'.$_REQUEST["txtIdOrdenPost"].'"'; ?> type="text" class="form-control input-sm" readonly style="width:130px; float: left; margin-left: 10px;">
					                     		
					                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Tecnico</label>
				                        		<input <?php echo 'value="'.$tecnic.'"'; ?> type="text" class="form-control input-sm" readonly style="width:100px; float: left; margin-left: 8px;">
				                        		<input <?php echo 'value="'.$tecnicNomb.'"'; ?> type="text" class="form-control input-sm" readonly style="width:300px; float: left; margin-left: 10px;">
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop5">
					                	<div class="form-group">
					                     	<div class="col-sm-12 ">
					                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Fecha Recibido</label>
				                        		<input <?php echo 'value="'.$fRecibo.'"'; ?> type="text" class="form-control input-sm" readonly style="margin-left: 8px; width:100px; float: left;">
				                      			
				                      			<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:90px; float:left;">Fecha Orden</label>
				                        		<input <?php echo 'value="'.$fOrden.'"'; ?> type="text" class="form-control input-sm" readonly style="margin-left: 8px; width:85px; float: left;">
				                        		
				                        		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:140px; float:left;">Fecha Cumplimiento</label>
				                        		<input <?php echo 'value="'.$fCumpli.'"'; ?> type="text" class="form-control input-sm" readonly style="margin-left: 8px; width:90px; float: left;">
				                        		
												<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:120px; float:left;">Fecha Asignacion</label>
				                        		<input <?php echo 'value="'.$fAsigna.'"'; ?> type="text" class="form-control input-sm" readonly style="margin-left: 8px; width:95px; float: left;">
				                      			
				                      			<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:125px; float:left;">Fecha Legalizacion</label>
				                        		<input <?php echo 'value="'.$fLegali.'"'; ?> type="text" class="form-control input-sm" readonly style="margin-left: 8px; width:95px; float: left;">
				                      			
				                      		</div>
					                    </div>
				                	</div>
				                    <div class="row marginTop5">
					                	<div class="form-group">
					                     	<div class="col-sm-12 ">
					                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">PQR Reportada</label>
				                        		<input <?php echo 'value="'.$pqrRepo.'"'; ?> type="text" class="form-control input-sm" readonly style="width:50px; float: left; margin-left: 8px;">
				                        		<input <?php echo 'value="'.$pqrRepoNomb.'"'; ?> type="text" class="form-control input-sm" readonly style="width:350px; float: left; margin-left: 10px;">
				                      			
												<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:130px; float:left;">PQR Encontrada</label>
				                        		<input <?php echo 'value="'.$pqrEnco.'"'; ?> type="text" class="form-control input-sm" readonly style="width:50px; float: left; margin-left: 8px;">
				                        		<input <?php echo 'value="'.$pqrEncoNomb.'"'; ?> type="text" class="form-control input-sm" readonly style="width:365px; float: left; margin-left: 10px;">
				                      			
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop5">
					                	<div class="form-group">
					                     	<div class="col-sm-12 ">
					                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Causa Atencion</label>
				                        		<input <?php echo 'value="'.$canoa.'"'; ?> type="text" class="form-control input-sm" readonly style="width:100px; float: left; margin-left: 8px;">
				                        		<input <?php echo 'value="'.$atencionNomb.'"'; ?> type="text" class="form-control input-sm" readonly style="width:300px; float: left; margin-left: 10px;">
				                      			
												<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:130px; float:left;">Causa no Atencion</label>
				                        		<input <?php echo 'value="'.$causlec.'"'; ?> type="text" class="form-control input-sm" readonly style="width:100px; float: left; margin-left: 8px;">
				                        		<input <?php echo 'value="'.$atencionNoNomb.'"'; ?> type="text" class="form-control input-sm" readonly style="width:316px; float: left; margin-left: 10px;">
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop5">
					                	<div class="form-group">
					                     	<div class="col-sm-12 ">
					                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Usuario</label>
				                        		<input <?php echo 'value="'.$usuarioCodigo.'"'; ?> type="text" class="form-control input-sm" readonly style="width:100px; float: left; margin-left: 8px;">
				                        		<input <?php echo 'value="'.$usuarioNomb.'"'; ?> type="text" class="form-control input-sm" readonly style="width:300px; float: left; margin-left: 10px;">
				                      			
												<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:130px; float:left;">Recibidor</label>
				                        		<input <?php echo 'value="'.$recibidor.'"'; ?> type="text" class="form-control input-sm" readonly style="width:200px; float: left; margin-left: 10px;">
												
												<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:140px; float:left;">Metodo de Corte</label>
				                        		<?php if($metodoCorte=='S'){ $metCort = 'checked="checked"'; }else{ $metCort = ''; } ?>
				                        		<input type="checkbox" <?php echo $metCort; ?> style="float: left; margin-left: 10px; margin-top: 10px;">
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop5">
					                	<div class="form-group">
					                     	<div class="col-sm-12 ">
					                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;"></label>
				                        		<input <?php echo 'value="'.$usuarioDirec.'"'; ?> type="text" class="form-control input-sm" readonly style="width:410px; float: left; margin-left: 8px;">
				                      			
												<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:70px; float:left;">Asignador</label>
				                        		<input <?php echo 'value="'.$asignador.'"'; ?> type="text" class="form-control input-sm" readonly style="width:197px; float: left; margin-left: 10px;">
												
												<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:80px; float:left;">Legalizador</label>
				                        		<input <?php echo 'value="'.$legalizacion.'"'; ?> type="text" class="form-control input-sm" readonly style="width:197px; float: left; margin-left: 10px;">
				                      		</div>
					                    </div>
				                	</div>
									<div class="row marginTop5">
					                	<div class="form-group">
					                     	<div class="col-sm-12 ">
					                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Medidor</label>
				                        		<input <?php echo 'value="'.$usuarioMedidor.'"'; ?> type="text" class="form-control input-sm" id="txtCod" readonly style="width:200px; float: left; margin-left: 8px;">
				                      			
												<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:80px; float:left;">Lectura</label>
				                        		<input <?php echo 'value="'.$lectura.'"'; ?> type="text" class="form-control input-sm" id="txtCod" readonly style="width:200px; float: left; margin-left: 10px;">
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop5">
					                	<div class="form-group">
					                     	<div class="col-sm-12 ">
					                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Causa Lectura</label>
				                        		<input <?php echo 'value="'.$causaLect.'"'; ?> type="text" class="form-control input-sm" id="txtCod" readonly style="width:100px; float: left; margin-left: 8px;">
				                      			
												<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:140px; float:left;">Observacion Lectura</label>
				                        		<input <?php echo 'value="'.$obsLectu.'"'; ?> type="text" class="form-control input-sm" id="txtCod" readonly style="width:150px; float: left; margin-left: 10px;">

				                        		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:50px; float:left;">Estado</label>
				                        		<input <?php echo 'value="'.$estado.'"'; ?> type="text" class="form-control input-sm" id="txtCod" readonly style="width:40px; float: left; margin-left: 10px;">
				                        		<input <?php echo 'value="'.$estadoNomb.'"'; ?> type="text" class="form-control input-sm" id="txtCod" readonly style="width:130px; float: left; margin-left: 10px;">

				                        		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:80px; float:left;">Hora Inicial</label>
				                        		<input <?php echo 'value="'.$horaInicial.'"'; ?> type="text" class="form-control input-sm" id="txtCod" readonly style="width:80px; float: left; margin-left: 10px;">
				                        		
				                        		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:70px; float:left;">Hora Final</label>
				                        		<input <?php echo 'value="'.$horaFinal.'"'; ?> type="text" class="form-control input-sm" id="txtCod" readonly style="width:80px; float: left; margin-left: 10px;">
				                      		</div>
					                    </div>
				                	</div>
				                	<hr>
				                	<div class="row marginTop5">
					                	<div class="form-group">
					                     	<div class="col-sm-5">
					                     		<div class="row">
					                     			<div class="col-sm-12">
							                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Observacion de la Orden</label>
						                        		<textarea class="form-control input-sm" rows="6" readonly style="width:325px; float: left; margin-left: 8px;"><?php echo $objDeOrden ?></textarea>
					                     			</div>
					                     		</div>
					                     		<div class="row marginTop5">
					                     			<div class="col-sm-12">
							                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Observacion de la Asignacion</label>
						                        		<textarea class="form-control input-sm" rows="6" readonly style="width:325px; float: left; margin-left: 8px;"><?php echo $objDeAsign ?></textarea>
					                     			</div>
					                     		</div>
					                     		<div class="row marginTop5">
					                     			<div class="col-sm-12">
							                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Observacion de la Legalizacion</label>
						                        		<textarea class="form-control input-sm" rows="6" readonly style="width:325px; float: left; margin-left: 8px;"><?php echo $objDeLegal ?></textarea>
					                     			</div>
					                     		</div>
					                     		<div class="row marginTop5">
					                     			<div class="col-sm-12">
							                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Observacion de la Certificacion</label>
						                        		<textarea class="form-control input-sm" rows="6" readonly style="width:325px; float: left; margin-left: 8px;"><?php echo $objDeCerti ?></textarea>
					                     			</div>
					                     		</div>
				                      		</div>
				                      		<div class="col-sm-7">
				                      			<div class="row">
				                      				<div class="col-sm-12">
														<fieldset>
															<legend><small><strong>Mano de Obra</strong></small></legend>
															<div style="height: 150px; overflow-y: scroll;">
																<table class="table table-condensed table-hover">
																	<thead>
											                            <tr style="background-color: #3c8dbc; color:white;">
											                             	<th class="text-center" width="50">Codigo</th>
											                              	<th class="text-left">Descripcion</th>
											                              	<th class="text-center" width="50">Cantidad</th>
											                              	<th class="text-right" width="100">Valor a Pagar</th>
											                              	<th class="text-center" width="50">Tecnico</th>
											                            </tr>
											                        </thead>
											                        <tbody>
											                        	<?php 
											                        		$queryManoObra ="SELECT MOBROTTR.MOOTMOBR, MANOBRA.MOBRDESC, MOBROTTR.MOOTCANT, MOBROTTR.MOOTVAPA, MOBROTTR.MOOTTECN
																						     FROM MOBROTTR
																						     INNER JOIN MANOBRA ON MANOBRA.MOBRCODI = MOBROTTR.MOOTMOBR
																						     WHERE MOBROTTR.MOOTNUMO = ".$_REQUEST["txtIdOrdenPost"];
															    			$respuestaManoObra = $conn->prepare($queryManoObra) or die ($sql);
																	        if(!$respuestaManoObra->execute()) return false;
																	        if($respuestaManoObra->rowCount()>0){
																	        	while ($rowManoObra=$respuestaManoObra->fetch()){
																	        		echo '
																						<tr>
																							<td class="text-center">'.$rowManoObra['MOOTMOBR'].'</td>
																							<td>'.$rowManoObra['MOBRDESC'].'</td>
																							<td class="text-center">'.$rowManoObra['MOOTCANT'].'</td>
																							<td class="text-right">'.number_format($rowManoObra['MOOTVAPA'],0,'','.').'</td>
																							<td class="text-center">'.$rowManoObra['MOOTTECN'].'</td>
																						</tr>
																	        		';
																	        	}
																	        }
											                        	?>
											                        </tbody>
																</table>
															</div>
															<br>
															<textarea class="form-control input-sm" rows="2" readonly ></textarea>
														</fieldset>
				                      				</div>
				                      			</div>
				                      			<div class="row marginTop5">
				                      				<div class="col-sm-12">
														<fieldset>
															<legend><small><strong>Materiales</strong></small></legend>
															<div style="height: 150px; overflow-y: scroll;">
																<table class="table table-condensed table-hover">
																	<thead>
											                            <tr style="background-color: #3c8dbc; color:white;">
											                             	<th class="text-center" width="50">Codigo</th>
											                              	<th class="text-left">Descripcion</th>
											                              	<th class="text-center" width="50">Cantidad</th>
											                              	<th class="text-right" width="100">Valor</th>
											                              	<th class="text-center" width="10">TL</th>
											                              	<th class="text-center" width="10">PR</th>
											                            </tr>
											                        </thead>
											                        <tbody>
											                        	<?php 
											                        		$queryManoObra ="SELECT MALEOTTR.MAOTMATE, MATERIAL.MATEDESC, MALEOTTR.MAOTCANT, MALEOTTR.MAOTVLOR, MALEOTTR.MAOTTILE, MALEOTTR.MAOTPROP
																							 FROM MALEOTTR
																							 INNER JOIN MATERIAL ON MATERIAL.MATECODI = MALEOTTR.MAOTMATE
																							 WHERE MALEOTTR.MAOTNUMO =".$_REQUEST["txtIdOrdenPost"];
															    			$respuestaManoObra = $conn->prepare($queryManoObra) or die ($sql);
																	        if(!$respuestaManoObra->execute()) return false;
																	        if($respuestaManoObra->rowCount()>0){
																	        	while ($rowManoObra=$respuestaManoObra->fetch()){
																	        		echo '
																						<tr>
																							<td class="text-center">'.$rowManoObra['MAOTMATE'].'</td>
																							<td>'.$rowManoObra['MATEDESC'].'</td>
																							<td class="text-center">'.$rowManoObra['MAOTCANT'].'</td>
																							<td class="text-right">'.number_format($rowManoObra['MAOTVLOR'],0,'','.').'</td>
																							<td class="text-center">'.$rowManoObra['MAOTTILE'].'</td>
																							<td class="text-center">'.$rowManoObra['MAOTPROP'].'</td>
																						</tr>
																	        		';
																	        	}
																	        }
											                        	?>
											                        </tbody>
																</table>
															</div>
														</fieldset>
				                      				</div>
				                      			</div>
				                      		</div>
					                    </div>
				                	</div>
			                    </div>
							</div>
						</div>
					</div>
				</section>
				
				<form method="POST" action="cusu.php" class="display-none" id="formDetalleOrdenPost">
					<input type="hidden" id="txtIdUsuarioPost" name="txtIdUsuarioPost" <?php echo 'value="'.$usuarioCodigo.'"'; ?>>
				</form>
			</div>
		</div>
		<?php require 'template/footer.php'; ?>
	</div>
</body>
<?php require 'template/end.php'; ?>
<script src="js/cusuOrden.js"></script>