<?php
/*Nombre: cita.php
Objetivo/propósito: pantalla para generar citas de pacientes.
Creado por: GHAMASWARE
            -Ing. Casillas Toledo Mauricio Enrique
            -Ing. Gómez Segovia Álvaro
            -Ing. Jiménez Ruiz Gustavo Alfredo
            -Ing. Ramírez Martínez Humberto
Fecha: 28/diciembre/2019
Versión: 1.0*/

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
                          <h1 class="box-title pull-center">Citas</h1>                          
                        <div class="box-tools pull-right">
                          <button class="btn btn-success" onclick="mostrarFormulario(true)" id="btnAgregar"><i class="fa fa-plus-circle"></i> Nueva cita</button>
                        </div>
                    </div>                                        
                    <div class="panel-body table-responsive" id="listadoRegCita">
                      <table id="tablalistadoCita" class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                          <th>Opciones</th>
                          <th>Nombre de Paciente</th>
                          <th>Fecha</th>
                          <th>Nombre de médico</th>
                          <th>Especialidad</th>
                          <th>Hora inicial</th>
                          <th>Hora final</th>
                          <th>Comentarios</th>
                          <th>Estado</th>                           
                        </thead>
                        <tbody>
                            
                        </tbody>
                        <tfoot>
                          <th>Opciones</th>
                          <th>Nombre de Paciente</th>
                          <th>Fecha</th>
                          <th>Nombre de médico</th>
                          <th>Especialidad</th>
                          <th>Hora inicial</th>
                          <th>Hora final</th>
                          <th>Comentarios</th>
                          <th>Estado</th>             
                        </tfoot>
                      </table>
                    </div>
                    <div class="panel-body" id="formularioRegCita">
                      <form name="formularioCita" id="formularioCita" method="POST">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Seleccione el paciente con cita:</label>
                          <input type="hidden" name="id_cita" id="id_cita">
                          <select name="id_paciente" id="id_paciente" class="form-control selectpicker" data-live-search="true" required>
                          </select>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Medico que registra la cita:</label>
                          <input type="hidden" class="form-control" name="id_medico" id="id_medico" value="<?php if($_SESSION['tipo_persona']=='medico'){echo $_SESSION['id_medico'];}else{echo '3';}?>">
                          <input type="text" class="form-control" name="nombre_medico" id="nombre_medico" value="<?php if($_SESSION['tipo_persona']=='medico'){echo $_SESSION['nombre'];}else{echo $_SESSION['nombre_usuario'];}?>" disabled required>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Dia de la cita:</label>
                          <input type="date" class="form-control" name="fecha" id="fecha" required>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Hora inicial (Se redondea):</label>
                          <input type="time" class="form-control" name="hora_inicio" id="hora_inicio" required>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">                          
                          <input type="hidden" class="form-control" name="hora_inicio_redondeada" id="hora_inicio_redondeada" required>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">                          
                          <input type="hidden" class="form-control" name="hora_fin" id="hora_fin" required>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Comentarios:</label>
                          <textarea type="textarea" class="form-control" name="comentarios" id="comentarios"></textarea>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Agendar cita</button>                          
                          <button class="btn btn-danger pull-right" onclick="cancelarFormulario()" type="button" id="btnCancelar"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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
<script type="text/javascript" src="scripts/cita.js"></script>
<?php  
}
ob_end_flush();
?>