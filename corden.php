<?php
	if(!isset($_REQUEST["txtIdUsuarioPost"])){
		//header('Location: cusu.php');
	}
	/*$_REQUEST["txtIdUsuarioPost"] = 0;
	$usuarioCodigo = $_REQUEST["txtIdUsuarioPost"];
	$conn = require 'template/sql/conexion.php';
	*/
?>
<!--  Material Dashboard CSS -->
<link href="assets/css/material-dashboard.css" rel="stylesheet"/>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
<?php require 'template/start.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">
		<?php require 'template/menu.php'; ?>
		<div class="content-wrapper">
			<div class="container">
				
				<div class="modal fade" id="modarOrdenes">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">ORDENES</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12">
				                		<table id="tableDepa" class="table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php 
		                                            //$conn = require 'inc/clases/conexion.php';
		                                           /* $query ="SELECT * FROM tecnico WHERE TECNESTA='A' ORDER BY TECNNOMB";
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="agregarTecnico(\''.$row['TECNCODI'].'\',\''.$row['TECNNOMB'].'\')">
		                                                    		<td class="text-center">'.$row['TECNCODI'].'</td>
		                                                    		<td>'.$row['TECNNOMB'].'</td>
		                                                    	</tr>';                                   
		                                                }   
		                                            }*/
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
	            	<ol class="breadcrumb">
	                	<li><a href="#">Ordenes</a></li>
	                	<li><a href="#">Consultas</a></li>
	                	<li class="active">Ordenes</li>
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
				                        		<input type="text" id="txtCodDep" class="form-control input-sm e e1 key" style="margin-left: 8px; width:50px; float: left;" onkeypress="solonumeros()">
				                        		<input type="text" id="txtCodLoc" class="form-control input-sm e e2" style="width:50px; float: left; margin-left: 8px;" onkeypress="solonumeros()">
				                        		<input type="text" id="txtCodNum" class="form-control input-sm e e3 key" style="width:130px; float: left; margin-left: 10px;" onkeypress="solonumeros()">
					                     		
					                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Tecnico</label>
				                        		<input type="text" id="txtCodTec" class="form-control input-sm" readonly style="width:100px; float: left; margin-left: 8px;">
				                        		<input type="text" id="txtNomTec" class="form-control input-sm" readonly style="width:300px; float: left; margin-left: 10px;">
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop5">
					                	<div class="form-group">
					                     	<div class="col-sm-12 ">
					                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Fecha Recibido</label>
				                        		<input type="text" id="txtFecRec" class="form-control input-sm" readonly style="margin-left: 8px; width:100px; float: left;">
				                      			
				                      			<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:90px; float:left;">Fecha Orden</label>
				                        		<input type="text" id="txtFecOrd" class="form-control input-sm" readonly style="margin-left: 8px; width:85px; float: left;">
				                        		
				                        		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:140px; float:left;">Fecha Cumplimiento</label>
				                        		<input type="text" id="txtFecCum" class="form-control input-sm" readonly style="margin-left: 8px; width:90px; float: left;">
				                        		
												<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:120px; float:left;">Fecha Asignacion</label>
				                        		<input type="text" id="txtFecAsi" class="form-control input-sm" readonly style="margin-left: 8px; width:95px; float: left;">
				                      			
				                      			<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:125px; float:left;">Fecha Legalizacion</label>
				                        		<input type="text" id="txtFecLeg" class="form-control input-sm" readonly style="margin-left: 8px; width:95px; float: left;">
				                      		</div>
					                    </div>
				                	</div>
				                    <div class="row marginTop5">
					                	<div class="form-group">
					                     	<div class="col-sm-12 ">
					                     		<label for="txtPqrRep" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">PQR Reportada</label>
				                        		<input type="text" id="txtPqrRep" class="form-control input-sm" readonly style="width:50px; float: left; margin-left: 8px;">
				                        		<input type="text" id="txtPqrRepNom" class="form-control input-sm" readonly style="width:350px; float: left; margin-left: 10px;">
				                      			
												<label for="txtPqrEnc" class="control-label text-right" style="margin-top:5px; width:130px; float:left;">PQR Encontrada</label>
				                        		<input type="text" id="txtPqrEnc" class="form-control input-sm" readonly style="width:50px; float: left; margin-left: 8px;">
				                        		<input type="text" id="txtPqrEncNom" class="form-control input-sm" readonly style="width:365px; float: left; margin-left: 10px;">
				                      			
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop5">
					                	<div class="form-group">
					                     	<div class="col-sm-12 ">
					                     		<label for="txtCausaAten" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Causa Atencion</label>
				                        		<input type="text" id="txtCausaAten" class="form-control input-sm" readonly style="width:100px; float: left; margin-left: 8px;">
				                        		<input type="text" id="txtCausaAtenNom" class="form-control input-sm" readonly style="width:300px; float: left; margin-left: 10px;">
				                      			
												<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:130px; float:left;">Causa no Atencion</label>
				                        		<input type="text" id="txtCausaNoAten" class="form-control input-sm" readonly style="width:100px; float: left; margin-left: 8px;">
				                        		<input type="text" id="txtCausaNoAtenNom" class="form-control input-sm" readonly style="width:316px; float: left; margin-left: 10px;">
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop5">
					                	<div class="form-group">
					                     	<div class="col-sm-12 ">
					                     		<label for="txtUsua" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Usuario</label>
				                        		<input type="text" id="txtUsua" class="form-control input-sm" readonly style="width:100px; float: left; margin-left: 8px;">
				                        		<input type="text" id="txtUsuaNomb" class="form-control input-sm" readonly style="width:300px; float: left; margin-left: 10px;">
				                      			
												<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:130px; float:left;">Recibidor</label>
				                        		<input type="text" id="txtRecibi" class="form-control input-sm" readonly style="width:200px; float: left; margin-left: 10px;">
												
												<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:140px; float:left;">Metodo de Corte</label>
				                        		<div id="txtMetCort">
				                        			<input type="checkbox" style="float: left; margin-left: 10px; margin-top: 10px;">
				                        		</div>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop5">
					                	<div class="form-group">
					                     	<div class="col-sm-12 ">
					                     		<label for="txtUsuaDire" class="control-label text-right" style="margin-top:5px; width:100px; float:left;"></label>
				                        		<input type="text" id="txtUsuaDire" class="form-control input-sm" readonly style="width:410px; float: left; margin-left: 8px;">
				                      			
												<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:70px; float:left;">Asignador</label>
				                        		<input type="text" id="txtAsigna" class="form-control input-sm" readonly style="width:197px; float: left; margin-left: 10px;">
												
												<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:80px; float:left;">Legalizador</label>
				                        		<input type="text" id="txtLegali" class="form-control input-sm" readonly style="width:197px; float: left; margin-left: 10px;">
				                      		</div>
					                    </div>
				                	</div>
									<div class="row marginTop5">
					                	<div class="form-group">
					                     	<div class="col-sm-12 ">
					                     		<label for="txtUsuMedid" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Medidor</label>
				                        		<input type="text" id="txtUsuMedid" class="form-control input-sm" readonly style="width:200px; float: left; margin-left: 8px;">
				                      			
												<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:80px; float:left;">Lectura</label>
				                        		<input type="text" id="txtLect" class="form-control input-sm" readonly style="width:200px; float: left; margin-left: 10px;">
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop5">
					                	<div class="form-group">
					                     	<div class="col-sm-12 ">
					                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Causa Lectura</label>
				                        		<input type="text" id="txtLectCausa" class="form-control input-sm" readonly style="width:100px; float: left; margin-left: 8px;">
				                      			
												<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:140px; float:left;">Observacion Lectura</label>
				                        		<input type="text" id="txtLectObsj" class="form-control input-sm" readonly style="width:150px; float: left; margin-left: 10px;">

				                        		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:50px; float:left;">Estado</label>
				                        		<input type="text" id="txtEst" class="form-control input-sm" readonly style="width:40px; float: left; margin-left: 10px;">
				                        		<input type="text" id="txtEstNom" class="form-control input-sm" readonly style="width:130px; float: left; margin-left: 10px;">

				                        		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:80px; float:left;">Hora Inicial</label>
				                        		<input type="text" id="txtHoraIni" class="form-control input-sm" readonly style="width:80px; float: left; margin-left: 10px;">
				                        		
				                        		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:70px; float:left;">Hora Final</label>
				                        		<input type="text" id="txtHoraFin" class="form-control input-sm" readonly style="width:80px; float: left; margin-left: 10px;">
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
						                        		<textarea id="txtObservOrd" class="form-control input-sm" rows="6" readonly style="width:325px; float: left; margin-left: 8px;"></textarea>
					                     			</div>
					                     		</div>
					                     		<div class="row marginTop5">
					                     			<div class="col-sm-12">
							                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Observacion de la Asignacion</label>
						                        		<textarea id="txtObservAsig" class="form-control input-sm" rows="6" readonly style="width:325px; float: left; margin-left: 8px;"></textarea>
					                     			</div>
					                     		</div>
					                     		<div class="row marginTop5">
					                     			<div class="col-sm-12">
							                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Observacion de la Legalizacion</label>
						                        		<textarea id="txtObservLeg" class="form-control input-sm" rows="6" readonly style="width:325px; float: left; margin-left: 8px;"></textarea>
					                     			</div>
					                     		</div>
					                     		<div class="row marginTop5">
					                     			<div class="col-sm-12">
							                     		<label for="txtCod" class="control-label text-right" style="margin-top:5px; width:100px; float:left;">Observacion de la Certificacion</label>
						                        		<textarea id="txtObservCet" class="form-control input-sm" rows="6" readonly style="width:325px; float: left; margin-left: 8px;"></textarea>
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
											                        <tbody id="divManoObra"></tbody>
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
											                        <tbody id="divMaterial"></tbody>
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
				
			</div>
		</div>
		<?php require 'template/footer.php'; ?>
	</div>
</body>
<?php require 'template/end.php'; ?>
<script src="js/corden.js"></script>
<!--  Detectar cambios en las Formas    -->
<script src="assets/js/detectaCambiosEnFormas.js"></script>
<!--  Seleccionar nuevo Item Talas    -->
<script src="assets/js/selectedNewRow.js"></script>
<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>
<!--  TAB ENTER    -->
<script src="assets/js/tabEnter.js"></script>