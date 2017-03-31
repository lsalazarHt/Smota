<?php require 'template/start.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">
		<?php require 'template/menu.php'; ?>
		<div class="content-wrapper">
			<div class="container">
				
				<div class="modal fade" id="modalDepartamentos">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">DEPARTAMENTO</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12">
				                		<table id="tableCuadrill" class="tableJs table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php 
		                                            //$conn = require 'inc/clases/conexion.php';
		                                            $query ='SELECT * FROM departam ORDER BY DEPACODI';
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="buscarCuadrilla('.$row['DEPACODI'].')">
		                                                    		<td class="text-center" width="100">'.$row['DEPACODI'].'</td>
		                                                    		<td>'.$row['DEPADESC'].'</td>
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
	            <div class="modal fade" id="modalLocalidades">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">CUADRILLAS</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12">
				                		<table id="tableCuadrill" class="tableJs table table-bordered table-hover table-condensed">
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
		                                                    	'<tr onclick="buscarCuadrilla('.$row['CUADCODI'].')">
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
	            <div class="modal fade" id="modalOrdenes">
	             	<div class="modal-dialog" style="width:55%;">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">ORDENES</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12" style="height: 398px; overflow-y: scroll;">
				                		<table id="tableOrdenes" class="table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="120">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody id="divTableOrdenes">
					                        	<?php 
		                                            //$conn = require 'inc/clases/conexion.php';
		                                            $query ='SELECT ot.* , usuarios.USUNOMB
															 FROM ot
																INNER JOIN usuarios ON  ot.OTUSUARIO = usuarios.USUCODI
															 WHERE OTESTA = 1															
														 	 ';
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="buscarOrden('.$row['OTDEPA'].','.$row['OTLOCA'].','.$row['OTNUME'].')">
		                                                    		<td class="text-center" width="100">'.$row['OTDEPA'].'-'.$row['OTLOCA'].'-'.$row['OTNUME'].'</td>
		                                                    		<td>'.$row['USUNOMB'].'</td>
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
	            <div class="modal fade" id="modalPqr">
	             	<div class="modal-dialog" style="width:70%;">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">PQR ENCONTRADO</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12" style="height: 398px; overflow-y: scroll;">
				                		<table id="tableDepa" class="table table-bordered table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody id="tablaDivPqr">
					                        	
					                        </tbody>
					                    </table>
				                	</div>
			                	</div>
			                </div>
	                	</div><!-- /.modal-content -->
	               	</div><!-- /.modal-dialog -->
	            </div>
	            <div class="modal fade" id="modalManoObra">
	             	<div class="modal-dialog" style="width:70%;">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">MANO DE OBRA</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12" style="height: 398px; overflow-y: scroll;">
				                		<table class="table table-bordered table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody id="tablaDivManoObra">
					                        	
					                        </tbody>
					                    </table>
				                	</div>
			                	</div>
			                </div>
	                	</div><!-- /.modal-content -->
	               	</div><!-- /.modal-dialog -->
	            </div>
	            <div class="modal fade" id="modalMaterial">
	             	<div class="modal-dialog" style="width:70%;">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">MATERIALES</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12" style="height: 398px; overflow-y: scroll;">
				                		<table id="" class=" table table-bordered table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                              	<th class="text-right">CANT MAX LEG</th>
					                              	<th class="text-right">CANT DISPONIBLE</th>
					                              	<th class="text-right">VALOR UNID</th>
					                            </tr>
					                        </thead>
					                        <tbody id="tablaDivMateriales">
					                        	
					                        </tbody>
					                    </table>
				                	</div>
			                	</div>
			                </div>
	                	</div><!-- /.modal-content -->
	               	</div><!-- /.modal-dialog -->
	            </div>

	            <div class="modal fade" id="modalOrdenes">
	             	<div class="modal-dialog" style="width:55%;">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">ORDENES</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12">
				                		<table id="tableOrdenes" class="tableJs table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="120">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php 
		                                            //$conn = require 'inc/clases/conexion.php';
		                                            $query ='SELECT ot.* , usuarios.USUNOMB
															 FROM ot
																INNER JOIN usuarios ON  ot.OTUSUARIO = usuarios.USUCODI
															 WHERE OTESTA = 1															
														 	 ';
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="buscarOrden('.$row['OTDEPA'].','.$row['OTLOCA'].','.$row['OTNUME'].')">
		                                                    		<td class="text-center" width="100">'.$row['OTDEPA'].'-'.$row['OTLOCA'].'-'.$row['OTNUME'].'</td>
		                                                    		<td>'.$row['USUNOMB'].'</td>
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

				<section class="content-header">
	             	<?php include 'template/sub_menu.php' ?> 
					<!--
					<a id="btnSalida" onclick="enviarOrden()" class="btn btn-info btn-xs" data-toggle="tooltip" data-original-title="Salir"><i class="fa fa-sign-out"></i></a>
	            	-->
	            	<ol class="breadcrumb">
	                	<li><a href="#">Ordenes</a></li>
	                	<li class="active">Legalizacion Individual</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Orden de Trabajo a Legalizar</h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body">
			                    	<input type="hidden" id="swEstadoPqr" value="0" readonly>
			                   	 	<div id="divConsultarPqrs" class="display-none"></div>
			                    	<div class="row">
					                	<div class="form-group">
					                     	<div class="col-sm-12">
					                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Orden</label>
				                        		<input id="txtDepOrd" type="text" class="form-control input-sm" style="margin-left: 8px; width:50px; float: left;">
				                        		<input id="txtLocaOrd" type="text" class="form-control input-sm" style="width:50px; float: left; margin-left: 8px;">
				                        		<input id="txtNumbOrd" type="text" class="form-control input-sm" style="width:155px; float: left; margin-left: 10px;">
					                     		
					                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Tecnico</label>
				                        		<input id="txtCodTecn" type="text" class="form-control input-sm" readonly style="width:100px; float: left; margin-left: 8px;">
				                        		<input id="txtNomTecn" type="text" class="form-control input-sm" readonly style="width:480px; float: left; margin-left: 10px;">
				                      			<div id="divEstOrd" class="display-none">
				                      				<input type="checkbox" style="margin-left: 20px; margin-top:10px;"><label style="margin-left: 10px; color:red;">Cumplida</label>
				                      			</div>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop5">
					                	<div class="form-group">
					                     	<div class="col-sm-12 ">
					                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Fecha Recibido</label>
				                        		<input id="txtFechaRecib" type="text" class="form-control input-sm" readonly style="margin-left: 8px; width:95px; float: left;">
				                      			
				                      			<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:90px; float:left;">Fecha Orden</label>
				                        		<input id="txtFechaOrd" type="text" class="form-control input-sm" readonly style="margin-left: 8px; width:80px; float: left;">
				                        		
				                        		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:140px; float:left;">Fecha Cumplimiento</label>
				                        		<input id="txtFechaCumpl" type="date" class="form-control input-sm" style="margin-left: 8px; width:130px; float: left;">
				                        		
												<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:120px; float:left;">Fecha Asignacion</label>
				                        		<input id="txtFechaAsig" type="text" class="form-control input-sm" readonly style="margin-left: 8px; width:80px; float: left;">
				                      			
				                      			<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:125px; float:left;">Fecha Legalizacion</label>
				                        		<input id="txtFechaLega" type="text" class="form-control input-sm" readonly style="margin-left: 8px; width:80px; float: left;">
				                      		</div>
					                    </div>
				                	</div>
				                    <div class="row marginTop5">
					                	<div class="form-group">
					                     	<div class="col-sm-12 ">
					                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">PQR Reportada</label>
				                        		<input id="txtPqrCodRep" type="text" class="form-control input-sm" readonly style="width:50px; float: left; margin-left: 8px;">
				                        		<input id="txtPqrNombRep" type="text" class="form-control input-sm" readonly style="width:350px; float: left; margin-left: 10px;">
				                      			
												<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:130px; float:left;">PQR Encontrada</label>
				                        		<input id="txtPqrCodEnc" type="text" class="form-control input-sm" style="width:50px; float: left; margin-left: 8px;">
				                        		<input id="txtPqrNombEnc" type="text" class="form-control input-sm" readonly style="width:365px; float: left; margin-left: 10px;">
				                        		<input id="txtPqrMatFijo" type="hidden">
				                        		<input id="txtPqrMatFijoCont" type="hidden">
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop5">
					                	<div class="form-group">
					                     	<div class="col-sm-12 ">
					                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Usuario</label>
				                        		<input id="txtCodUser" type="text" class="form-control input-sm" readonly style="width:50px; float: left; margin-left: 8px;">
				                        		<input id="txtNomUser" type="text" class="form-control input-sm" readonly style="width:350px; float: left; margin-left: 10px;">
				                      			
												<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:130px; float:left;">Estado</label>
				                        		<input id="txtCodEst" type="text" class="form-control input-sm" readonly style="width:50px; float: left; margin-left: 8px;">
				                        		<input id="txtNomEst" type="text" class="form-control input-sm" readonly style="width:365px; float: left; margin-left: 10px;">
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop5">
				                		<div class="form-group">
					                     	<div class="col-sm-12 ">
					                     		<label for="txtHoraInicio" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Hora Inicial</label>
				                        		<input id="txtHoraInicial" type="time" class="form-control input-sm" style="width:100px; float: left; margin-left: 8px;">
				                      			
												<label for="txtHoraInicio" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Hora Final</label>
				                        		<input id="txtHoraFinal" type="time" class="form-control input-sm" style="width:100px; float: left; margin-left: 8px;">
				                      			
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop5">
					                	<div class="form-group">
					                     	<div class="col-sm-12 ">
					                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Observacion en la Legalizacion</label>
					                     		<textarea id="txtObservacion" class="form-control input-sm" style="float: left; margin-left: 8px; width:660px;" rows="4" onclick="editor('txtObservacion')"></textarea>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop5">
					                	<div class="form-group">
					                     	<div class="col-sm-12 ">
					                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Asignador</label>
				                        		<input id="txtAsignador" type="text" readonly class="form-control input-sm" style="width:150px; float: left; margin-left: 8px;">
				                      			
												<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Recibidor</label>
				                        		<input id="txtRecibidor" type="text" readonly class="form-control input-sm" style="width:150px; float: left; margin-left: 8px;">

				                        		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Legalizador</label>
				                        		<input id="txtLegalizador" type="text" class="form-control input-sm" style="width:150px; float: left; margin-left: 8px;" readonly value="<?php echo $_SESSION['user']; ?>">
				                      		</div>
					                    </div>
				                	</div>
				                	<br>
				                	<div class="row marginTop3">
				                		<div class="col-md-6">
						                	<fieldset>
						                		<legend>
													<a class="" data-toggle="tooltip" data-original-title="Agregar" id="addManoObra"><i class="fa fa-plus"></i></a> 
													<a class="text-red" data-toggle="tooltip" data-original-title="Quitar" id="removeManoObra"><i class="fa fa-minus"></i></a> 
													Mano de Obra
												</legend>
						                		<div style="height: 250px; overflow-y: scroll;">
							                		<input type="hidden" id="contRowMano">
							                		<table id="tableManoObra" class="table table-bordered table-condensed">
							                			<tr style="background-color: #3c8dbc; color:white;">
							                				<td class="text-center" width="80">Codigo</td>
							                				<td >Mano de Obra</td>
							                				<td class="text-right" width="70">Cantidad</td>
							                				<td class="text-right" width="100">Valor</td>
							                			</tr>
							                		</table>
						                		</div>
						                	</fieldset>
				                		</div>
				                		<div class="col-md-6">
						                	<fieldset>
						                		<legend>
													<a class="" data-toggle="tooltip" data-original-title="Agregar" id="addMateriales"><i class="fa fa-plus"></i></a>
													<a class="text-red" data-toggle="tooltip" data-original-title="Quitar" id="removedMateriales"><i class="fa fa-minus"></i></a> 
													Materiales
												</legend>
														
												<div style="height: 250px; overflow-y: scroll;">
							                		<input type="hidden" id="contRowMate">
							                		<table id="tableMateriales" class="table table-bordered table-condensed">
							                			<tr style="background-color: #3c8dbc; color:white;">
							                				<td class="text-center" width="80">Codigo</td>
							                				<td >Materiales</td>
							                				<td class="text-right" width="70">Cantidad</td>
							                				<td class="text-right" width="100">Valor</td>
							                			</tr>
							                		</table>
						                		</div>
						                	</fieldset>
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
<script src="js/legord.js"></script>