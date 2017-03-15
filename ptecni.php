<?php require 'template/start.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">
		<?php require 'template/menu.php'; ?>
		<div class="content-wrapper">
			<div class="container">
				
				<div class="modal fade" id="modalClaseTecnicos">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">CLASES DE TECNICOS</h4>
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
		                                            $query ="SELECT * FROM clastecn ORDER BY CLTECODI";
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="agregarClasesTecnico(\''.$row['CLTECODI'].'\',\''.$row['CLTEDESC'].'\')">
		                                                    		<td class="text-center">'.$row['CLTECODI'].'</td>
		                                                    		<td>'.$row['CLTEDESC'].'</td>
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

	            <div class="modal fade" id="modalBodegas">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">BODEGAS</h4>
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
		                                            $query ="SELECT * FROM bodega WHERE BODEESTA='A' ORDER BY BODECODI";
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="agregarBodega(\''.$row['BODECODI'].'\')">
		                                                    		<td class="text-center">'.$row['BODECODI'].'</td>
		                                                    		<td>'.$row['BODENOMB'].'</td>
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
	                	<li><a href="#">Cuadrillas</a></li>
	                	<li class="active">Administración de Técnicos</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Tecnicos</h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body">
			                    <input type="hidden" id="swEstadoTecnico" value="0" readonly>
			                    <div id="divConsultarTecnicos" class="display-none"></div>
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
				                        		<input type="text" class="form-control input-sm" id="txtNom" placeholder="Nombre del Tecnico" onclick="swEditor('txtNom')" >  
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Clase</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtClaseCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-6">
				                        		<input type="text" class="form-control input-sm" id="txtClaseNomb" placeholder="Nombre de la Clase" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="ckAct" class="col-sm-2 control-label text-right" style="margin-top:5px;">Activo</label>
					                     	<div class="col-sm-2 marginTop3" id="div_ckAct">
				                        		<input type="checkbox" id="ckAct">
				                      		</div>
					                    </div>
				                	</div>
									<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtFechaIng" class="col-sm-3 control-label text-right" style="margin-top:5px;">Fecha Ingreso</label>
					                     	<div class="col-sm-2 marginTop3">
				                        		<input type="date" class="form-control input-sm" id="txtFechaIng" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>

				                      		<div class="col-sm-2"></div>
					                     	<label for="txtFechaRet" class="col-sm-2 control-label text-right" style="margin-top:5px;">Fecha Retiro</label>
					                     	<div class="col-sm-2 marginTop3">
				                        		<input type="date" class="form-control input-sm" id="txtFechaRet" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="ckInv" class="col-sm-3 control-label text-right" style="margin-top:5px;">Maneja Inventario?</label>
					                     	<div class="col-sm-2 marginTop3" id="div_ckInv">
				                        		<input type="checkbox" id="ckInv" onclick="swManejaBodega()">
				                      		</div>

				                      		<div class="col-sm-2"></div>
					                     	<label id="divSwCodigoBodegaLabel" for="txtCodBodega" class="col-sm-2 control-label text-right" style="margin-top:5px;">Codigo Bodega</label>
					                     	<div id="divSwCodigoBodegaInput" class="col-sm-2 marginTop3" >
				                        		<input type="text" class="form-control input-sm" id="txtCodBodega" placeholder="Codigo" onkeypress="solonumeros()">
				                        		<input type="hidden" id="txtCodBodegaVdd">
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtSalario" class="col-sm-3 control-label text-right" style="margin-top:5px;">Salario Basico</label>
					                     	<div class="col-sm-2 marginTop3" >
				                        		<input type="text" class="form-control input-sm" id="txtSalario" placeholder="Salario" onkeypress="solonumeros()">
				                      		</div>

				                      		<div class="col-sm-1"></div>
					                     	<label for="ckDevProd" class="col-sm-3 control-label text-right" style="margin-top:5px;">Devenga por Producción?</label>
					                     	<div class="col-sm-2 marginTop3" id="div_ckDevProd">
				                        		<input type="checkbox" id="ckDevProd">
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
<script src="js/ptecni.js"></script>