<?php 
	require 'template/start.php'; 

	echo '<script src="tools/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        	<script type="text/javascript">
				$(document).ready(function () {
					if($("#txtCod").val()!=""){
						buscarTecnico($("#txtCod").val());
					}
				});
			</script>';
?>
<!--  Material Dashboard CSS    -->
<link href="assets/css/material-dashboard.css" rel="stylesheet"/>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
<body class="hold-transition skin-blue layout-top-nav">
<style>

.nav-tabs > li > a	{ 
	background-color: #f5f5f5; 
	color: #676767; 
	border-color: #dddddd; 
	border-width: 1px; 
	padding: 5px 15px; 
	line-height: 2; 
	-webkit-transition: all 0.75s; 
	-moz-transition: all 0.75s; 
	transition: all 0.75s; 
} 
.tabbable-line > .nav-tabs > li > a:active		{ background-color: #3c8dbc; color: #f5f5f5;}
.tabbable-line > .nav-tabs > li > a:focus 		{ background-color: #3c8dbc; color: #f5f5f5;} 
.tabbable-line > .nav-tabs > li > a:hover 		{ background-color: #52A6D6; color: #f5f5f5; border-color: #dddddd;} 

.tabbable-line > .nav-tabs > .active > a { background-color: #3c8dbc; color: #f5f5f5;}
</style>
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
				                		<table id="tableDepa" class="table table-bordered table-condensed">
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
				                		<table id="tableDepa" class="table table-bordered table-condensed">
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
	                	<li class="active">Informacion Detallada de Técnicos</li>
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
					                     	<label for="txtCod" class="col-sm-2 control-label text-right" style="margin-top:5px;">Codigo</label>
					                     	<div class="col-sm-9">
				                        		<input style="float:left; width:100px;" type="text" class="form-control input-sm" id="txtCod" placeholder="Codigo" onkeypress="solonumeros()">
				                        		<input style="float:left; width:692px; margin-left:8px;" type="text" class="form-control input-sm" id="txtNom" placeholder="Nombre del Tecnico" onclick="swEditor('txtNom')" readonly>  
				                      		</div>
					                    </div>
				                	</div>
				                    <div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-2"></div>
					                		<div class="col-sm-2 marginTop3" id="div_ckAct" >
				                        		<input type="checkbox" class="marginTop5" id="ckAct"> <label class="control-label">Activo</label>
				                      		</div>
				                      		<div class="col-sm-7">
						                     	<label style="float:left; margin-top: 5px;" for="txtNom" class="control-label text-right" style="margin-top:5px;">Clase</label>
					                        	<input style="float:left; width:100px; margin-left:8px;" type="text" class="form-control input-sm" id="txtClaseCod" placeholder="Codigo" onclick="swEditor('txtClaseCod')" readonly>  
					                        	<input style="float:left; width:464px; margin-left:8px;"type="text" class="form-control input-sm" id="txtClaseNomb" placeholder="Codigo del Tecnico" onclick="swEditor('txtClaseNomb')" readonly> 
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtFechaIng" class="col-sm-2 control-label text-right" style="margin-top:5px;">Fecha Ingreso</label>
				                        	<input style="float:left; width:140px; margin-left: 15px;" type="date" class="col-sm-2 form-control input-sm" id="txtFechaIng" placeholder="Codigo" onkeypress="solonumeros()" readonly>
				                      		<label style="float:left; width:120px; margin-top: 5px;" for="txtFechaRet" class=" col-sm-1 control-label text-right" style="margin-top:5px;">Fecha Retiro</label>
				                        	<input style="float:left; width:140px;" type="date" class=" form-control input-sm" id="txtFechaRet" placeholder="Codigo" onkeypress="solonumeros()" readonly>
				                      		<label style="float:left; width:75px; margin-top: 5px;" for="txtSalario" class=" col-sm-1 control-label text-right" style="margin-top:5px;">Salario</label>
				                        	<input style="float:left; width:150px;" type="text" class="form-control input-sm text-right" id="txtSalario" placeholder="Salario del Tecnico" onclick="swEditor('txtSalario')" readonly>  
					                     	<label style="float:left; width:75px; margin-top: 5px;" for="txtCodBodega" class=" col-sm-1 control-label text-right" style="margin-top:5px;">Bodega</label>
				                        	<input style="float:left; width:100px;" type="text" class="form-control input-sm text-right" id="txtCodBodega" placeholder="Codigo" onclick="swEditor('txtCodBodega')" readonly>  
					                    </div>
				                	</div>
				                	<hr>
				                	<div class="row marginTop3 text-center text-center">
				                		<div class="col-md-12">
				                			<div class="tabbable-line">
										        <ul class="nav nav-tabs">
										        	<li id="ot_sinCumplir" class="liTab"><a href="#ordenesSinCumplir" data-toggle="tab">Ordenes sin Cumplir</a></li>
									          		<li id="ot_cumXcertif" class="liTab"><a href="#ordenesCumplidasXcertificar" data-toggle="tab">Ordenes Cumplidas x Certificar</a></li>
									          		<li id="ot_cumCertifi" class="liTab"><a href="#ordenesCumplidasCertificada" data-toggle="tab">Ordenes Cumplidas Certificadas</a></li>
													<li id="ot_incumplida" class="liTab"><a href="#ordenesIncumplidas" data-toggle="tab">Ordenes Incumplidas</a></li>
									          		<li id="ot_anuladas"   class="liTab"><a href="#ordenesAnuladas" data-toggle="tab">Anuladas</a></li>
													<li id="ot_matLegaliz" class="liTab"><a href="#materialesLegalizados" data-toggle="tab">Materiales Legalizados</a></li>
									          		<li id="ot_manLegaliz" class="liTab"><a href="#manoDeObraLegalizada" data-toggle="tab">Mano de Obra Legalizada</a></li>
													  
									          		<li id="ot_acta_tec" class="liTab"><a href="#acta" data-toggle="tab">Acta</a></li>
									          		<li><a href="#inventario" data-toggle="tab">Inventario</a></li>
									          		<li><a href="#notas" data-toggle="tab">Notas</a></li>
									          		<li><a href="#elmento_prot" data-toggle="tab">Elementos de protección personal</a></li>
									          		<li><a href="#herramientas" data-toggle="tab">Herramientas</a></li>
										        </ul>
										        <div class="tab-content">
										            <!-- Ordenes Cumplidas x Certificar -->
														<div class="tab-pane" id="ordenesSinCumplir">
															<div class="row">
																<label class="col-sm-q control-label text-right" style="margin-top:5px;">Ordernar Por</label>
																<a style="margin-left:5px;" onclick="buscarOrdenesSinCumplir(1)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Numero de Orden">Numero de Orden</a>
																<a style="margin-left:5px;" onclick="buscarOrdenesSinCumplir(2)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Fecha de Orden">Fecha de Orden</a>
																<a style="margin-left:5px;" onclick="buscarOrdenesSinCumplir(3)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Fecha de Asignacion">Fecha de Asignacion</a>
																<a style="margin-left:5px;" onclick="buscarOrdenesSinCumplir(4)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Usuario">Usuario</a>
																<a style="margin-left:5px;" onclick="buscarOrdenesSinCumplir(5)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Pqr">Pqr</a>
															</div>
															<div class="row marginTop5">
																<div class="col-md-12 container-table-list" style="height: 500px; overflow-y: scroll;">
																	<table id="table" class="table table-condensed table-bordered table-striped">
																		<thead>
																			<tr style="background-color: #3c8dbc; color:white;">
																				<th class="text-center" width="120">NUMERO</th>
																				<th class="text-center" width="90">FECHA ORDEN</th>
																				<th class="text-center" width="90">FECHA ASIGNACION</th>
																				<th class="text-center" colspan="2">USUARIO</th>
																				<th class="text-center" colspan="2">PQR</th>
																				<th class="text-center" width="70">ASIGNADO DESDE</th>
																				<th class="text-right" width="70">PLAZO</th>
																			</tr>
																		</thead>
																		<tbody id="table_ordenesSinCumplir" style="font-size: 13px;">
																			
																		</tbody>
																	</table>
																</div>
															</div>
														</div>
											        <!-- END Ordenes Cumplidas x Certificar -->
											        
											        <!-- Ordenes Cumplidas x Certificar -->
												        <div class="post tab-pane" id="ordenesCumplidasXcertificar">
											            	<div class="row">
						                     					<label class="col-sm-q control-label text-right" style="margin-top:5px;">Ordernar Por</label>
												        		<a style="margin-left:5px;" onclick="buscarOrdenesCumplidasxCertificar(1)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Numero de Orden">Numero de Orden</a>
												        		<a style="margin-left:5px;" onclick="buscarOrdenesCumplidasxCertificar(2)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Fecha de Orden">Fecha de Orden</a>
												        		<a style="margin-left:5px;" onclick="buscarOrdenesCumplidasxCertificar(3)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Fecha de Cumplimiento">Fecha de Cumplimiento</a>
												        		<a style="margin-left:5px;" onclick="buscarOrdenesCumplidasxCertificar(4)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Usuario">Usuario</a>
												        		<a style="margin-left:5px;" onclick="buscarOrdenesCumplidasxCertificar(5)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Pqr">Pqr</a>
												        	</div>
												        	<div class="row marginTop5">
												            	<div class="col-md-12 container-table-list" style="height: 500px; overflow-y: scroll;">
												            		<table id="table" class="table table-condensed table-bordered table-striped">
												                        <thead>
												                            <tr style="background-color: #3c8dbc; color:white;">
												                             	<th class="text-center" width="120">NUMERO</th>
												                             	<th class="text-center" width="90">FECHA ORDEN</th>
												                             	<th class="text-center" width="90">FECHA CUMPLIMIENTO</th>
												                             	<th class="text-center" colspan="2">USUARIO</th>
												                             	<th class="text-center" colspan="2">PQR</th>
												                             	<th class="text-center" width="80">TIEMPO DE ATENCION</th>
												                             	<th class="text-right" width="70">PLAZO</th>
												                            </tr>
												                        </thead>
												                        <tbody id="table_ordenesCumplidasxCertificar" style="font-size: 13px;">
												                            
												                        </tbody>
												                    </table>
												            	</div>
												        	</div>
												        </div>
											        <!-- END Ordenes Cumplidas x Certificar -->
													
													<!-- Ordenes Cumplidas Certificadas -->
												        <div class="post tab-pane" id="ordenesCumplidasCertificada">
											            	<div class="row">
						                     					<label class="col-sm-q control-label text-right" style="margin-top:5px;">Ordernar Por</label>
												        		<a style="margin-left:5px;" onclick="buscarOrdenesCumplidasCertificada(1)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Numero de Orden">Numero de Orden</a>
												        		<a style="margin-left:5px;" onclick="buscarOrdenesCumplidasCertificada(2)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Fecha de Orden">Fecha de Orden</a>
												        		<a style="margin-left:5px;" onclick="buscarOrdenesCumplidasCertificada(3)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Fecha de Cumplimiento">Fecha de Cumplimiento</a>
												        		<a style="margin-left:5px;" onclick="buscarOrdenesCumplidasCertificada(4)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Usuario">Usuario</a>
												        		<a style="margin-left:5px;" onclick="buscarOrdenesCumplidasCertificada(5)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Pqr">Pqr</a>
												        	</div>
												        	<div class="row marginTop5">
												            	<div class="col-md-12 container-table-list" style="height: 500px; overflow-y: scroll;">
												            		<table id="table" class="table table-condensed table-bordered table-striped">
												                        <thead>
												                            <tr style="background-color: #3c8dbc; color:white;">
												                             	<th class="text-center" width="120">NUMERO</th>
												                             	<th class="text-center" width="90">FECHA ORDEN</th>
												                             	<th class="text-center" width="90">FECHA CUMPLIMIENTO</th>
												                             	<th class="text-center" colspan="2">USUARIO</th>
												                             	<th class="text-center" colspan="2">PQR</th>
												                             	<th class="text-center" width="80">TIEMPO DE ATENCION</th>
												                             	<th class="text-right" width="70">PLAZO</th>
												                            </tr>
												                        </thead>
												                        <tbody id="table_ordenesCumplidasCertificada" style="font-size: 13px;">
												                            
												                        </tbody>
												                    </table>
												            	</div>
												        	</div>
												        </div>
											        <!-- END Ordenes Cumplidas Certificadas -->

											        <!-- Ordenes Cumplidas Incumplidas -->
												        <div class="post tab-pane" id="ordenesIncumplidas">
											            	<div class="row">
						                     					<label class="col-sm-q control-label text-right" style="margin-top:5px;">Ordernar Por</label>
												        		<a style="margin-left:5px;" onclick="buscarOrdenesIncumplidas(1)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Numero de Orden">Numero de Orden</a>
												        		<a style="margin-left:5px;" onclick="buscarOrdenesIncumplidas(2)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Fecha de Orden">Fecha de Orden</a>
												        		<a style="margin-left:5px;" onclick="buscarOrdenesIncumplidas(4)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Usuario">Usuario</a>
												        		<a style="margin-left:5px;" onclick="buscarOrdenesIncumplidas(5)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Pqr">Pqr</a>
												        	</div>
												        	<div class="row marginTop5">
												            	<div class="col-md-12 container-table-list" style="height: 500px; overflow-y: scroll;">
												            		<table id="table" class="table table-condensed table-bordered table-striped">
												                        <thead>
												                            <tr style="background-color: #3c8dbc; color:white;">
												                             	<th class="text-center" width="120">NUMERO</th>
												                             	<th class="text-center" width="120">FECHA ORDEN</th>
												                             	<th class="text-center" colspan="2">USUARIO</th>
												                             	<th class="text-center" colspan="2">PQR</th>
												                            </tr>
												                        </thead>
												                        <tbody id="table_ordenesIncumplidas" style="font-size: 13px;">
												                            
												                        </tbody>
												                    </table>
												            	</div>
												        	</div>
												        </div>
													 <!-- END Ordenes Cumplidas Incumplidas -->

											        <!-- Ordenes Anuladas -->
												        <div class="post tab-pane" id="ordenesAnuladas">
											            	<div class="row">
						                     					<label class="col-sm-q control-label text-right" style="margin-top:5px;">Ordernar Por</label>
												        		<a style="margin-left:5px;" onclick="buscarOrdenesAnuladas(1)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Numero de Orden">Numero de Orden</a>
												        		<a style="margin-left:5px;" onclick="buscarOrdenesAnuladas(2)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Fecha de Orden">Fecha de Orden</a>
												        		<a style="margin-left:5px;" onclick="buscarOrdenesAnuladas(4)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Usuario">Usuario</a>
												        		<a style="margin-left:5px;" onclick="buscarOrdenesAnuladas(5)" class="btn btn-default btn-sm" data-toggle="" data-original-title="Ordenar por Pqr">Pqr</a>
												        	</div>
												        	<div class="row marginTop5">
												            	<div class="col-md-12 container-table-list" style="height: 500px; overflow-y: scroll;">
												            		<table id="table" class="table table-condensed table-bordered table-striped">
												                        <thead>
												                            <tr style="background-color: #3c8dbc; color:white;">
												                             	<th class="text-center" width="120">NUMERO</th>
												                             	<th class="text-center" width="120">FECHA ORDEN</th>
												                             	<th class="text-center" colspan="2">USUARIO</th>
												                             	<th class="text-center" colspan="2">PQR</th>
												                            </tr>
												                        </thead>
												                        <tbody id="table_ordenesAnuladas" style="font-size: 13px;">
												                            
												                        </tbody>
												                    </table>
												            	</div>
												        	</div>
												        </div>
													<!-- END Ordenes Anuladas -->

													<!-- Materiales Legalizados -->
												        <div class="post tab-pane" id="materialesLegalizados">
											            	<div class="row">
						                     					<label class="col-sm-q control-label text-right" style="margin-top:5px;">Ordernar Por</label>
												        		<a style="margin-left:5px;" onclick="buscarMaterialesLegalizados(1)" class="btn btn-default btn-sm" data-toggle="" >Numero de Orden</a>
												        		<a style="margin-left:5px;" onclick="buscarMaterialesLegalizados(2)" class="btn btn-default btn-sm" data-toggle="" >Material</a>
												        		<a style="margin-left:5px;" onclick="buscarMaterialesLegalizados(5)" class="btn btn-default btn-sm" data-toggle="" >Fecha</a>
												        		<a style="margin-left:5px;" onclick="buscarMaterialesLegalizados(4)" class="btn btn-default btn-sm" data-toggle="" >Usuario</a>
												        	</div>
												        	<div class="row marginTop5">
												            	<div class="col-md-12 container-table-list" style="height: 500px; overflow-y: scroll;">
												            		<table id="table" class="table table-condensed table-bordered table-striped">
												                        <thead>
												                            <tr style="background-color: #3c8dbc; color:white;">
												                             	<th class="text-center" width="120">NUMERO</th>
												                             	<th class="text-center" width="70">MATERIAL</th>
												                             	<th class="text-right" width="70">CANTIDAD</th>
												                             	<th class="text-right" width="70">VALOR</th>
												                             	<th class="text-center" width="120">FECHA ORDEN</th>
												                             	<th class="text-center" width="70">TIPO LEGALIZCION</th>
												                             	<th class="text-center" width="70">PROPIO</th>
												                             	<th class="text-left">MATERIAL DESCRIPCION</th>
												                             	<th class="text-center" width="70">USUARIO</th>
												                            </tr>
												                        </thead>
												                        <tbody id="table_materialesLegalizados" style="font-size: 13px;">
												                            
												                        </tbody>
												                    </table>
												            	</div>
												        	</div>
												        </div>
											        <!-- END Materiales Legalizados -->

											        <!-- Mano de Obra Legalizada -->
												        <div class="post tab-pane" id="manoDeObraLegalizada">
											            	<div class="row">
						                     					<label class="col-sm-q control-label text-right" style="margin-top:5px;">Ordernar Por</label>
												        		<a style="margin-left:5px;" onclick="buscarMaterialesLegalizados(1)" class="btn btn-default btn-sm" data-toggle="" >Numero de Orden</a>
												        		<a style="margin-left:5px;" onclick="buscarMaterialesLegalizados(2)" class="btn btn-default btn-sm" data-toggle="" >Mano de Obra</a>
												        		<a style="margin-left:5px;" onclick="buscarMaterialesLegalizados(3)" class="btn btn-default btn-sm" data-toggle="" >Fecha</a>
												        		<a style="margin-left:5px;" onclick="buscarMaterialesLegalizados(4)" class="btn btn-default btn-sm" data-toggle="" >Usuario</a>
												        		<a style="margin-left:5px;" onclick="buscarMaterialesLegalizados(5)" class="btn btn-default btn-sm" data-toggle="" >Acta</a>
												        	</div>
												        	<div class="row marginTop5">
												            	<div class="col-md-12 container-table-list" style="height: 500px; overflow-y: scroll;">
												            		<table id="table" class="table table-condensed table-bordered table-striped">
												                        <thead>
												                            <tr style="background-color: #3c8dbc; color:white;">
												                             	<th class="text-center" width="120">NUMERO</th>
												                             	<th class="text-center" colspan="2">MANO DE OBRA</th>
												                             	<th class="text-center" width="70">USUARIO</th>
												                             	<th class="text-right" width="70">CANTIDAD</th>
												                             	<th class="text-right" width="70">VALOR</th>
												                             	<th class="text-center" width="70">ACTA</th>
												                             	<th class="text-center" width="120">FECHA ORDEN</th>
												                             	<th class="text-center" width="70">TIPO LEGALIZCION</th>
												                            </tr>
												                        </thead>
												                        <tbody id="table_manoDeObraLegalizada" style="font-size: 13px;">
												                            
												                        </tbody>
												                    </table>
												            	</div>
												        	</div>
												        </div>
											        <!-- END Mano de Obra Legalizada -->

											        <!-- Acta -->
												        <div class="post tab-pane" id="acta">
												        	<br>	
												        	<div class="row marginTop5">
													            <div class="col-md-5">
												            		<div class="row" style="height: 530px; overflow-y: scroll;">
													            		<div class="col-md-12 container-table-list">
														            		<table id="table" class="table table-condensed table-bordered table-striped">
														                        <thead>
														                            <tr style="background-color: #3c8dbc; color:white;">
														                             	<th class="text-center" width="70">NUMERO</th>
														                             	<th class="text-center" width="120">FECHA</th>
														                             	<th class="text-right" width="100">VALOR BRUTO</th>
														                             	<th class="text-right" width="100">VALOR NETO</th>
														                             	<th class="text-center" width="70">ESTADO</th>
														                            </tr>
														                        </thead>
														                        <tbody id="table_acta" style="font-size: 13px;">
														                            
														                        </tbody>
														                    </table>
														                </div>
													            	</div>
													            	<div class="row marginTop5">
													            		<div class="col-md-12">
													                     	<label for="txtObservacion" class="text-right" style="margin-top:5px; margin-left: 20px; float:left;">Observacion</label>
													                     	<textarea style="float:left; margin-left: 20px; width=50px;" class="form-control input-sm" id="txtObservacion" placeholder="Observacion"></textarea>
												                     	</div>
													            	</div>
												            	</div>
												        		<div class="col-md-6" style="margin-left: 20px;">
												            		<div class="row marginTop5" style="height: 250px; overflow-y: scroll;">
												            			<div class="col-md-12">
													            			<h5><b>Mano de Obra de Acta</b></h5>
														            		<table id="table" class="table table-condensed table-bordered table-striped">
														                        <thead>
														                            <tr style="background-color: #3c8dbc; color:white;">
														                             	<th class="text-center" colspan="2">MANO DE OBRA</th>
														                             	<th class="text-right" width="70">CANTIDAD</th>
														                             	<th class="text-right" width="120">VALOR</th>
														                             	<th class="text-center" width="100">FECHA</th>
														                            </tr>
														                        </thead>
														                        <tbody id="table_manoObraActa" style="font-size: 13px;">
														                            
														                        </tbody>
														                    </table>
													                    </div>
												            		</div>
												            		<br>
												            		<div class="row marginTop5" style="height: 250px; overflow-y: scroll;">
												            			<div class="col-md-12">
														            		<h5><b>Notas Asociadas al Acta</b></h5>
														            		<table id="table" class="table table-condensed table-bordered table-striped">
														                        <thead>
														                            <tr style="background-color: #3c8dbc; color:white;">
														                             	<th class="text-center" colspan="2">CLASE DE NOTA</th>
														                             	<th class="text-center" width="100">SIGNO</th>
														                             	<th class="text-center" width="10">FECHA</th>
														                             	<th class="text-right" width="100">VALOR</th>
														                            </tr>
														                        </thead>
														                        <tbody id="table_notaAsociadaActa" style="font-size: 13px;">
														                            
														                        </tbody>
														                    </table>
													                    </div>
												            		</div>
												            		<div class="row marginTop5">
												            			<div class="col-md-12">
													                     	<label for="txtObservacion" class="text-right" style="margin-top:5px; margin-left: 20px; float:left;">Observacion</label>
													                     	<textarea style="float:left; margin-left: 20px; width=50px;" class="form-control input-sm" id="txtObservacion" placeholder="Observacion"></textarea>
												                     	</div>
													            	</div>
												            	</div>
												        	</div>
												        </div>
											        <!-- END Acta -->

											        <!-- Inventario -->
												        <div class="post tab-pane" id="inventario">
												        	<br>
												        	<div class="row marginTop5">
												            	<div class="col-md-12 container-table-list" style="height: 500px; overflow-y: scroll;">
												            		<table id="table" class="table table-condensed table-bordered table-striped">
												                        <thead>
												                            <tr style="background-color: #3c8dbc; color:white;">
												                             	<th class="text-left" width="120">MATERIAL</th>
												                             	<th class="text-left">DESCRIPCION</th>
												                             	<th class="text-center" width="70">CUPO</th>
												                             	<th class="text-right" width="120">CANTIDAD PROPIA</th>
												                             	<th class="text-right" width="120">VALOR PROPIO</th>
												                             	<th class="text-right" width="120">CANTIDAD PRESTADA</th>
												                             	<th class="text-right" width="120">VALOR PRESTADO</th>
												                            </tr>
												                        </thead>
												                        <tbody id="table_inventario" style="font-size: 13px;">
												                            
												                        </tbody>
												                    </table>
												            	</div>
												        	</div>
												        </div>
											        <!-- END Inventario -->

											         <!-- Nota -->
												        <div class="post tab-pane" id="notas">
												        	<br>
												        	<div class="row marginTop5">
												            	<div class="col-md-12 container-table-list" style="height: 500px; overflow-y: scroll;">
												            		<table id="table" class="table table-condensed table-bordered table-striped">
												                        <thead>
												                            <tr style="background-color: #3c8dbc; color:white;">
												                             	<th class="text-center" width="70">NUMERO</th>
												                             	<th class="text-center" colspan="2">CLASE</th>
												                             	<th class="text-center" width="70">FECHA REGISTRO</th>
												                             	<th class="text-center" width="70">FECHA APLICACION</th>
												                             	<th class="text-right" width="120">VALOR</th>
												                             	<th class="text-center" width="120">ACTA</th>
												                             	<th class="text-center" width="50">ESTADO</th>
												                             	<th class="text-center" width="50">SIGNO</th>
												                            </tr>
												                        </thead>
												                        <tbody id="table_notas" style="font-size: 13px;">
												                            
												                        </tbody>
												                    </table>
												            	</div>
												        	</div>
												        </div>
											        <!-- END Nota -->

											        <!-- Elementos de protección -->
												        <div class="post tab-pane" id="elmento_prot">
												        	<br>
												        	<div class="row marginTop5">
												            	<div class="col-md-12 container-table-list" style="height: 500px; overflow-y: scroll;">
												            		<table id="table" class="table table-condensed table-bordered table-striped">
												                        <thead>
												                            <tr style="background-color: #3c8dbc; color:white;">
												                             	<th class="text-center" width="120">COD. MATERIAL</th>
												                             	<th class="text-left" colspan="2">MATERIAL</th>
												                             	<th class="text-right" width="70">CANTIDAD</th>
												                             	<th class="text-center" width="130">FECHA ULTIMA ENTREGA</th>
												                             	<th class="text-center" width="130">FECHA MINIMA PARA REPOSICIÓN</th>
												                             	<th class="text-center" width="130">FECHA DE REPOSICIÓN</th>
												                            </tr>
												                        </thead>
												                        <tbody id="table_elmento_prot" style="font-size: 13px;">
												                            
												                        </tbody>
												                    </table>
												            	</div>
												        	</div>
												        </div>
											        <!-- END Elementos de protección -->

											        <!-- Herramientas -->
												        <div class="post tab-pane" id="herramientas">
												        	<br>
												        	<div class="row marginTop5">
												            	<div class="col-md-12 container-table-list" style="height: 500px; overflow-y: scroll;">
												            		<table id="table" class="table table-condensed table-bordered table-striped">
												                        <thead>
												                            <tr style="background-color: #3c8dbc; color:white;">
												                             	<th class="text-center" width="120">COD. MATERIAL</th>
												                             	<th class="text-left" colspan="2">MATERIAL</th>
												                             	<th class="text-right" width="70">CANTIDAD</th>
												                             	<th class="text-center" width="130">FECHA ULTIMA ENTREGA</th>
												                             	<th class="text-center" width="130">FECHA MINIMA PARA REPOSICIÓN</th>
												                             	<th class="text-center" width="130">FECHA DE REPOSICIÓN</th>
												                            </tr>
												                        </thead>
												                        <tbody id="table_herramientas" style="font-size: 13px;">
												                            
												                        </tbody>
												                    </table>
												            	</div>
												        	</div>
												        </div>
											        <!-- END Herramientas -->

										        </div><!-- /.tab-content -->
										    </div>  <!-- Fin nav TAB -->
				                		</div>
				                	</div>
			                    </div>
							</div>
						</div>
					</div>
				</section>

				<form method="POST" action="cusuOrden.php" class="display-none" id="formDetalleOrdenPost">
					<input type="hidden" id="txtIdOrdenPost" name="txtIdOrdenPost">
					<input type="hidden" id="txtIdUsuarioPost" name="txtIdUsuarioPost">
					<input type="hidden" id="txtIdTecnicoPost" name="txtIdTecnicoPost">

					<input type="hidden" id="txtIdSelecttecnico">
					<input type="hidden" id="txtIdSelecttecnico_tab" value="1">
				</form>

			</div>
		</div>
		<?php require 'template/footer.php'; ?>
	</div>
</body>
<?php require 'template/end.php'; ?>
<script src="js/ctecni.js"></script>
<!--  Detectar cambios en las Formas    -->
<script src="assets/js/detectaCambiosEnFormas.js"></script>
<!--  Seleccionar nuevo Item Talas    -->
<!-- <script src="assets/js/selectedNewRow.js"></script> -->
<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>