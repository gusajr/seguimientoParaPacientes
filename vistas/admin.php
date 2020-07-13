<!--
    Nombre: admin.php
    Objetivo/propósito: pantalla administrador, muestra las acciones disponibles para este tipo de usuario.
    Creado por: GHAMASWARE
                -Ing. Casillas Toledo Mauricio Enrique
                -Ing. Gómez Segovia Álvaro
                -Ing. Jiménez Ruiz Gustavo Alfredo
                -Ing. Ramírez Martínez Humberto
    Fecha: 27/diciembre/2019
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
{ //Si la sesion no tiene permisos no se muestra
?>    
      <div class="content-wrapper">  
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box box-warning">
                    <div class="box-header with-border">
                          <h1 class="box-title pull-center">Administradores</h1>                          
                        <div class="box-tools pull-right">
                          <button class="btn btn-success" onclick="mostrarFormulario(true)" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar administrador</button>
                        </div>
                    </div>                                        
                    <div class="panel-body table-responsive" id="listadoRegAdmin">
                      <table id="tablalistado" class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                          <th>Opciones</th>
                          <th>Nombre de usuario</th>
                          <th>Password</th>
                          <th>Imagen</th>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                          <th>Opciones</th>
                          <th>Nombre de usuario</th>
                          <th>Password</th>
                          <th>Imagen</th>
                        </tfoot>
                      </table>
                    </div>
                    <div class="panel-body" id="formularioRegAdmin">
                      <form name="formulario" id="formulario" method="POST">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Nombre de usuario:</label>
                          <input type="hidden" name="id_admin" id="id_admin">
                          <input type="text" class="form-control" name="nombre_usuario" id="nombre_usuario" maxlength="18" placeholder="Ej. admin" required>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Password:</label>
                          <input type="password" class="form-control" name="password" id="password" maxlength="60" placeholder="Ej. 123456" required>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Imagen: </label>
                          <input type="file" class="form-control" name="imagen" id="imagen">
                          <input type="hidden" name="imagen_actual" id="imagen_actual">
                          <img src="" width="150px" height="120px" id="imagen_muestra">
                        </div>
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
<script type="text/javascript" src="scripts/admin.js"></script>
<?php  
}
ob_end_flush();
?>