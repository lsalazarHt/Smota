<?php 
	date_default_timezone_set('America/Bogota'); 
	require 'template/start.php'; 
?>
<!--  Material Dashboard CSS    -->
<link href="assets/css/material-dashboard.css" rel="stylesheet"/>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">
		<?php require 'template/menu.php'; ?>
		<div class="content-wrapper">
			<div class="container">

	            <div class="modal fade" id="modalBodegaOriginal">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">BODEGA ORIGINAL</h4>
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
		                                            $query ="SELECT * FROM bodega WHERE BODEESTA='A' AND BODECLAS = 3";
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="addBodegaOrig(\''.$row['BODECODI'].'\',\''.utf8_encode($row['BODENOMB']).'\')">
		                                                    		<td class="text-center">'.$row['BODECODI'].'</td>
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

	            <div class="modal fade" id="modalBodegaDestino">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">BODEGA DESTINO</h4>
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
					                        <tbody id="divBodDest">
					                        </tbody>
					                    </table>
				                	</div>
			                	</div>
			                </div>
	                	</div><!-- /.modal-content -->
	               	</div><!-- /.modal-dialog -->
	            </div>
				
				<input type="hidden" id="req_doc_soport">
				<input type="hidden" id="req_doc_prove_gas">

	            <div class="modal fade" id="modalTipoMovimiento">
	             	<div class="modal-dialog" style="width:60%">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">TIPO DE MOVIMIENTO</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12" style="height: 350px; overflow-y: scroll;">
				                		<table id="tableDepa" class="tableJs table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th>NOMBRE</th>
					                             	<th class="text-center" width="10">Ma</th>
					                             	<th class="text-left" width="200">BODEGA DESTINO</th>
					                            </tr>
					                        </thead>
					                        <tbody id="divTipoMov">
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
	                	<li class="active">Entradas y Salidas de Almacen</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Movimiento de Inventario </h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body">
			                    	<input type="hidden" id="swEstadoTecnico" value="0" readonly>
			                    	<div id="divConsultarTecnicos" class="display-none"></div>
			                    	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Numero</label>
					                     	<div class="col-sm-2">
					                     		<input type="hidden" id="swMov" value="N">
				                        		<input type="text" class="form-control input-sm" id="txtMovCod" placeholder="Numero" readonly>
				                      		</div>
				                      		<div class="col-sm-4 text-center" id="divTipoMovimientoCheck">
				                      			<input type="radio" name="tipoMov" onclick="actualizarTipoMovimiento('E');" checked> Entrada &nbsp;&nbsp;&nbsp;&nbsp;
				                      			<input type="radio" name="tipoMov" onclick="actualizarTipoMovimiento('S');"> Salida
				                      			<input type="hidden" id="txtSWTipoMovCod" value="E">
				                      		</div>
					                     	<label for="txtClase" class="col-sm-1 control-label" style="margin-top:5px;">Fecha</label>
				                      		<div class="col-sm-2">
				                        		<input type="date" class="form-control input-sm" id="txtFecha" value="<?php echo date('Y-m-d') ?>" readonly>
				                      		</div>
					                    </div>
				                	</div>
			                    	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">En</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtEnCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-4">
				                        		<input type="text" class="form-control input-sm" id="txtEnNomb" placeholder="Nombre de la Bodega principal" readonly>
				                      		</div>
				                      		<label for="txtClase" class="col-sm-1 control-label" style="margin-top:5px;">Valor</label>
				                      		<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm text-right valor" id="txtValor" placeholder="Valor" onkeypress="solonumeros()" value="0" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Tipo de Movimiento</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtTipoMovCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-4">
				                        		<input type="text" class="form-control input-sm" id="txtTipoMovNomb" placeholder="Nombre del Tipo Movimiento" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Bodega</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtBodCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-4">
				                        		<input type="text" class="form-control input-sm" id="txtBodNomb" placeholder="Nombre de la bodega" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Soporte</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtSopCod" placeholder="Codigo" onkeypress="solonumeros()" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Documente Soporte</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm text-right" id="txtDocSopCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Observacion</label>
					                     	<div class="col-sm-9">
					                     		<textarea rows="4" class="form-control input-sm movObEntrada_border" id="txtObser" placeholder="Observacion del movimiento"></textarea>
				                      		</div>
					                    </div>
				                	</div>
				                	<hr>
				                	<h4 style="margin-left: 10px;">
										<a class="" data-toggle="tooltip" data-original-title="Agregar" onclick="nuevoMaterial()"><i class="fa fa-plus"></i></a>
										<a class="text-red" data-toggle="tooltip" data-original-title="Quitar" onclick="deleteMaterial()"><i class="fa fa-minus"></i></a> 
										Materiales
				                	</h4>
				                	<hr>
				                	<div class="row marginTop3">
				                		<div class="col-md-12">
				                			<input type="hidden" id="selectRow" value="0">
				                			<input type="hidden" id="contRow" value="0">
				                			<div id="tableOrdenes" style="height: 460px; overflow-y: scroll;">
						                		<table id="table_materiales" class="table table-bordered table-condensed">
						                			<thead>
							                			<tr style="background-color: #3c8dbc; color:white;">
									        				<th class="text-center" width="100">MATERIAL</th>
									        				<th class="">DESCRIPCION DEL MATERIAL</th>
									        				<th class="text-center" width="100">CANTIDAD</th>
									        				<th class="text-right" width="170">VALOR</th>
									        			</tr>
						                			</thead>
						                			<tbody id="divMaterialInventario">
						                			</tbody>
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
<script src="js/ralma.js"></script>
<!--  Detectar cambios en las Formas    -->
<script src="assets/js/detectaCambiosEnFormas.js"></script>
<!--  Seleccionar nuevo Item Talas    -->
<script src="assets/js/selectedNewRow.js"></script>
<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>
<!--  TAB ENTER    -->
<script src="assets/js/selectedNewRow.js"></script>