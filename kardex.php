<?php require 'template/start.php'; 
	
	echo '<script src="tools/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        	<script type="text/javascript">
				$(document).ready(function () {
					consultarMain();
				});
			</script>';
?>
<body class="hold-transition skin-blue layout-top-nav" onkeydown="return atajos_teclado(event)">
	<div class="wrapper">
		<?php require 'template/menu.php'; ?>
		<div class="content-wrapper">
			<div class="container">

	            <div class="modal fade" id="modalBodega">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">BODEGA ORIGINAL</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12" style="height: 298px; overflow-y: scroll;">
				                		<table id="tableDepa" class="table table-bordered table-condensed table-striped table-hover">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php 
		                                            //$conn = require 'inc/clases/conexion.php';
		                                            $query ="SELECT * FROM bodega WHERE BODEESTA='A' AND (BODECLAS = 1 OR BODECLAS = 3)";
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
				                		<table id="tableDepa" class="table table-bordered table-condensed table-striped table-hover">
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
	                	<li class="active">Consulta de Movimiento Item por Bodega en un Periodo</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title"></h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body">
			                    	<input type="hidden" id="swEstadoTecnico" value="0" readonly>
			                    	<div id="divConsultarTecnicos" class="display-none"></div>
			                    	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-1 control-label text-right" style="margin-top:5px;">Bodega</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm" id="txtEnCod" placeholder="Codigo" onkeypress="solonumeros()" autofocus>
				                      		</div>
				                      		<div class="col-sm-4">
				                        		<input type="text" class="form-control input-sm" id="txtEnNomb" placeholder="Nombre de la Bodega" readonly>
				                      		</div>
				                      		<label for="txtClase" class="col-sm-1 control-label text-right" style="margin-top:5px;">Material</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm" id="txtMatCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-4">
				                        		<input type="text" class="form-control input-sm" id="txtMatNomb" placeholder="Nombre del material" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop5">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-1 control-label text-right" style="margin-top:5px;">Desde</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm" id="txtAnio" placeholder="Año" onkeypress="solonumeros()"|>
				                      		</div>
				                      		<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm" id="txtMes" placeholder="Mes" onkeypress="solonumeros()"|>
				                      		</div>
				                      		<div class="col-sm-4"></div>
					                     	<div class="col-sm-2">
					                     		<select class="form-control input-sm" id="selcTipo">
					                     			<option value="S">PROPIO</option>
					                     			<option value="N">PRESTADO</option>
					                     		</select>
				                      		</div>
				                      		<div class="col-sm-3">
				                      			<a class="btn btn-sm btn-primary" onclick="limpiar()">Limpiar Pantalla</a>
				                      			<a id="btnConsultar_kardex" class="btn btn-sm btn-primary" onclick="consultar()">Consultar</a>
				                      		</div>
					                    </div>
				                	</div>
				                	<hr>
				                	<h4 style="margin-left: 10px;">Movimiento de material en el periodo</h4>
				                	<div class="row marginTop3">
				                		<div class="col-md-12">
				                			<input type="hidden" id="swCheckTodos" value="0">
				                			<div id="tableOrdenes" style="height: 360px; overflow-y: scroll;" class="container-table-list">
						                		<table class="table table-bordered table-condensed table-striped table-hover">
						                			<thead>
							                			<tr style="background-color: #3c8dbc; color:white;">
									        				<th class="text-center" width="70">DOCUMENTO</th>
									        				<th class="text-center" width="70">FECHA</th>
									        				<th class="text-center" width="60">TIPO</th>
									        				<th class="" width="300">DESCRIPCION</th>
									        				<th class="text-center" width="20">E/S</th>
									        				<th class="text-right" width="90">CANTIDAD</th>
									        				<th class="text-right" width="90">VALOR</th>
									        				<th class="text-right" width="120">SALDO CANTIDAD</th>
									        				<th class="text-right" width="90">SALDO VALOR</th>
									        			</tr>
						                			</thead>
						                			<tbody id="tableMovimientosMaterial"></tbody>
						                		</table>
				                			</div>
				                		</div>
				                	</div>
				                	<hr>
									<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtCantInic" class="col-sm-1 control-label text-right"><small>Cantidad Inicial</small></label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control text-right" id="txtCantInic" placeholder="0" readonly>
				                      		</div>
											<label for="txtValoInic" class="col-sm-1 control-label text-right"><small>Valor<br> Inicial</small></label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control text-right" id="txtValoInic" placeholder="0" readonly>
				                      		</div>
										</div>
									</div>
									<div class="row marginTop3">
					                	<div class="form-group">
				                      		<label for="txtEntrCant" class="col-sm-1 control-label text-right"><small>Entradas Cantidad</small></label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control text-right" id="txtEntrCant" placeholder="0" readonly>
				                      		</div>
											<label for="txtSalidCant" class="col-sm-1 control-label text-right"><small>Salidas Cantidad</small></label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control text-right" id="txtSalidCant" placeholder="0" readonly>
				                      		</div>
				                      		<label for="txtEntrVal" class="col-sm-1 control-label text-right"><small>Entrada Valor</small></label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control text-right" id="txtEntrVal" placeholder="0" readonly>
				                      		</div>
											  <label for="txtSalidVal" class="col-sm-1 control-label text-right"><small>Salidas Valor</small></label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control text-right" id="txtSalidVal" placeholder="0" readonly>
				                      		</div>
										</div>
									</div>
									<hr>
									<div class="row marginTop3">
					                	<div class="form-group">
				                      		<label for="txtCantFinCalc" class="col-sm-1 control-label text-right"><small>Cant Final Calculada</small></label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control text-right input-sm border-blue" id="txtCantFinCalc" placeholder="0" readonly>
				                      		</div>
											<label for="txtValFinCalc" class="col-sm-1 control-label text-right"><small>Valor Final Calculado</small></label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control text-right input-sm border-blue" id="txtValFinCalc" placeholder="0" readonly>
				                      		</div>
				                      		<label for="txtCantFinSist" class="col-sm-1 control-label text-right"><small>Cant Final Sistema</small></label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control text-right border-black" id="txtCantFinSist" placeholder="0" readonly>
				                      		</div>
											<label for="txtValoFinSist" class="col-sm-1 control-label text-right"><small>Valor Final Sistema</small></label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control text-right border-black" id="txtValoFinSist" placeholder="0" readonly>
				                      		</div>
										</div>
									</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
				                      		<label for="txtDifCantidad" class="col-sm-1 control-label text-right" style="margin-top:5px;"><small>Diferencia Cantidad</small></label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control text-right input-sm border-green" id="txtDifCantidad" placeholder="0" readonly>
				                      		</div>
				                      		<label for="txtDifValor" class="col-sm-1 control-label text-right" style="margin-top:5px;"><small>Diferencia Valor</small></label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control text-right input-sm border-green" id="txtDifValor" placeholder="0" readonly>
				                      		</div>
					                    </div>
				                	</div>
			                    </div>
							</div>
						</div>
					</div>
				</section>

				<!-- Detalle Mivimiento Almacen-->
				<form method="POST" action="calma.php" class="display-none" id="formDetalleMovimientoPost">
					<input type="hidden" id="txtDocumentoMovimiento" name="txtDocumentoMovimiento">
					<input type="hidden" id="txtSelectMovimiento" name="txtSelectMovimiento">
				</form>
				<input type="hidden" id="swTipoEnvioKardex">
				<!-- Detalle Legalizacion-->				
				<form method="POST" action="cusuOrden.php" class="" id="formDetalleLegalizacionPost">
					<input type="text" id="txtDocumentoLegalizacion" name="txtIdOrdenPost">
					<input type="text" id="txtIdUsuarioPost" name="txtIdUsuarioPost">
					<input type="text" id="txtSelectLegalizacion" name="txtSelectLegalizacion">
				</form>

			</div>
		</div>
		<?php require 'template/footer.php'; ?>
	</div>
</body>
<?php require 'template/end.php'; ?>
<script src="js/kardex.js"></script>