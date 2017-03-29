<?php
	require 'template/start.php';
	if(isset($_REQUEST['txtDocumentoMovimiento'])){
		$conn = require 'template/sql/conexion.php';
		$txtDocumento = $_REQUEST['txtDocumentoMovimiento'];
		//cargar datos
			$query ="SELECT moviinve.MOINCODI AS codMov, moviinve.MOINFECH AS fechaMov, tipomovi.TIMOCODI AS codTipo, tipomovi.TIMODESC AS nomTipo,
						tipomovi.TIMOSAEN AS tipoTipo, orig.BODECODI AS codOrg, orig.BODENOMB AS nomOrg, dest.BODECODI AS codDes, dest.BODENOMB AS nomDes, 
						moviinve.MOINVLOR AS valor, moviinve.MOINSOPO AS soport, moviinve.MOINDOSO AS docSopo, moviinve.MOINUSUA AS usuReg, moviinve.MOINOBSE AS obs
					FROM moviinve
						JOIN bodega AS orig ON orig.BODECODI = moviinve.MOINBOOR
						JOIN bodega AS dest ON dest.BODECODI = moviinve.MOINBODE
						JOIN tipomovi ON tipomovi.TIMOCODI =  moviinve.MOINTIMO
					WHERE moviinve.MOINCODI = $txtDocumento";
			$respuesta = $conn->prepare($query) or die ($sql);
			if(!$respuesta->execute()) return false;
			if($respuesta->rowCount()>0){
				while ($row=$respuesta->fetch()){
					$data2 = $row['fechaMov'];
					$data3 = $row['codTipo'];

					$data4 = $row['nomTipo'];
					$data5 = $row['tipoTipo'];
					
					$data6 = $row['codOrg'];
					$data7 = utf8_encode($row['nomOrg']);

					$data8 = $row['codDes'];
					$data9 = utf8_encode($row['nomDes']);

					$data10 = $row['valor'];
					$data11 = $row['soport'];
					$data12 = $row['docSopo'];
					$data13 = $row['usuReg'];
					$data14 = $row['obs'];

					if($data5=='E'){
						$es = '<input type="radio" name="tipoMov" checked> Entrada &nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="tipoMov"> Salida';
					}else{
						$es = '<input type="radio" name="tipoMov"> Entrada &nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="tipoMov" checked> Salida';
					}
				}
			}
		//
		//cargar materiales
			$tableMat = '';
			$query ="SELECT material.MATECODI, material.MATEDESC, matemoin.MAMIPROP, matemoin.MAMIAFCU, matemoin.MAMICANT, matemoin.MAMIVLOR
                 FROM matemoin
                    JOIN material ON material.MATECODI = matemoin.MAMIMATE
                 WHERE matemoin.MAMIMOIN = $txtDocumento";
			$respuesta = $conn->prepare($query) or die ($sql);
			if(!$respuesta->execute()) return false;
			if($respuesta->rowCount()>0){
				while ($row=$respuesta->fetch()){
					if($row["MAMIPROP"]=='S'){
						$MAMIPROP = 'Movio Inventario Propio';
					}else{
						$MAMIPROP = 'No Movio Inventario Propio';
					}

					if($row["MAMIAFCU"]=='S'){
						$MAMIAFCU = 'Afecto Cupo';
					}else{
						$MAMIAFCU = 'No Afecto Cupo';
					}

					$tableMat .= 
						'<tr>
							<td><input type="text" class="form-control input-sm text-center" value="'.$row["MATECODI"].'" readonly></td>
							<td><input type="text" class="form-control input-sm" value="'.$row["MATEDESC"].'" readonly></td>
							<td><input type="text" class="form-control input-sm text-center" value="'.$MAMIPROP.'" readonly></td>
							<td><input type="text" class="form-control input-sm text-center" value="'.$MAMIAFCU.'" readonly></td>
							<td><input type="text" class="form-control input-sm text-right" value="'.$row["MAMICANT"].'" readonly></td>
							<td><input type="text" class="form-control input-sm text-right" value="'.$row["MAMIVLOR"].'" readonly></td>
						</tr>';                                   
				}   
			}
		//
	}else{
		$txtDocumento = '';
		$es = '';
		$tableMat = '';
		$data2 = '';
		$data3 = '';
		$data4 = '';
		$data5 = '';
		$data6 = '';
		$data7 = '';
		$data8 = '';
		$data9 = '';
		$data10 = '';
		$data11= '';
		$data12 = '';
		$data13 = '';
		$data14 = '';
	}
?>
<!--  Material Dashboard CSS    -->
<link href="assets/css/material-dashboard.css" rel="stylesheet"/>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">
		<?php require 'template/menu.php'; ?>
		<div class="content-wrapper">
			<div class="container">

	            <div class="modal fade" id="modalMovimientos">
	             	<div class="modal-dialog" style="width: 80%">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">LISTADO DE MOVIMIENTOS</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12" style="height: 350px; overflow-y: scroll;">
				                		<table id="tableDepa" class="table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left" width="150">FECHA</th>
					                              	<th class="text-left">TIPO MOVIMIENTO</th>
					                              	<th class="text-left">BODEGA ORIGEN</th>
					                              	<th class="text-left">BODEGA DESTINO</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php 
		                                            $query ='SELECT moviinve.MOINCODI AS cod, moviinve.MOINFECH AS fecha, tipomovi.TIMODESC AS tipo, orig.BODENOMB AS org, dest.BODENOMB AS des 
															 FROM moviinve
																JOIN bodega AS orig ON orig.BODECODI = moviinve.MOINBOOR
																JOIN bodega AS dest ON dest.BODECODI = moviinve.MOINBODE
																JOIN tipomovi ON tipomovi.TIMOCODI =  moviinve.MOINTIMO
															 ORDER BY moviinve.MOINFECH DESC';
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="addMovimiento('.$row['cod'].')">
		                                                    		<td class="text-center">'.$row['cod'].'</td>
		                                                    		<td>'.$row['fecha'].'</td>
		                                                    		<td>'.$row['tipo'].'</td>
		                                                    		<td>'.utf8_encode($row['org']).'</td>
		                                                    		<td>'.utf8_encode($row['des']).'</td>
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
	                	<li><a href="#">Almacen</a></li>
	                	<li class="active">Consulta de Movimiento Almacen</li>
	             	</ol>
	            </section>

				<div id="div_todos_movimientos" class="display-none"></div>
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
				                        		<input value="<?= $txtDocumento ?>" type="text" class="form-control input-sm" id="txtMovCod" placeholder="Numero" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-4 text-center" id="divTipoMov">
												  <?php
													if($txtDocumento!=''){
														echo $es;
													}else{
													?>
														<input type="radio" name="tipoMov"> Entrada &nbsp;&nbsp;&nbsp;&nbsp;
														<input type="radio" name="tipoMov"> Salida
													<?php
													}
												?>
				                      		</div>
					                     	<label for="txtClase" class="col-sm-1 control-label" style="margin-top:5px;">Fecha</label>
				                      		<div class="col-sm-2">
				                        		<input value="<?= $data2 ?>" type="text" class="form-control input-sm text-right" id="txtFecha" readonly>
				                      		</div>
					                    </div>
				                	</div>
			                    	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">En</label>
					                     	<div class="col-sm-2">
				                        		<input value="<?= $data6 ?>" type="text" class="form-control input-sm" id="txtEnCod" placeholder="Codigo" onkeypress="solonumeros()" readonly>
				                      		</div>
				                      		<div class="col-sm-4">
				                        		<input value="<?= $data7 ?>" type="text" class="form-control input-sm" id="txtEnNomb" placeholder="Nombre de la Bodega principal" readonly>
				                      		</div>
				                      		<label for="txtClase" class="col-sm-1 control-label" style="margin-top:5px;">Valor</label>
				                      		<div class="col-sm-2">
				                        		<input value="<?= $data10 ?>" type="text" class="form-control input-sm text-right" id="txtValor" placeholder="Valor" onkeypress="solonumeros()" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Tipo de Movimiento</label>
					                     	<div class="col-sm-2">
				                        		<input value="<?= $data3 ?>" type="text" class="form-control input-sm" id="txtTipoCod" placeholder="Codigo" onkeypress="solonumeros()" readonly>
				                      		</div>
				                      		<div class="col-sm-4">
				                        		<input value="<?= $data4 ?>" type="text" class="form-control input-sm" id="txtTipoNomb" placeholder="Nombre del Tipo Movimiento" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Bodega</label>
					                     	<div class="col-sm-2">
				                        		<input value="<?= $data8 ?>" type="text" class="form-control input-sm" id="txtBodCod" placeholder="Codigo" onkeypress="solonumeros()" readonly>
				                      		</div>
				                      		<div class="col-sm-4">
				                        		<input value="<?= $data9 ?>" type="text" class="form-control input-sm" id="txtBodNomb" placeholder="Nombre de la bodega" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Soporte</label>
					                     	<div class="col-sm-2">
				                        		<input value="<?= $data11 ?>" type="text" class="form-control input-sm" id="txtSopCod" placeholder="Codigo" onkeypress="solonumeros()" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Documente Soporte</label>
					                     	<div class="col-sm-3">
				                        		<input value="<?= $data12 ?>" type="text" class="form-control input-sm" id="txtSopDoc" placeholder="Codigo" onkeypress="solonumeros()" readonly>
				                      		</div>
				                      		<div class="col-sm-2"></div>
				                      		<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Registrado por</label>
					                     	<div class="col-sm-2">
				                        		<input value="<?= $data13 ?>" type="text" class="form-control input-sm" id="txtRegis" placeholder="Registrado" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Observacion</label>
					                     	<div class="col-sm-9">
					                     		<textarea rows="4" class="form-control input-sm movObEntrada_border_azul" id="txtObser" placeholder="Observacion del movimiento" readonly><?= $data14 ?></textarea>
				                      		</div>
					                    </div>
				                	</div>
				                	<hr>
				                	<h4 style="margin-left: 10px;">Materiales</h4>
				                	<hr>
				                	<div class="row marginTop3">
				                		<div class="col-md-12">
				                			<input type="hidden" id="swCheckTodos" value="0">
				                			<div id="tableOrdenes" style="height: 460px; overflow-y: scroll;">
						                		<table class="table table-bordered table-condensed">
													<thead>
														<tr style="background-color: #3c8dbc; color:white;">
															<th class="text-center" width="100">MATERIAL</th>
															<th class="" >DESCRIPCION DEL MATERIAL</th>
															<th class="text-center" width="170"></th>
															<th class="text-center" width="170"></th>
															<th class="text-right" width="170">CANTIDAD</th>
															<th class="text-right" width="170">VALOR</th>
														</tr>
													</thead>
													<tbody id="table_tbody">
														<?= $tableMat ?>
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
<script src="js/calma.js"></script>
<!--  Detectar cambios en las Formas    -->
<script src="assets/js/detectaCambiosEnFormas.js"></script>
<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>