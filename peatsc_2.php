<?php 
	ini_set('upload_max_filesize', '100M');
	ini_set('post_max_size', '100M');
	ini_set('max_execution_time', 3600);

	$cont=0;
	$codCuadrilla='';
	$nomCuadrilla='';
	//Si Existe Codigo de Cuadrilla
	if(isset($_REQUEST["txtCodCuad"])){
		$conn = require 'template/sql/conexion.php';
		//Cargar Configuracion de campos en archivo
			$camposArchivo;
			$query ="SELECT * FROM configarchivo WHERE ID = 1";
	        $respuesta = $conn->prepare($query) or die ($sql);
	        if(!$respuesta->execute()) return false;
	        if($respuesta->rowCount()>0){
	            while ($row=$respuesta->fetch()){
	            	$camposArchivoBd[1] = $row['OTDEPA'];
	            	$camposArchivoBd[2] = $row['OTLOCA'];
	            	$camposArchivoBd[3] = $row['OTNUME'];
	            	$camposArchivoBd[4] = $row['OTFEORD'];
	            	$camposArchivoBd[5] = $row['OTUSUARIO'];
	            	$camposArchivoBd[6] = $row['OTPQRREPO'];
	            	$camposArchivoBd[7] = $row['OTOBSEAS'];
	          	}
			}
		// END Cargar Configuracion

		// Obtener Cuadrilla
			$queryCuad = "SELECT CUADNOMB FROM cuadrilla WHERE CUADCODI = ".$_REQUEST["txtCodCuad"];
	        $respuestaCuad = $conn->prepare($queryCuad) or die ($sql);
	        if(!$respuestaCuad->execute()) return false;
	        if($respuestaCuad->rowCount()>0){
	            while ($rowCuad=$respuestaCuad->fetch()){
	            	$codCuadrilla = $_REQUEST["txtCodCuad"];
	            	$nomCuadrilla = $rowCuad['CUADNOMB'];
	          	}
			}
		// END Obtener Cuadrilla

		//Si Existe Archivo Asignaciones
		if(isset($_FILES['fileAsignaciones']['name'])){
			if($_FILES['fileAsignaciones']['name']!=''){

				$camposArchivoAsign;
				$nameEXCEL = $_FILES['fileAsignaciones']['name'];
                $tmpEXCEL = $_FILES['fileAsignaciones']['tmp_name'];
                $extEXCEL = pathinfo($nameEXCEL);
                $urlnueva = "lib/xls/ordenesAsignaciones.xls";
				
                if(is_uploaded_file($tmpEXCEL)){

                    copy($tmpEXCEL,$urlnueva);  
                }

                require_once 'lib/PHPExcel/Classes/PHPExcel/IOFactory.php';
                $objPHPExcel = PHPExcel_IOFactory::load('lib/xls/ordenesAsignaciones.xls');
                $objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true,true,true,true,true,true,true,true,true);
                
                //Contar
                	$cont=0;
                //End Contar

               	//echo $camposArchivoBd[7];
                echo '<table>';
               	$sw = false;
                foreach ($objHoja as $iIndice=>$objCelda){
                	if(!$sw){ // TITULO
	                	//- Validar Campos
	                		for($j=1;$j<=count($camposArchivoBd);$j++){

	                			if( $camposArchivoBd[$j] == $objCelda['A'] ){
	                				$camposArchivoAsign[$j] = 'A';
	                			}
	                			if( $camposArchivoBd[$j] == $objCelda['B'] ){
	                				$camposArchivoAsign[$j] = 'B';
	                			}
	                			if( $camposArchivoBd[$j] == $objCelda['C'] ){
	                				$camposArchivoAsign[$j] = 'C';
	                			}
	                			if( $camposArchivoBd[$j] == $objCelda['D'] ){
	                				$camposArchivoAsign[$j] = 'D';
	                			}
	                			if( $camposArchivoBd[$j] == $objCelda['E'] ){
	                				$camposArchivoAsign[$j] = 'E';
	                			}
	                			if( $camposArchivoBd[$j] == $objCelda['F'] ){
	                				$camposArchivoAsign[$j] = 'F';
	                			}
	                			if( $camposArchivoBd[$j] == $objCelda['G'] ){
	                				$camposArchivoAsign[$j] = 'G';
	                			}
	                		}
	                	//- End Validar Campos
	                	$sw = true;
	                	/*echo '<tr>';
		                	echo '<td>'.$objCelda[$camposArchivoAsign[1]].'</td>';
		                	echo '<td>'.$objCelda[$camposArchivoAsign[2]].'</td>';
		                	echo '<td>'.$objCelda[$camposArchivoAsign[3]].'</td>';
		                	echo '<td>'.$objCelda[$camposArchivoAsign[4]].'</td>';
		                	echo '<td>'.$objCelda[$camposArchivoAsign[5]].'</td>';
		                	echo '<td>'.$objCelda[$camposArchivoAsign[6]].'</td>';
		                	echo '<td>'.$objCelda[$camposArchivoAsign[7]].'</td>';
	                	echo '</tr>';*/
                	}else{ //CUERPO
                		if( ($objCelda['A']!='') && ($objCelda['B']!='') &&  ($objCelda['C']!='') && 
                			 ($objCelda['D']!='') && ($objCelda['E']!='') && ($objCelda['F']!='') && 
                			 ($objCelda['G']!='') ){

                			$fec = explode('-',$objCelda[$camposArchivoAsign[4]]);
						     $mes = $fec[0];
						     $dia = $fec[1];
						     $ano = $fec[2];

                			//Guardar en la base de datos
                				$queryInsert = "INSERT INTO ot (OTDEPA,OTLOCA,OTNUME,OTFEORD,OTUSUARIO,OTPQRREPO,OTOBSEAS,OTCUAD,OTESTA) 
                								VALUES (".$objCelda[$camposArchivoAsign[1]].",".$objCelda[$camposArchivoAsign[2]].",
                										".$objCelda[$camposArchivoAsign[3]].",'20".$ano.'-'.$mes.'-'.$dia."',
                										".$objCelda[$camposArchivoAsign[5]].",".$objCelda[$camposArchivoAsign[6]].",
                										'".$objCelda[$camposArchivoAsign[7]]."',".$_REQUEST["txtCodCuad"].",0)";

						        $respuestaInsert = $conn->prepare($queryInsert) or die ($queryInsert);
						        if(!$respuestaInsert->execute()){
						            echo 'Error! Al Insertar Orden '.$objCelda[$camposArchivoAsign[1]].'-'.$objCelda[$camposArchivoAsign[2]].'-'.$objCelda[$camposArchivoAsign[3]].'<br>';
						        }else{
						            //echo 1;
						        }
                			//END Guardar en la base de datos
	                		/*echo '<tr>';
			                	echo '<td style="border: solid;">'.$objCelda[$camposArchivoAsign[1]].'</td>';
			                	echo '<td style="border: solid;">'.$objCelda[$camposArchivoAsign[2]].'</td>';
			                	echo '<td style="border: solid;">'.$objCelda[$camposArchivoAsign[3]].'</td>';
			                	echo '<td style="border: solid;">20'.$ano.'-'.$mes.'-'.$dia.'**</td>';
			                	echo '<td style="border: solid;">'.$objCelda[$camposArchivoAsign[5]].'</td>';
			                	echo '<td style="border: solid;">'.$objCelda[$camposArchivoAsign[6]].'</td>';
			                	echo '<td style="border: solid;">'.$objCelda[$camposArchivoAsign[7]].'</td>';
		                	echo '</tr>';*/
		                	$cont++;
                		}
                	}
                }
                echo '</table>';
			}
		}

		//Si Existe Archivo Inconsistencias
		if(isset($_FILES['fileInconsistencias']['name'])){

		}
	}

	$conn = require 'template/sql/conexion.php';
	$query ="SELECT descripcion FROM contratista WHERE id = 1";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
            	$nomContratista = $row['descripcion'];                        
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
					<a id="btnConfg" onclick="" class="btn btn-info btn-xs" data-toggle="tooltip" data-original-title="Configuracion de Archivo"><i class="fa fa-cogs"></i></a>
					<a id="brnCargar" onclick="" class="btn btn-success btn-xs" data-toggle="tooltip" data-original-title="Cargar Archivos"><i class="fa fa-hdd-o"></i></a>
	            	<ol class="breadcrumb">
	                	<li><a href="#">Ordenes</a></li>
	                	<li class="active">Cargar Ordenes Asignadas</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<form action="peatsc_2.php" method="POST" id="formCargarArchivos" enctype="multipart/form-data">
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