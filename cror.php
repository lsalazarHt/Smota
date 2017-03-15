<?php 
	$conn = require 'template/sql/conexion.php';
	$query ="SELECT descripcion FROM contratista WHERE id = 1";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
            	$nomContratista = $row['descripcion'];                        
            }
        }
?>
<?php require 'template/start.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">
		<?php require 'template/menu.php'; ?>
		<div class="content-wrapper">
			<div class="container">
				
				<div class="modal fade" id="modalCuadrillas">
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
	            <div class="modal fade" id="modalTecnicos">
	             	<div class="modal-dialog" style="width:70%;">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">TECNICOS</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12">
				                		<table id="tableDepa" class="tableJs table table-bordered table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php 
		                                            //$conn = require 'inc/clases/conexion.php';
		                                            $query ="SELECT * FROM tecnico WHERE TECNESTA='A' ORDER BY TECNCODI";
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="buscarTecnico(\''.$row['TECNCODI'].'\')">
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
	            <div class="modal fade" id="modalUsuarios">
	             	<div class="modal-dialog" style="width:70%;">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">USUARIOS</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12">
				                		<table id="tableDepa" class="tableJs table table-bordered table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php 
		                                            //$conn = require 'inc/clases/conexion.php';
		                                            $query ="SELECT * FROM usuarios ORDER BY USUCODI";
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="buscarUsuario(\''.$row['USUCODI'].'\')">
		                                                    		<td class="text-center">'.$row['USUCODI'].'</td>
		                                                    		<td>'.utf8_encode($row['USUNOMB']).'</td>
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
			                    <h4 class="modal-title">TRABAJO ENCONTRADO</h4>
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

				<section class="content-header">
	             	<?php include 'template/sub_menu.php' ?>
	            	<ol class="breadcrumb">
	                	<li><a href="#">Ordenes</a></li>
	                	<li class="active">Crear Orden Legalizada (Hija/Padre)</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Orden de Trabajador a Registrar</h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body">
			                    	<div id="divConsultarTecnicos" class="display-none"></div>
			                    	<div class="row">
					                	<div class="form-group">
					                     	<label class="col-sm-2 control-label text-right" style="margin-top:5px;"></label>
					                     	<div class="col-sm-3">
					                     		<input id="selectOrdHija" onclick="selectOrd()" type="radio" name="radioOrden" value="h" checked> Hija
					                     		<input id="selectOrdPadre" onclick="selectOrd()" type="radio" name="radioOrden" value="p" style="margin-left: 10px;"> Padre
				                      		</div>

					                     	<label class="col-sm-2 control-label text-right" style="margin-top:5px;">OT Padre</label>
					                     	<div class="col-sm-5">
				                        		<input id="txtDepPadre" style="float:left; width:50px;" type="text" class="form-control input-sm" onkeypress="solonumeros()">
				                        		<input id="txtLocaPadre" style="float:left; width:50px; margin-left:8px;" type="text" class="form-control input-sm" onkeypress="solonumeros()">
				                        		<input id="txtNumbPadre" style="float:left; width:100px; margin-left:8px;" type="text" class="form-control input-sm" onkeypress="solonumeros()">
				                      		</div>
					                    </div>
				                	</div>
			                    	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtCod" class="col-sm-2 control-label text-right" style="margin-top:5px;">Orden</label>
					                     	<div class="col-sm-3">
				                        		<input id="txtDepOrd" style="float:left; width:50px;" type="text" class="form-control input-sm" onkeypress="solonumeros()">
				                        		<input id="txtLocaOrd" style="float:left; width:50px; margin-left:8px;" type="text" class="form-control input-sm" onkeypress="solonumeros()">
				                        		<input id="txtNumbOrd" style="float:left; width:100px; margin-left:8px;" type="text" class="form-control input-sm" onkeypress="solonumeros()">
				                      		</div>

				                      		<label class="col-sm-2 control-label text-right" style="margin-top:5px;">Fecha Orden</label>
					                     	<div class="col-sm-4">
				                        		<input id="txtFechOrd" style="float:left; width:150px;" type="date" class="form-control input-sm" onkeypress="solonumeros()">
				                      		</div>

					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtCod" class="col-sm-2 control-label text-right" style="margin-top:5px;">Cuadrilla</label>
					                     	<div class="col-sm-4">
				                        		<input id="txtCodiCuad" style="float:left; width:50px;" type="text" class="form-control input-sm" onkeypress="solonumeros()" readonly value="1">
				                        		<input id="txtNombCuad" style="float:left; width:250px; margin-left:8px;" type="text" class="form-control input-sm" readonly <?php echo 'value="'.$nomContratista.'"' ?>>
				                      		</div>

				                      		<label class="col-sm-1 control-label text-right" style="margin-top:5px;">Tecnico</label>
					                     	<div class="col-sm-5">
				                        		<input id="txtCodiTecn" style="float:left; width:50px;" type="text" class="form-control input-sm" onkeypress="solonumeros()" onclick="swModal(2)">
				                        		<input id="txtNombTecn" style="float:left; width:250px; margin-left:8px;" type="text" class="form-control input-sm" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtCod" class="col-sm-2 control-label text-right" style="margin-top:5px;">Usuario</label>
					                     	<div class="col-sm-4">
				                        		<input id="txtCodiUsua" style="float:left; width:50px;" type="text" class="form-control input-sm" onkeypress="solonumeros()" onclick="swModal(3)">
				                        		<input id="txtNombUsua" style="float:left; width:250px; margin-left:8px;" type="text" class="form-control input-sm" readonly>
				                      		</div>
				                      		<label class="col-sm-1 control-label text-right" style="margin-top:5px;">Cumplida</label>
					                     	<div class="col-sm-5" id="divCheck">
				                        		<input id="txtCumpOrd" type="checkbox" style="margin-top: 10px;">
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtDireccion" class="col-sm-2 control-label text-right" style="margin-top:5px;">Direccion</label>
					                     	<div class="col-sm-7">
				                        		<input id="txtDireUsua" type="text" class="form-control input-sm" onclick="editor('txtDireUsua')" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtCod" class="col-sm-2 control-label text-right" style="margin-top:5px;">Trabajo Encontrado</label>
					                     	<div class="col-sm-8">
				                        		<input id="txtCodTrab" style="float:left; width:50px;" type="text" class="form-control input-sm" onkeypress="solonumeros()" onclick="swModal(4)">
				                        		<input id="txtNomTrab" style="float:left; width:565px; margin-left:8px;" type="text" class="form-control input-sm" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtHoraInicio" class="col-sm-2 control-label text-right" style="margin-top:5px;">Hora Inicial</label>
					                     	<div class="col-sm-2">
				                        		<input type="time" class="form-control input-sm" id="txtHoraInicio">
				                      		</div>
					                     	<label for="txtHoraFinal" class="col-sm-2 control-label text-right" style="margin-top:5px;">Hora Final</label>
					                     	<div class="col-sm-2">
				                        		<input type="time" class="form-control input-sm" id="txtHoraFinal">
				                      		</div>
					                    </div>
				                	</div>
				                	<br>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtObservacion" class="col-sm-2 control-label text-right" style="margin-top:5px;">Observacion en la Legalizacion</label>
					                     	<div class="col-sm-7">
					                     		<textarea class="form-control input-sm" id="txtObservacion" rows="4" onclick="editor('txtObservacion')"></textarea>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
				                		<div class="col-md-6">
						                	<fieldset>
						                		<legend><a class="" data-toggle="tooltip" data-original-title="Agregar" id="addManoObra"><i class="fa fa-plus"></i></a> Mano de Obra</legend>
						                		<div style="height: 190px; overflow-y: scroll;">
							                		<input type="hidden" id="contRowMano">
							                		<table id="tableManoObra" class="table table-bordered table-condensed">
							                			<tr style="background-color: #3c8dbc; color:white;">
							                				<td class="text-right" width="80"></td>
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
						                		<legend><a class="" data-toggle="tooltip" data-original-title="Agregar" id="addMateriales"><i class="fa fa-plus"></i></a> Materiales</legend>
						                		<div style="height: 190px; overflow-y: scroll;">
							                		<input type="hidden" id="contRowMate">
							                		<table id="tableMateriales" class="table table-bordered table-condensed">
							                			<tr style="background-color: #3c8dbc; color:white;">
							                				<td class="text-right" width="80"></td>
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

				<form method="POST" action="cusuOrden.php" class="display-none" id="formDetalleOrdenPost">
					<input type="hidden" id="txtIdOrdenPost" name="txtIdOrdenPost">
					<input type="hidden" id="txtIdUsuarioPost" name="txtIdUsuarioPost">
				</form>

			</div>
		</div>
		<?php require 'template/footer.php'; ?>
	</div>
</body>
<?php require 'template/end.php'; ?>
<script src="js/cror.js"></script>