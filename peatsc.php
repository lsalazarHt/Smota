<?php
	date_default_timezone_set("America/Bogota");
	ini_set('upload_max_filesize', '100M');
	ini_set('post_max_size', '100M');
	ini_set('max_execution_time', 3600);

	$cont=0;
	$contErr=0;
	$swGeneral=false;
	$codCuadrilla='';
	$nomCuadrilla='';
	$ruta="";
	$swSector=true;
	$swPqr=true;
	$swUser=true;
	
	$swSectorIns=true;
	$swUserAct=true;
	$swUserIns=true;

	$otErrStr='';
	$sectorErrStr='';
	$pqrErrStr='';
	$userActErrStr='';
	$userInsErrStr='';

	$nameEXCEL='';
	$conn = require 'template/sql/conexion.php';
	//Si Existe Codigo de Cuadrilla
	if(isset($_REQUEST["txtCodCuad"])){

		//Si Existe Archivo Asignaciones
		if(isset($_FILES['fileAsignaciones']['name'])){
			if($_FILES['fileAsignaciones']['name']!=''){

				$nameEXCEL = $_FILES['fileAsignaciones']['name'];
                $tmpEXCEL  = $_FILES['fileAsignaciones']['tmp_name'];
                $urlnueva  = "lib/txtOt/SmotaOt_".date('Y-m-d H_i').".txt";
				
                if(is_uploaded_file($tmpEXCEL)){

                    copy($tmpEXCEL,$urlnueva);  
                }

                //Contar
                	$cont=0;
                	$contErr=0;
                //End Contar
                
                //Abrimos el Archivo
                	$archivo = fopen($urlnueva, "r") or die ("Error!");
                	while(!feof($archivo)){
			       		$linea = fgets($archivo);
			       		$saltoLinea = nl2br($linea);
                		
                		//Explotamos las lineas del archivo para obtener los datos detallados
                		$detalleOt = explode(';',$saltoLinea);

                		if( isset($detalleOt[0]) && isset($detalleOt[1]) && isset($detalleOt[2]) ){
	                		//$mes = array('ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nom','dic');
	                		$userCrea=$_REQUEST["txtUsuarioCrea"];
	                		$sw=0;
	                		$swSector=true;
	                		$swPqr=true;
	                		$swUser=true;
	                		$swSectorIns=true;

	                		//Datos del Archivo
		                		$dep = $detalleOt[0];
		                		$loc = $detalleOt[1];
		                		$num = $detalleOt[2];
		                		$sector = $detalleOt[6];
		                		$sectorNom = $detalleOt[7];
		                		$pqr = $detalleOt[3];
		                		$user = $detalleOt[4];
		                		$userNom = $detalleOt[5];
		                		$userDire = $detalleOt[8];
		                		$userSeOp = $detalleOt[6];
		                		$userSeON = $detalleOt[7];
		                		$userTel = $detalleOt[9];
		                		$fecCrea = $detalleOt[10];
		                		$fecOrd = $detalleOt[11];
		                		$observ = $detalleOt[12];
		                		$pqr = $detalleOt[3];
		                	//End Datos del Archivo

                			//Validamos el estado de la orden
		                		// 2 ASIGNADA POR RADIO		// 3 Pendiente
		                		// 4 Asignado				// 8 Suspension
	                			$queryOt ="SELECT OTESTA FROM ot 
	                					   WHERE OTDEPA=$dep AND OTLOCA=$loc AND OTNUME=$num
	                					   		AND (OTESTA=2 OR OTESTA=3 OR OTESTA=4 OR OTESTA=8)";
						        $respuestaOt = $conn->prepare($queryOt) or die ($sql);
						        if(!$respuestaOt->execute()) return false;
						        if($respuestaOt->rowCount()>0){
						            $sw=1;
						        }else{//No Existe
						        	$sw=0;
						        }
						    //End Validamos el estado de la orden
                			
                			if($sw==0){
                				
		                		//echo '#OT :'.$detalleOt[0].'-'.$detalleOt[1].'-'.$detalleOt[2].'<br>';
		                		//echo '#PQR :'.$detalleOt[3].'<br>';
		                		//echo 'USUARIO :'.$detalleOt[4].' - '.$detalleOt[5].'<br>';
		                		//echo 'BARRIO :'.$detalleOt[6].' - '.$detalleOt[7].'<br>';
		                		//echo 'DIRECCION :'.$detalleOt[8].'<br>';
		                		//echo 'TELEFONO :'.$detalleOt[9].'<br>';
		                		//echo 'FECHA CREACION ORDEN :'.$detalleOt[10].'<br>';
		                		//echo 'FECHA ORDEN :'.$detalleOt[11].'<br>';
		                		//echo 'OBSERVACION :'.$detalleOt[12].'<br>';
	                			//echo '----------<br>';

                				//Valido SECTOR OPERATIVO (Barrio)
	                				$querySec ="SELECT SEOPCODI FROM sectores 
	                					   WHERE SEOPDEPA=$dep AND SEOPLOCA=$loc AND SEOPCODI=$sector";
							        $respuestaSec = $conn->prepare($querySec) or die ($sql);
							        if(!$respuestaSec->execute()) return false;
							        if($respuestaSec->rowCount()>0){
							            $swSector=true;
							        }else{//No Existe
							        	$swSector=false;
							        }
							        //Si no Existe se crea
								        if(!$swSector){
								        	$querySec ="INSERT INTO sectores (SEOPDEPA,SEOPLOCA,SEOPCODI,SEOPNOMB)
								        				VALUES ($dep,$loc,$sector,'$sectorNom')";
									        $respuesta = $conn->prepare($querySec) or die ($querySec);
									        if(!$respuesta->execute()){
							        			$swGeneral=false;
							        			$swSectorIns=false;
									            $sectorErrStr .= "No se pudo insertar el sector # $sector : $sectorNom\r\n";
									            //echo 'Error!';
									        }else{
							        			$swSectorIns=true;
									            //echo 'Se Creo el Sector';
									        }
								        }
							    //End Valido SECTOR OPERATIVO

								//Validar PQR
								    $nomPqr='';
									$queryPqr ="SELECT PQRCODI, PQRTECN FROM pqr WHERE PQRCODI = $pqr";
							        $respuestaPqr = $conn->prepare($queryPqr) or die ($sql);
							        if(!$respuestaPqr->execute()) return false;
							        if($respuestaPqr->rowCount()>0){
							            $swPqr=true;
							            while ($row=$respuestaPqr->fetch()){
							            	$nomPqr=$row['PQRTECN'];
							            }
							        }else{//No Existe
							        	$swPqr=false;
							        	$pqrErrStr="La pqr # ".$pqr."-  No es valida o no existe en la tabla\r\n";
							        	$swGeneral=false;
							        	//echo 'Error! Pqr';
							        }
								//End Validar PQR

							    //Validamos el ESTADO de la orden
							        // 0 Pendiente
							        // 6 Detenida x Sistema
		                			$queryOt ="SELECT OTESTA FROM ot 
		                					   WHERE OTDEPA=$dep AND OTLOCA=$loc AND OTNUME=$num
		                					   		AND (OTESTA=0 OR OTESTA=6)";
							        $respuestaOt = $conn->prepare($queryOt) or die ($sql);
							        if(!$respuestaOt->execute()) return false;
							        if($respuestaOt->rowCount()>0){
							            $sw=1;
							        }else{//No Existe
							        	$sw=0;
							        }
							        // 1 Asignado
							        // 7 Anulada
							        $queryOt ="SELECT OTESTA FROM ot 
		                					   WHERE OTDEPA=$dep AND OTLOCA=$loc AND OTNUME=$num
		                					   		AND (OTESTA=1 OR OTESTA=7)";
							        $respuestaOt = $conn->prepare($queryOt) or die ($sql);
							        if(!$respuestaOt->execute()) return false;
							        if($respuestaOt->rowCount()>0){
							            $sw=2;
							        }else{//No Existe
							        	$sw=0;
							        }
							    //End Validamos el ESTADO de la orden

							    //Validar USUARIO
									$queryUser ="SELECT USUNOMB FROM usuarios WHERE USUCODI = $user";
							        $respuestaUser = $conn->prepare($queryUser) or die ($sql);
							        if(!$respuestaUser->execute()) return false;
							        if($respuestaUser->rowCount()>0){
							            $swUser=true;
							        }else{//No Existe
							        	$swUser=false;
							        }
							        
							        if($swUser){
							        	$queryUser ="UPDATE usuarios SET USUNOMB='$userNom', USUDIRE='$userDire', USUSEOP=$userSeOp, USUNOBA='$userSeON'
							        				 WHERE USUDEPA=$dep AND USULOCA=$loc AND USUCODI=$user";
								        $respuesta = $conn->prepare($queryUser) or die ($queryUser);
								        if(!$respuesta->execute()){
						        			$swGeneral=false;
						        			$swUserAct=false;
						        			$userActErrStr="Error al actualizar el usuario $user : $userNom \r\n";
								            //echo 'Error! Usuario';
								        }else{
								            //echo 'Se Act el Usuario <br>';
						        			$swUserAct=true;
								            $swUser=true;
								        }
							        }else{ // Crear Usuario
							        	$queryUser ="INSERT INTO usuarios (USUCODI,USUNOMB,USUDIRE,USUSEOP,USUNOBA,USUDEPA,USULOCA,USUTEL)
							        				VALUES ($user,'$userNom','$userDire',$userSeOp,'$userSeON',$dep,$loc,$userTel)";
								        $respuesta = $conn->prepare($queryUser) or die ($queryUser);
								        if(!$respuesta->execute()){
						        			$swUserIns=false;
						        			$swGeneral=false;
						        			$userInsErrStr="Error al insertar el usuario $user : $userNom";
								            //echo 'Error! ';
								        }else{
								            //echo 'Se Creo el Usuario';
						        			$swUserIns=true;
								            $swUser=true;
								        }
						        	}
								//End Validar USUARIO

						        //Actualizar tabla de ORDENES
						        	if($swPqr){
						        		if($sw==0){
							        		$queryOT ="INSERT INTO ot (OTDEPA,OTLOCA,OTNUME,OTFERECI,OTFEORD,OTESTA,OTUSUARIO,OTOBSEAS,OTPQRREPO,OTUSERCRE,OTCUAD,OTHIJA)
							        							values ($dep,$loc,$num,'".date("Y-m-d",strtotime($fecCrea))."','".date("Y-m-d",strtotime($fecOrd))."',0,$user,'$observ',$pqr,'$userCrea',1,'N')";
									        $respuesta = $conn->prepare($queryOT) or die ($queryOT);
									        if(!$respuesta->execute()){
							        			$swGeneral=false;
							        			$swOt=false;
							        			//echo "\nPDO::errorInfo():\n";
							        			//$otErrStr .= "<br>ERROR: ".$respuesta->errorInfo()[1].' - '.$respuesta->errorInfo()[2];
							        			$otErrStr .= "La OT # $dep-$loc-$num ya Existe \r\n";
    											//echo $respuesta->errorInfo()[1].'<br>'; 
    											//echo $respuesta->errorInfo()[2].'<br>'; 
    											//echo $respuesta->errorInfo()[3].'<br>'; 
									            //echo mysql_errno($queryOTE) . ": " . mysql_error($queryOTE). "\n";
									            //echo $queryOT.'<br>';
										        $contErr++;
									        }else{
									            //echo 'Se Creo la Orden';
									            $cont++;
									            $swGeneral=true;
									            $swOt=true;
									        }
						        		}else{
						        			if($sw==1){
							        			$queryUser ="UPDATE ot SET OTFEORD='".date("Y-m-d",strtotime($fecOrd))."', OTESTA=0 WHERE OTDEPA=$dep AND OTLOCA=$loc AND OTNUME=$num";
										        $respuesta = $conn->prepare($queryUser) or die ($queryUser);
										        if(!$respuesta->execute()){
								        			$swGeneral=false;
								        			$swOt=false;
								        			$otErrStr .= "Error al reasignar la OT # $dep-$loc-$num \r\n";
										            //echo 'Error! OT sw = 1';
										            //$contErr++;
										        }else{
										            $swGeneral=true;
										            $swOt=true;
										        }
						        			}else{
						        				$queryUser ="UPDATE ot SET OTFEORD='".date("Y-m-d",strtotime($fecOrd))."' WHERE OTDEPA=$dep AND OTLOCA=$loc AND OTNUME=$num";
										        $respuesta = $conn->prepare($queryUser) or die ($queryUser);
										        if(!$respuesta->execute()){
								        			$swGeneral=false;
								        			$swOt=false;
										            $otErrStr .= "Error al reasignar la OT # $dep-$loc-$num \r\n";
										            //echo 'Error! sw = 2';
										            //$contErr++;
										        }else{
										            $swGeneral=true;
										            $swOt=true;
										        }
						        			}
						        		}
						        	}

						        	if($nomPqr!=''){
						        		$queryUser ="UPDATE ot SET OTFEORD='".date("Y-m-d",strtotime($fecOrd))."', OTFEAS='".date("Y-m-d")."', OTTECN=$nomPqr,OTUSERASI=$userCrea, OTESTA=1, OTOBSERVAS='Asignada desde Atsc por exclusividad de pqr a un tecnico'
						        						WHERE OTDEPA=$dep AND OTLOCA=$loc AND OTNUME";
								        $respuesta = $conn->prepare($queryUser) or die ($queryUser);
								        if(!$respuesta->execute()){
						        			$swGeneral=false;
						        			$swOt=false;
								            //echo 'Error! OT sw = 1';
								            //$contErr++;
								        }else{
								            $swGeneral=true;
								            $swOt=true;
								        }
						        	}
						        //END actualizar tabla de ORDENES

						        //Errores
						        	if(!$swGeneral){
						        		//Obtener ruta donde se guardaran los errores
						        			$ruta="C:\"";
						        			$queryPara ="SELECT PARAVAST FROM paraconf WHERE PARACODI = 'RUTA_ATSC'";
									        $respuestaPara = $conn->prepare($queryPara) or die ($sql);
									        if(!$respuestaPara->execute()) return false;
									        if($respuestaPara->rowCount()>0){
									            while ($rowPara=$respuestaPara->fetch()){
									            	$ruta = $rowPara['PARAVAST'];                        
									            }
									        }
									    //End Ruta

									    //Obtener empresa
									        $empresa='';
						        			$queryPara ="SELECT EMPRNOM FROM empresa WHERE EMPRNIT = 1";
									        $respuestaPara = $conn->prepare($queryPara) or die ($sql);
									        if(!$respuestaPara->execute()) return false;
									        if($respuestaPara->rowCount()>0){
									            while ($rowPara=$respuestaPara->fetch()){
									            	$empresa = $rowPara['EMPRNOM'];                        
									            }
									        }
									    //End empresa
						        	}

							    //echo 'fecCrea: '.date("Y-m-d", strtotime($fecCrea)).'<br>';
	                			//echo 'sw: '.$sw.'<br>';
	                			//echo 'swSector: '.$swSector.'<br>';
	                			//echo 'swPqr: '.$swPqr.'<br>';
	                			//echo 'swUser: '.$swUser.'<br>';

	                			//echo 'swGeneral: '.$swGeneral;
	                			//echo '<br>';
	                			//echo $queryOT;
                			}//End Sw
                		}
                	}
                	//echo 'Cont: '.$cont;
                	fclose($archivo);
                //Cerramos el Archivo
			}
		}

		//Si Existe Archivo Inconsistencias
		if(isset($_FILES['fileInconsistencias']['name'])){

		}
	}

	$queryContr ="SELECT descripcion FROM contratista WHERE id = 1";
        $respuestaContr = $conn->prepare($queryContr) or die ($sql);
        if(!$respuestaContr->execute()) return false;
        if($respuestaContr->rowCount()>0){
            while ($rowContr=$respuestaContr->fetch()){
            	$nomContratista = $rowContr['descripcion'];                        
            }
        }
?>

<?php require 'template/start.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">
		<?php require 'template/menu.php'; ?>
		<div class="content-wrapper">
			<div class="container">

				<div class="modal fade" id="modalCuadrillas">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">CUADRILLAS</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12">
				                		<table id="tableCuadrill" class="table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php 
		                                            //$conn = require 'inc/clases/conexion.php';
		                                            $query ='SELECT * FROM cuadrilla ORDER BY CUADCODI';
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="colocarCuadrilla('.$row['CUADCODI'].',\''.$row['CUADNOMB'].'\')">
		                                                    		<td class="text-center" width="100">'.$row['CUADCODI'].'</td>
		                                                    		<td>'.$row['CUADNOMB'].'</td>
		                                                    	</tr>';                                   
		                                                }   
		                                            }
		                                        ?>
					                        </tbody>
					                    </table>
				                	</div>
			                	</div>
			                </div>
	                	</div><!-- /.modal-content -->
	               	</div><!-- /.modal-dialog -->
	            </div>

	            <div class="modal fade" id="modalConfArchivo">
	             	<div class="modal-dialog" style="width:60%;">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">CONFIGURACION DEL ARCHIVO</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12">
				                		<table id="tableCuadrill" class="table table-bordered table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th>DESCRIPCION</th>
					                              	<th class="text-center" width="140">CAMPO EN TABLA</th>
					                              	<th class="text-center" width="200">CAMPO EN ARCHIVO</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<tr>
					                        		<td>Codigo del departamento</td>
					                        		<th class="text-center"><i>OTDEPA</i></th>
					                        		<td class="text-center"><input type="text" class="form-control input-sm" id="txtCodDep"></td>
					                        	</tr>
					                        	<tr>
					                        		<td>Codigo de la localidad</td>
					                        		<th class="text-center"><i>OTLOCA</i></th>
					                        		<td class="text-center"><input type="text" class="form-control input-sm" id="txtCodLoc"></td>
					                        	</tr>
					                        	<tr>
					                        		<td>Codigo de orden de trabajo</td>
					                        		<th class="text-center"><i>OTNUME</i></th>
					                        		<td class="text-center"><input type="text" class="form-control input-sm" id="txtCodOrd"></td>
					                        	</tr>
					                        	<tr>
					                        		<td>Fecha de la orden</td>
					                        		<th class="text-center"><i>OTFEORD</i></th>
					                        		<td class="text-center"><input type="text" class="form-control input-sm" id="txtFecOrd"></td>
					                        	</tr>
					                        	<tr>
					                        		<td>Usuario</td>
					                        		<th class="text-center"><i>OTUSUARIO</i></th>
					                        		<td class="text-center"><input type="text" class="form-control input-sm" id="txtUsuario"></td>
					                        	</tr>
					                        	<tr>
					                        		<td>PQR Reportada</td>
					                        		<th class="text-center"><i>OTPQRREPO</i></th>
					                        		<td class="text-center"><input type="text" class="form-control input-sm" id="txtPqrReport"></td>
					                        	</tr>
					                        	<tr>
					                        		<td>Observacion de la Orden</td>
					                        		<th class="text-center"><i>OTOBSEAS</i></th>
					                        		<td class="text-center"><input type="text" class="form-control input-sm" id="txtObservacion"></td>
					                        	</tr>
					                        </tbody>
					                    </table>
				                	</div>
			                	</div>
			                </div>
			                <div class="modal-footer">
			                	<a class="btn btn-primary" onclick="guardarDatos()">Guardar Cambios</a>
			                </div>
	                	</div><!-- /.modal-content -->
	               	</div><!-- /.modal-dialog -->
	            </div>

				<section class="content-header">
	             	<?php include 'template/sub_menu.php' ?>
					<!--
						<a id="btnConfg" onclick="" class="btn btn-info btn-xs" data-toggle="tooltip" data-original-title="Configuracion de Archivo"><i class="fa fa-cogs"></i></a>
					-->
					<a id="brnCargar" onclick="" class="btn btn-success btn-xs" data-toggle="tooltip" data-original-title="Cargar Archivos"><i class="fa fa-hdd-o"></i></a>
	            	<ol class="breadcrumb">
	                	<li><a href="#">Ordenes</a></li>
	                	<li class="active">Cargar Ordenes Asignadas</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<form action="peatsc.php" method="POST" id="formCargarArchivos" enctype="multipart/form-data">
								<div class="box">
									<div class="box-header">
				                     	<h3 class="box-title">Cargar Archivos Planos</h3>
				                    </div><!-- /.box-header -->
				                    <div class="box-body">
				                    	<div class="row">
						                	<div class="form-group">
						                		<div class="col-sm-1"></div>
						                     	<label for="txtCodCuad" class="col-sm-2 control-label text-right" style="margin-top:5px;">Cuadrilla</label>
						                     	<div class="col-sm-1">
					                        		<input type="text" class="form-control input-sm" id="txtCodCuad" name="txtCodCuad" placeholder="Codigo" onkeypress="solonumeros()" <?php echo 'value="1"' ?> readonly>
					                        		<input type="hidden" name="txtUsuarioCrea" <?php echo 'value="'.$_SESSION['user'].'"' ?> readonly>
					                      		</div>
					                      		<div class="col-sm-6">
					                        		<input type="text" class="form-control input-sm" id="txtNomCuad" placeholder="Nombre del Cuadrilla" readonly <?php echo 'value="'.$nomContratista.'"' ?>>
					                      		</div>
						                    </div>
					                	</div>

					                    <div class="row marginTop8">
						                	<div class="form-group">
						                		<div class="col-sm-1"></div>
						                     	<label for="fileAsignaciones" class="col-sm-2 control-label text-right" style="margin-top:5px;">Archivo Asignaciones</label>
					                      		<div class="col-sm-8" style="margin-top: 5px;">
					                        		<input type="file" id="fileAsignaciones" name="fileAsignaciones">  
					                      		</div>
						                    </div>
					                	</div>

					                	<div class="row marginTop8">
						                	<div class="form-group">
						                		<div class="col-sm-1"></div>
						                     	<label for="fileInconsistencias" class="col-sm-2 control-label text-right" style="margin-top:5px;">Archivo Inconsistencias</label>
					                      		<div class="col-sm-8" style="margin-top: 5px;">
					                        		<input type="file" id="fileInconsistencias" name="fileInconsistencias">  
					                      		</div>
						                    </div>
					                	</div>

					                	<div class="row marginTop8">
						                	<div class="form-group">
						                		<div class="col-sm-1"></div>
						                     	<label class="col-sm-2 control-label text-right" style="margin-top:5px;">Registros Procesados</label>
					                      		<div class="col-sm-1" style="margin-top: 5px;">
					                        		<input id="txtRegProcesados" type="text" class="form-control input-sm text-right" <?php echo 'value="'.$cont.'"'; ?> style="color: blue;" readonly>
					                      		</div>
						                    </div>
					                	</div>

										<?php if( (isset($_REQUEST["txtCodCuad"])) && ($cont>0) ){ ?>
											<br>
						                	<div class="row text-center">
						                		<div class="col-sm-3"></div>
						                		<div class="col-sm-6">
							                		<div class="alert alert-success alert-dismissable">
									                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									                    <h4>	<i class="icon fa fa-check"></i> Exito!</h4>
									                    Proceso Terminado satisfactoriamente, cargadas <?php echo $cont ?> ordenes
									                </div>
						                		</div>
						                	</div>
						                <?php } ?>

						                <?php if( (isset($_REQUEST["txtCodCuad"])) && ($contErr>0) ){ ?>
											<br>
						                	<div class="row text-center">
						                		<div class="col-sm-3"></div>
						                		<div class="col-sm-6">
							                		<div class="alert alert-danger alert-dismissable">
									                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									                    <h4><i class="icon fa fa-check"></i> Error!</h4>
									                    Proceso con Errores, Revise el archivo de inconsistencia<br>
														<?php 
															/*
																if(!$swSectorIns){
																	echo 'Error al insertar el SECTOR OPERATIVO.<br>';
																}
																if(!$swPqr){
																	echo 'Error el PQR no existe.<br>';
																}
																if(!$swUserIns){
																	echo 'Error al insertar el USUARIO.<br>';
																}
																if(!$swOt){
																	echo $otErrStr;
																}
															*/
															//Creamos el archivo de inconsistencia
															//echo $otErrStr;
															$ruta .="Error".date('(Y-m-d H_i_s)').".txt";
															$fechaAct = date('Y-m-d h:i:s a');
															//$arcRec = ;
															$archivo = fopen($ruta,"a") or die('Error');
															$encabezado="EMPRESA          : $empresa \r\nFECHA            : $fechaAct \r\nARCHIVO RECIBIDO : $nameEXCEL \r\n------------------------- INCONSISTENCIAS ATSC ---------------------\r\n";
															fwrite($archivo, $encabezado);
															if(!$swSectorIns){

																fwrite($archivo, $sectorErrStr);
															}
															if(!$swPqr){
																
																fwrite($archivo, $pqrErrStr);
															}
															if(!$swUserAct){

																fwrite($archivo, $userActErrStr);
															}
															if(!$swUserIns){

																fwrite($archivo, $userInsErrStr);
															}
															if(!$swOt){

																	
																fwrite($archivo, $otErrStr);
															}
														?>
														<small>en la ruta <?php echo $ruta; ?></small>
									                </div>
						                		</div>
						                	</div>
						                <?php } ?>
				                    </div>
								</div>
							</form>
						</div>
					</div>
				</section>

			</div>
		</div>
		<?php require 'template/footer.php'; ?>
	</div>
</body>
<?php require 'template/end.php'; ?>
<script src="js/peatsc.js"></script>