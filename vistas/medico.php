<!--
    Nombre: medico.php
    Objetivo/propósito: pantalla médico. muestras las acciones disponibles para este tipo de usuario.
    Creado por: GHAMASWARE
                -Ing. Casillas Toledo Mauricio Enrique
                -Ing. Gómez Segovia Álvaro
                -Ing. Jiménez Ruiz Gustavo Alfredo
                -Ing. Ramírez Martínez Humberto
    Fecha: 22/diciembre/2019
    Versión: 1.0
-->

<?php
//Activamos almacenamiento en el buffer
ob_start();
session_start();
if((!isset($_SESSION["nombre"]))&&(!isset($_SESSION["nombre_usuario"]))){
  header("location: login.html");
}else{
  require 'header.php';
  if($_SESSION["repositorio"]==1)
{
?>    
      <div class="content-wrapper">                
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box box-warning">
                    <div class="box-header with-border">
                          <h1 class="box-title pull-center">Médicos</h1>                          
                        <div class="box-tools pull-right">
                          <button class="btn btn-success" onclick="mostrarFormulario(true)" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar médico</button>
                        </div>
                    </div>                                        
                    <div class="panel-body table-responsive" id="listadoRegMed">
                      <table id="tablalistado" class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                          <th>Opciones</th>
                          <th>Nombre del médico registrado</th>
                          <th>Especialidad</th>
                          <th>Teléfono</th>
                          <th>Correo</th>
                          <th>Cédula</th>
                          <th>Imagen</th>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        <tfoot>
                          <th>Opciones</th>
                          <th>Nombre del médico registrado</th>
                          <th>Especialidad</th>
                          <th>Teléfono</th>
                          <th>Correo</th>
                          <th>Cédula</th>
                          <th>Imagen</th>
                        </tfoot>
                      </table>
                    </div>
                    <div class="panel-body" style="height: 50%" id="formularioRegMed">
                      <form name="formulario" id="formulario" method="POST">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Nombre:</label>
                          <input type="hidden" name="id_medico" id="id_medico">
                          <input type="text" class="form-control" name="nombre" id="nombre" maxlength="60" placeholder="Ej. Pancho Pérez" >
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="sel1">Especialidad</label>
                          <select class="form-control" id="especialidad" name="especialidad">
                            <option value="Anestesiología">Anestesiología</option>
                            <option value="Angiología">Angiología</option>
                            <option value="Cirugía general">Cirugía general</option>
                            <option value="Cirugía laparoscópica">Cirugía laparoscópica</option>
                            <option value="Endoscopias">Endoscopias</option>
                            <option value="Ginecología y Obstetricia">Ginecología y Obstetricia</option>
                            <option value="Hospitalización">Hospitalización
                            </option>
                            <option value="Incubadora">Incubadora</option>
                            <option value="Medicina Interna">Medicina Interna</option>
                            <option value="Oftalmología">Oftalmología</option>
                            <option value="Otorrinolaringología">Otorrinolaringología</option>
                            <option value="Pediatría">Pediatría</option>
                            <option value="Proctología">Proctología</option>
                            <option value="Rayos X">Rayos X</option>
                            <option value="Traumatología">Traumatología</option>
                            <option value="Urología">Urología</option>
                          </select>  
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Teléfono: </label>
                          <input type="number" class="form-control" name="telefono" id="telefono" maxlength="10" placeholder="Ej. 0123456789">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Correo: </label>
                          <input type="text" class="form-control" name="correo" id="correo" maxlength="45" placeholder="Ej. ejemplo@ejemplo.com">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Cédula: </label>
                          <input type="text" class="form-control" name="cedula" id="cedula" placeholder="Ej. 12345678987">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Hora de entrada: </label>
                          <input type="time" class="form-control" name="hora_entrada" id="hora_entrada"/>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Hora de salida: </label>
                          <input type="time" class="form-control" name="hora_salida" id="hora_salida"/>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Password: </label>
                          <input type="password" class="form-control" name="password" id="password" maxlength="32" placeholder="Ej. 12345678">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Imagen: </label>
                          <input type="file" class="form-control" name="imagen" id="imagen">
                          <input type="hidden" name="imagen_actual" id="imagen_actual">
                          <img src="" width="150px" height="120px" id="imagen_muestra">
                        </div>                        
                        <input type="hidden" value="1" name="activo" id="activo">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>                          
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
<script type="text/javascript" src="scripts/medico.js"></script>
<?php  
}
ob_end_flush();
?>
