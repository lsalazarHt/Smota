<?php require 'template/start.php'; ?>
<?php 
	date_default_timezone_set('America/Bogota');
	$fecha = date('Y-m-d');

	function obtenerTecnico($cod){
		$conn = require 'template/sql/conexion.php';
		$nom = '';
		$query ="SELECT * FROM tecnico WHERE TECNCODI = $cod";
	    $respuesta = $conn->prepare($query) or die ($sql);
	    if(!$respuesta->execute()) return false;
	    if($respuesta->rowCount()>0){
	        while ($row=$respuesta->fetch()){
	        	$nom = utf8_encode($row['TECNNOMB']);                              
	        }   
	    }
	    return $nom;
	}
	//Autor: JOSH BRITO
	//Autor
?>
<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">
		<?php require 'template/menu.php'; ?>
		<div class="content-wrapper">
			<div class="container">

	            <div class="modal fade" id="modalNotas">
	             	<div class="modal-dialog" style="width: 70%;">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">NOTA</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12" style="height: 298px; overflow-y: scroll;">
				                		<table id="tableDepa" class="tableJs table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="70">CODIGO</th>
					                              	<th class="text-center" width="100">FECHA</th>
					                              	<th class="text-center">FECHA APLICACION</th>
					                              	<th class="text-center" colspan="2">TECNICO</th>
					                              	<th class="text-right">VALOR</th>
					                              	<th class="text-center" width="50">TIPO</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php 
		                                            //$conn = require 'inc/clases/conexion.php';
		                                            $query ='SELECT * FROM nota ORDER BY NOTACODI';
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                	$tec = obtenerTecnico($row['NOTATECN']);
		                                                    echo 
		                                                    	'<tr onclick="buscarNota('.$row['NOTACODI'].')">
		                                                    		<td class="text-center">'.str_pad($row['NOTACODI'],3,"0", STR_PAD_LEFT).'</td>
		                                                    		<td class="text-center">'.$row['NOTAFECH'].'</td>
		                                                    		<td class="text-center">'.$row['NOTAFEAP'].'</td>
		                                                    		<td class="text-center">'.$row['NOTATECN'].'</td>
		                                                    		<td class="text-center">'.$tec.'</td>
		                                                    		<td class="text-right">$ '.number_format($row['NOTAVALO'],0,"",".").'</td>
		                                                    		<td class="text-center">'.$row['NOTASIGN'].'</td>
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
	            <div class="modal fade" id="modalClaseNota">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">CLASES DE NOTA</h4>
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
		                                            $query ='SELECT * FROM clasnota ORDER BY CLNOCODI';
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="addClase('.str_pad($row['CLNOCODI'],2,"0", STR_PAD_LEFT).',\''.$row['CLNODESC'].'\')">
		                                                    		<td>'.str_pad($row['CLNOCODI'],2,"0", STR_PAD_LEFT).'</td>
		                                                    		<td>'.$row['CLNODESC'].'</td>
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
	                	<li><a href="#">Consultas</a></li>
	                	<li class="active">Notas</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Notas</h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body">
			                    <input type="hidden" id="swEstadoTecnico" value="0" readonly>
			                    <div id="divConsultarTecnicos" class="display-none"></div>
			                    
			                    	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Codigo</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtNotCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Clase de Nota</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtClasCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-6">
				                        		<input type="text" class="form-control input-sm" id="txtClasNomb" placeholder="Nombre de la Nota" readonly>
				                      		</div>
					                    </div>
				                	</div>
			                    	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtCod" class="col-sm-2 control-label text-right" style="margin-top:5px;">Fecha</label>
					                     	<div class="col-sm-2">
				                        		<input type="date" class="form-control input-sm" id="txFech" >
				                      		</div>
				                      		<div class="col-sm-3"></div>
				                      		<div class="col-sm-2">
				                        		<input type="radio" name="tipoRadio" value="D" id="radioDebito" checked> DEBITO
				                      		</div>
				                      		<div class="col-sm-2">
				                        		<input type="radio" name="tipoRadio" value="C" id="radioCredito"> CREDITO
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtCod" class="col-sm-2 control-label text-right" style="margin-top:5px;">Fecha de Aplicacion</label>
					                     	<div class="col-sm-2">
				                        		<input type="date" class="form-control input-sm" id="txFecApli" placeholder="Fecha Aplicacion">
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Codigo Tecnico</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtTecCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-6">
				                        		<input type="text" class="form-control input-sm" id="txtTecNomb" placeholder="Nombre de Tecnico" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtCod" class="col-sm-2 control-label text-right" style="margin-top:5px;">Valor</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtValor" placeholder="Valor de la nota" onkeypress="solonumeros()">
				                      		</div>
					                    </div>
				                	</div>
									<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtNom" class="col-sm-2 control-label text-right" style="margin-top:5px;">Observacion</label>
				                      		<div class="col-sm-8">
				                      			<textarea id="txtObserv" class="form-control input-sm" placeholder="Observacion" rows="4" onclick="editor('txtObserv')"></textarea>
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
<script src="js/cnota.js"></script>