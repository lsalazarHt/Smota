<a id="btnGuardar" class="btn btn-primary btn-xs disabled" data-toggle="tooltip" data-original-title="Guardar"><i class="fa fa-save"></i></a>
<a id="btnNuevo" class="btn btn-success btn-xs disabled" data-toggle="tooltip" data-original-title="Nuevo"><i class="fa fa-plus"></i></a>
<a id="btnConsulta" class="btn btn-default btn-xs" data-toggle="tooltip" data-original-title="Consultar"><i class="fa fa-binoculars"></i></a>
<a id="btnCancelar" class="btn btn-default btn-xs disabled" data-toggle="tooltip" data-original-title="Cancelar Consultar"><i class="fa fa-eraser"></i></a>
<a id="btnEliminar" class="btn btn-danger btn-xs disabled" data-toggle="tooltip" data-original-title="Borrar Registro"><i class="fa fa-trash-o"></i></a>

<a id="btnPrimer" class="btn btn-primary btn-xs disabled" data-toggle="tooltip" data-original-title="Primer Registro"><i class="fa fa-fast-backward"></i></a>
<a id="btnAnterior" class="btn btn-primary btn-xs disabled" data-toggle="tooltip" data-original-title="Registro Anterior"><i class="fa fa-step-backward"></i></a>
<a id="btnSiguiente" class="btn btn-primary btn-xs disabled" data-toggle="tooltip" data-original-title="Registro Siguiente"><i class="fa fa-step-forward"></i></a>
<a id="btnUltimo" class="btn btn-primary btn-xs disabled" data-toggle="tooltip" data-original-title="Ultimo Registro"><i class="fa fa-fast-forward"></i></a>
<a id="btnListaValores" class="btn btn-warning btn-xs" data-toggle="tooltip" data-original-title="Lista de Valores"><i class="fa fa-list-alt"></i></a>

<a id="btnEditor" class="btn btn-default btn-xs" data-toggle="tooltip" data-original-title="Editor"><i class="fa fa-clipboard"></i></a>
<a id="btnImprimir" class="btn btn-default btn-xs disabled" data-toggle="tooltip" data-original-title="Imprimir"><i class="fa fa-print"></i></a>
<a id="btnAyuda" class="btn btn-primary btn-xs" data-toggle="tooltip" data-original-title="Ayuda"><i class="fa fa-question"></i></a>

<!--
<input type="hidden" id="txt_sw_salir" value="0">
-->

<div class="modal fade" id="editModal">
 	<div class="modal-dialog">
    	<div class="modal-content">
            <div class="modal-header" style="background-color: #3c8dbc; color:white;">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">EDITOR</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="margin-top: 10px;">
                    <div class="form-group">
                     	<label class="col-sm-1"></label>
                  		<div class="col-sm-10">
                  			<textarea class="form-control" id="txtCampEditor" rows="5"></textarea>
                  		</div>
                    </div>
                </div>
            </div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-primary" onclick="descargarEditor()">Aceptar</button>
          	</div>
    	</div><!-- /.modal-content -->
   	</div><!-- /.modal-dialog -->
</div>