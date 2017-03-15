<?php require 'template/start.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">
		<?php require 'template/menu.php'; ?>
		<div class="content-wrapper">
			<div class="container">
				
				<div class="modal fade" id="modalTecnicos">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">TECNICOS</h4>
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
		                                            $query ="SELECT * FROM tecnico WHERE TECNESTA='A' ORDER BY TECNNOMB";
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
	                	<li><a href="#">Informacion Basica</a></li>
	                	<li class="active">Mantenimiento de PQR´S</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">PQR</h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body">
			                    <input type="hidden" id="swEstadoPqr" value="0" readonly>
			                    <div id="divConsultarPqrs" class="display-none"></div>
			                    	<div class="row">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtCod" class="col-sm-2 control-label text-right" style="margin-top:5px;">Codigo</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtCod" placeholder="Codigo" onkeypress="solonumeros()">
				                        		<input type="hidden" class="form-control input-sm" id="txtCodOrg" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                    <div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtNom" class="col-sm-2 control-label text-right" style="margin-top:5px;">Nombre</label>
				                      		<div class="col-sm-8">
				                        		<input type="text" class="form-control input-sm" id="txtNom" placeholder="Nombre del PRQ" onclick="swEditor('txtNom')" >  
				                      		</div>
					                    </div>
				                	</div>  
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtDia" class="col-sm-2 control-label text-right" style="margin-top:5px;">Dias para Bloqueo</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtDia" placeholder="Dias" onkeypress="solonumeros()">
				                      		</div>
					                    </div>
				                	</div>  
				                	<div class="row marginTop1">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="ckSac" class="col-sm-2 control-label text-right" style="margin-top:5px;">Sale a Certificacion</label>
					                     	<div class="col-sm-2 marginTop3" id="div_ckSac">
				                        		<input type="checkbox" id="ckSac">
				                      		</div>
					                    </div>
				                	</div>  
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtPoi" class="col-sm-2 control-label text-right" style="margin-top:5px;">Porcentaje de Inspección</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtPoi" placeholder="%" onkeypress="solonumeros()">
				                      		</div>
					                    </div>
				                	</div> 
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtCdc" class="col-sm-2 control-label text-right" style="margin-top:5px;">Centro de Costo</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtCdc" placeholder="Costo" onkeypress="solonumeros()">
				                      		</div>
					                    </div>
				                	</div>

				                	<div class="row marginTop1">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="ckLmp" class="col-sm-2 control-label text-right" style="margin-top:5px;">Legaliza material propio</label>
					                     	<div class="col-sm-2 marginTop3" id="div_ckLmp">
				                        		<input type="checkbox" id="ckLmp">
				                      		</div>
					                    </div>
				                	</div> 
				                	<div class="row marginTop1">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="ckLpa" class="col-sm-2 control-label text-right" style="margin-top:5px;">Legaliza por archivo</label>
					                     	<div class="col-sm-2 marginTop3" id="div_ckLpa">
				                        		<input type="checkbox" id="ckLpa">
				                      		</div>
					                    </div>
				                	</div> 
				                	<div class="row marginTop1">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="ckAct" class="col-sm-2 control-label text-right" style="margin-top:5px;">Activa</label>
					                     	<div class="col-sm-2 marginTop3" id="div_ckAct">
				                        		<input type="checkbox" id="ckAct">
				                      		</div>

				                      		<div class="col-sm-3"></div>
					                     	<label for="ckLem" class="col-sm-2 control-label text-right" style="margin-top:5px;">Legaliza materiales</label>
					                     	<div class="col-sm-2 marginTop3" id="div_ckLem">
				                        		<input type="checkbox" id="ckLem">
				                      		</div>
					                    </div>
				                	</div>

									<div class="row marginTop1">
					                	<div class="form-group">
					                     	<label for="ckAdd" class="col-sm-3 control-label text-right" style="margin-top:5px;">Acepta desbloqueos o desasignaciones</label>
					                     	<div class="col-sm-2 marginTop3" id="div_ckAdd">
				                        		<input type="checkbox" id="ckAdd">
				                      		</div>

				                      		<div class="col-sm-3"></div>
					                     	<label for="ckIup" class="col-sm-2 control-label text-right" style="margin-top:5px;">Indica si utiliza pegador</label>
					                     	<div class="col-sm-2 marginTop3" id="div_ckIup">
				                        		<input type="checkbox" id="ckIup">
				                      		</div>
					                    </div>
				                	</div>
									<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtCot" class="col-sm-2 control-label text-right" style="margin-top:5px;">Exclusivo del Tecnico</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtCot" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-6">
				                        		<input type="text" class="form-control input-sm" id="txtNomt" placeholder="Nombre del Tecnico" readonly>
				                      		</div>
					                    </div>
				                	</div>
									
									<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtPri" class="col-sm-2 control-label text-right" style="margin-top:5px;">Prioridad</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtPri" placeholder="Prioridad" onkeypress="solonumeros()">
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtVtde" class="col-sm-3 control-label text-right" style="margin-top:5px;">Valor transporte dentro del rango</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtVtde" placeholder="0000" onkeypress="solonumeros()">
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtVtfu" class="col-sm-3 control-label text-right" style="margin-top:5px;">Valor transporte fuera del rango</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtVtfu" placeholder="0000" onkeypress="solonumeros()">
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
<script src="js/ppqr.js"></script>