<?php require 'template/start.php'; ?>
<!--  Material Dashboard CSS    -->
<link href="assets/css/material-dashboard.css" rel="stylesheet"/>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
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
		                                            $query ="SELECT * FROM tecnico WHERE TECNESTA='A'";
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="addTecnico(\''.$row['TECNCODI'].'\',\''.utf8_encode($row['TECNNOMB']).'\')">
		                                                    		<td class="text-center">'.$row['TECNCODI'].'</td>
		                                                    		<td>'.utf8_encode($row['TECNNOMB']).'</td>
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
	                	<li><a href="#">Ordenes</a></li>
	                	<li><a href="#">Actas Individuales</a></li>
	                	<li class="active">Generacion de Acta por Escogencia</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Generacion de acta x medio de seleccion masiva de ordenes</h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body">
			                    	<input type="hidden" id="swEstadoTecnico" value="0" readonly>
			                    	<div id="divConsultarTecnicos" class="display-none"></div>
			                    	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Codigo Tecnico</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm" id="txtTecCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-4">
				                        		<input type="text" class="form-control input-sm" id="txtTecNomb" placeholder="Nombre de Tecnico" readonly>
				                      		</div>
				                      		<label for="txtClase" class="col-sm-2 control-label" style="margin-top:5px;">Metodo de Seleccion</label>
				                      		<div class="col-sm-3">
				                      			<input type="radio" name="metdAsign"  style="margin-top: 8px;" onclick="escogencia(1)"> Por bloque &nbsp;&nbsp;
				                      			<input type="radio" name="metdAsign" checked onclick="escogencia(2)"> Escogencia Multiple
				                      		</div>
					                    </div>
				                	</div>

			                    	<div class="row marginTop8">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;"></label>
				                      		<div class="col-sm-4 text-center">
				                        		<a class="btn btn-sm btn-default" onclick="mostrarManosdeObra()"> Mostrar ordenes segun Criterio</a>&nbsp;&nbsp;
				                      			<a class="btn btn-sm btn-default" onclick="limpiarPantalla()"> Limpiar Pantalla</a>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop8">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;"></label>
					                     	<label for="txtClase" class="col-sm-4 control-label text-center" style="margin-top:5px;">CRITERIO DE ORDENAMIENTO DE VALORES A PAGAR</label>
					                    </div>
				                	</div>
				                	<div class="row marginTop8">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;"></label>
					                     	<div class="col-sm-4 text-left" style="border: solid 1px; background-color: #808080; color:white;">
				                      			<small style="margin-top: 8px;">
					                      			<input type="radio" name="critOrd" value="1" checked> Orden &nbsp; 
					                      			<input type="radio" name="critOrd" value="2"> Mano Obra &nbsp; 
					                      			<input type="radio" name="critOrd" value="3"> Fecha Cumpl &nbsp; 
					                      			<input type="radio" name="critOrd" value="4"> PQR &nbsp; 
					                      			<input type="radio" name="critOrd" value="5"> Usuario &nbsp; 
				                      			</small>
				                      		</div>
					                     	<label for="txtClase" class="display-none col-sm-3 control-label text-right" style="margin-top: 4px;">BUSCAR Y ESCOGER ORDEN</label>
					                      	<div class="display-none col-sm-2">
					                      			<input type="text" placeholder="#Orden" class="form-control input-sm" id="txtNoOrden" onkeypress="solonumeros()">
					                      	</div>
					                    </div>
				                	</div>
				                	<hr>
				                	<div class="row marginTop3">
				                		<div class="col-md-12">
				                			<input type="hidden" id="swCheckTodos" value="0">
				                			<div id="tableOrdenes" style="height: 460px; overflow-y: scroll;" class="container-table-list">
						                		<table class="table table-bordered table-condensed">
						                			<tr style="background-color: #3c8dbc; color:white;">
						                				<th class="text-center" width="10" style="vertical-align:middle"><input type="checkbox"></th>
						                				<th class="text-center" width="120">NUMERO DE ORDEN</th>
						                				<th class="text-center" width="100" style="vertical-align:middle">FECHA ORDEN</th>
						                				<th class="text-center" width="100">FECHA ASIGNACION</th>
						                				<th class="text-center" width="100">FECHA CUMPLIMIENTO</th>
						                				<th class="text-center" width="70" style="vertical-align:middle">PQR</th>
						                				<th class="text-left" style="vertical-align:middle">MANO DE OBRA</th>
						                				<th class="text-left" style="vertical-align:middle">USUARIO</th>
						                				<th class="text-right" width="100" style="vertical-align:middle">VALOR</th>
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
<script src="js/gama.js"></script>
<!--  Detectar cambios en las Formas    -->
<script src="assets/js/detectaCambiosEnFormas.js"></script>
<!--  Seleccionar nuevo Item Talas    -->
<script src="assets/js/selectedNewRow.js"></script>
<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>