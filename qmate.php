<?php require 'template/start.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">
		<?php require 'template/menu.php'; ?>
		<div class="content-wrapper">
			<div class="container">
				
				<div class="modal fade" id="modalBodega">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">BODEGAS</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12" style="height: 298px; overflow-y: scroll;">
				                		<table id="tableDepa" class="tableJs table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php 
		                                            //$conn = require 'inc/clases/conexion.php';
		                                            $query ="SELECT * FROM bodega WHERE BODEESTA = 'A'";
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="addBodega('.str_pad($row['BODECODI'],2,"0", STR_PAD_LEFT).',\''.utf8_encode($row['BODENOMB']).'\')">
		                                                    		<td>'.str_pad($row['BODECODI'],2,"0", STR_PAD_LEFT).'</td>
		                                                    		<td>'.utf8_encode($row['BODENOMB']).'</td>
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
	            
	            <div class="modal fade" id="modalMaterial">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">MATERIALES</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12" style="height: 298px; overflow-y: scroll;">
				                		<table id="tableDepa" class="tableJs table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody id="divModalMateriales">
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
	                	<li><a href="#">Almacen</a></li>
	                	<li class="active">Consulta de Materiales por Bodega</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Parametros de Consulta </h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body">
			                    	<input type="hidden" id="swEstadoTecnico" value="0" readonly>
			                    	<div id="divConsultarTecnicos" class="display-none"></div>
			                    	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Bodega</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm" id="txtBodCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-6">
				                        		<input type="text" class="form-control input-sm" id="txtBodNomb" placeholder="Nombre de la Bodega" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Material</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm" id="txtMatCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-6">
				                        		<input type="text" class="form-control input-sm" id="txtMatNomb" placeholder="Nombre del material" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<hr>
				                	<h4 style="margin-left: 10px;">Existencia Actual</h4>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-3 control-label text-right" style="margin-top:5px;">Cantidad Suministrada</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm text-right" id="txtCantSum" placeholder="Cantidad" readonly>
				                      		</div>
				                      		<label for="txtClase" class="col-sm-3 control-label text-right" style="margin-top:5px;">Cantidad Propia</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm text-right" id="txtCantProp" placeholder="Cantidad" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-3 control-label text-right" style="margin-top:5px;">Valor Suministrada</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm text-right" id="txtValSum" placeholder="Valor" readonly>
				                      		</div>
				                      		<label for="txtClase" class="col-sm-3 control-label text-right" style="margin-top:5px;">Valor Propia</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm text-right" id="txtValProp" placeholder="Valor" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<hr>
				                	<h4 style="margin-left: 10px;">Seriales</h4>
				                	<div class="row marginTop3">
				                		<div class="col-md-6">
				                			<input type="hidden" id="swCheckTodos" value="0">
				                			<div id="tableOrdenes" style="height: 250px; overflow-y: scroll;">
						                		<table class="table table-bordered table-condensed">
						                			<tr style="background-color: #3c8dbc; color:white;">
								        				<th class="text-center" width="100">NUMERO SERIE</th>
								        			</tr>
						                		</table>
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
<script src="js/qmate.js"></script>