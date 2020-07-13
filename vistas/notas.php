<!--
    Nombre: notas.php
    Objetivo/propósito: pantalla de notas clínicas.
    Creado por: GHAMASWARE
                -Ing. Casillas Toledo Mauricio Enrique
                -Ing. Gómez Segovia Álvaro
                -Ing. Jiménez Ruiz Gustavo Alfredo
                -Ing. Ramírez Martínez Humberto
    Fecha: 2/enero/2020
    Versión: 1.0
-->

<?php
//Activamos almacenamiento en el buffer
ob_start();
session_start();
if((!isset($_SESSION["nombre"]))&&(!isset($_SESSION["nombre_usuario"]))){
  header("Location: login.html");
}else{
  require 'header.php';
  if($_SESSION["pacientes"]==1)
{
?>    
      <div class="content-wrapper">                
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box box-warning">
                    <div class="box-header with-border">
                          <h1 class="box-title pull-center">Notas clínicas</h1>                          
                        <div class="box-tools pull-right">
                          <button class="btn btn-success" onclick="mostrarFormulario(true)" id="btnAgregar"><i class="fa fa-plus-circle"></i> Registro nuevo</button>
                        </div>
                    </div>
                    <div class="panel-body table-responsive" id="listadoRegPac">
                      <table id="tablalistado" class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                          <th>Opciones</th>
                          <th>Nombre de paciente</th>
                          <th>Nombre de medico</th>
                          <th>Fecha de registro</th>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        <tfoot>
                          <th>Opciones</th>
                          <th>Nombre de paciente</th>
                          <th>Nombre de medico</th>
                          <th>Fecha de registro</th>
                        </tfoot>
                      </table>
                    </div>                                        
                    <div class="panel-body" id="formularioRegPac" style="margin-left:1rem; font-size:2rem;">
                      <label for="id_medico">Nombre del médico:</label>
                        <select name="id_medico" id="id_medico" class="form-control selectpicker" data-live-search="true" required>
                        </select>
                      <form name="formulario" id="formulario" method="POST">
                        <label for="id_paciente">Nombre del paciente:</label>
                        <select name="id_paciente" id="id_paciente" class="form-control selectpicker" data-live-search="true" required>
                        </select>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <label>Notas clínicas: </label>
                          <textarea rows="15" cols="50" class="form-control" id="notas_clinicas" name="notas_clinicas" oninput="auto_grow(this)">Puedes dar clic en vaciar notas para comenzar a agregar notas de este paciente.
                          Asegúrate de que el paciente no tenga notas existentes, si no lo sabes da clic en cancelar y corrobóralo.</textarea>
                        </div>
                        <div>
                          <button class="btn btn-primary" type="submit" id="btnGuardar1" onclick="guardaryeditar(event)"><i class="fa fa-save"></i> Guardar</button>                          
                          <button class="btn btn-success" onclick="imprimir(event)" type="button" id="btnCancelar"><i class="fa fa-print"></i> Imprimir</button>
                          <button class="btn btn-danger" onclick="cancelarFormulario()" type="button" id="btnCancelar1"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>                          
                          <button class="btn btn-danger pull-right" type="button" id="btnGuardar2" onclick="vaciarForm1(event)"><i class="fa fa-save"></i> Vaciar notas</button>
                        </div>
                      </form>                      
                    </div>                    
                  </div>
              </div>
          </div>
      </section>
    </div>
<?php
}
else
{
  require 'noacceso.php';
}
require 'footer.php';
?>
<script type="text/javascript" src="scripts/notas.js"></script>
<?php  
}
ob_end_flush();
?>