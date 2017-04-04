<?php require 'template/start.php'; ?>
<?php 
	date_default_timezone_set('America/Bogota');
?>
<!--  Material Dashboard CSS    -->
<link href="assets/css/material-dashboard.css" rel="stylesheet"/>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">
		<?php require 'template/menu.php'; ?>
		<div class="content-wrapper">
			<div class="container">

	            <div class="modal fade" id="modalActas">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">ACTAS</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12" style="height: 350px; overflow-y: scroll;">
				                		<table id="tableDepa" class="tableJs table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">TECNICO</th>
					                              	<th width="120" class="text-right">VALOR NETO</th>
					                              	<th width="120" class="text-center">FECHA</th>
					                            </tr>
					                        </thead>
					                        <tbody id="tbodyActas">
					                        	<?php 
		                                            //$conn = require 'inc/clases/conexion.php';
		                                            $query ="SELECT acta.ACTANUME, tecnico.TECNNOMB, ACTAFECH, ACTAVANE
															 FROM acta
																INNER JOIN tecnico ON tecnico.TECNCODI = acta.ACTATECN
															 WHERE acta.ACTAESTA = 'G'";
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="buscarActa('.$row['ACTANUME'].')">
		                                                    		<td class="text-center">'.$row['ACTANUME'].'</td>
		                                                    		<td>'.utf8_encode($row['TECNNOMB']).'</td>
		                                                    		<td class="text-right">$ '.number_format($row['ACTAVANE'],0,"",".").'</td>
		                                                    		<td class="text-center">'.$row['ACTAFECH'].'</td>
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
	            	<ol class="breadcrumb">
	                	<li><a href="#">Actas</a></li>
	                	<li class="active">Aprobacion de Acta</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Aprobar Acta</h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body">
			                    <input type="hidden" id="swEstadoTecnico" value="0" readonly>
			                    <div id="divConsultarTecnicos" class="display-none"></div>
			                    
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Codigo</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtActCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Codigo Tecnico</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtTecCod" placeholder="Codigo" onkeypress="solonumeros()" readonly>
				                      		</div>
				                      		<div class="col-sm-6">
				                        		<input type="text" class="form-control input-sm" id="txtTecNomb" placeholder="Nombre de Tecnico" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Fecha</label>
					                     	<div class="col-sm-2">
				                        		<input type="date" class="form-control input-sm" id="txtFecha" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Estado</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtEstado" placeholder="Estado del Acta" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Valor Bruto</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtValBruto" placeholder="Valor Bruto" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Valor Neto</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtValNeto" placeholder="Valor Neto" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Observacion</label>
					                     	<div class="col-sm-8">
				                      			<textarea id="txtObservActa" class="form-control input-sm" placeholder="Observacion del acta" rows="4" readonly></textarea>
				                      		</div>
					                    </div>
				                	</div>

				                	<div id="divConsulta"></div>
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
<script src="js/apacta.js"></script>
<!--  Detectar cambios en las Formas    -->
<script src="assets/js/detectaCambiosEnFormas.js"></script>
<!--  Seleccionar nuevo Item Talas    -->
<script src="assets/js/selectedNewRow.js"></script>
<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>