<!--
    Nombre: consultaInterna.php
    Objetivo/propósito: pantalla de creacion de documentos de citas internas.
    Creado por: GHAMASWARE
                -Ing. Casillas Toledo Mauricio Enrique
                -Ing. Gómez Segovia Álvaro
                -Ing. Jiménez Ruiz Gustavo Alfredo
                -Ing. Ramírez Martínez Humberto
    Fecha: 3/enero/2020
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
                          <h1 class="box-title pull-center">Consultas internas</h1>                          
                        <div class="box-tools pull-right">
                          <button class="btn btn-success" onclick="mostrarFormulario(true)" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar consulta</button>
                        </div>
                    </div>
                    <div class="panel-body table-responsive" id="listadoRegPac">
                      <table id="tablalistado" class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                          <th>Opciones</th>
                          <th>Fecha</th>
                          <th>Nombre de paciente</th>
                          <th>Nombre de medico</th>
                          <th>Hospitalización</th>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        <tfoot>
                          <th>Opciones</th>
                          <th>Fecha</th>
                          <th>Nombre de paciente</th>
                          <th>Nombre de medico</th>
                          <th>Hospitalización</th>
                        </tfoot>
                      </table>
                    </div>                                        
                    <div class="panel-body" id="formularioRegPac" style="margin-left:1rem; font-size:2rem;">
                      <form name="formulario" id="formulario" method="POST">                       
                        <label for="id_medico">Nombre del medico:</label>
                        <select name="id_medico" id="id_medico" class="form-control selectpicker" data-live-search="true" required>
                        </select>
                        <label for="id_paciente">Nombre del paciente:</label>
                        <select name="id_paciente" id="id_paciente" class="form-control selectpicker" data-live-search="true" required>
                        </select><br><br>
                        <input type="hidden" name="id_consulta_interna" id="id_consulta_interna">
                        <label for="fecha">Fecha:</label> 
                        <input type="date" name="fecha" id="fecha" style="margin: 0 2rem 1rem 0;width: 20rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"><br>
                        <textarea style="display:none;" name="notas" id="notas"></textarea>
                        <label for="edad">Edad:</label> 
                        <input type="number" name="edad" id="id1" style="margin: 0 2rem 1rem 0;width: 10rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"><br>                        
                        <label for="telefono">Tel.:</label>
                        <input type="number" name="telefono" id="id2" style="margin: 0 2rem 1rem 0;width: 15rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"><br>
                        <label for="genero">Genero:</label>
                        <select name="genero" id="id3" style="margin: 0 2rem 1rem 0;width: 10rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;">
                          <option value="" disabled selected></option>
                          <option value="Masculino">Masculino</option>
                          <option value="femenino">Femenino</option>
                        </select><br>                        
                        <label for="fc">FC:</label>
                        <input type="text" id="id4" style="margin: 0 2rem 1rem 0;width: 10rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"><br>
                        <label for="fr">FR:</label>
                        <input type="text" id="id5" style="margin: 0 2rem 1rem 0;width: 10rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"><br>
                        <label for="temp">Temp.:</label>
                        <input type="number" id="id6" style="margin: 0 2rem 1rem 0;width: 10rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"><br>
                        <label for="peso">Peso:</label>
                        <input type="number" id="id7"style="margin: 0 2rem 1rem 0;width: 10rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"><br>
                        <label for="talla">Talla</label>
                        <input type="number" id="id8"style="margin: 0 2rem 1rem 0;width: 10rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"><br>
                        <label for="ta">TA:</label>
                        <input type="number" id="id9" style="margin: 0 2rem 1rem 0;width: 10rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"><br>
                        <label for="infoRiesgo">Se proporciona información de riesgo materno fetal</label>
                        <select name="infoRiesgo" id="id10" style="margin: 0 2rem 1rem 0;width: 5rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;">
                          <option value="" disabled selected></option>
                          <option value="Sí">Sí</option>
                          <option value="No">No</option>
                        </select><br>
                        <label for="Subjetivo">Subjetivo (S):</label>
                        <textarea name="subjetivo" id="id11" style="margin: 0 2rem 1rem 0;width: 95%; length: 50rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"></textarea>
                        <label for="Objetivo">Objetivo (O):</label>
                        <textarea name="objetivo" id="id12" style="margin: 0 2rem 1rem 0;width: 95%; length: 50rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"></textarea>
                        <label for="Analisis">Análisis (A):</label>
                        <textarea name="analisis" id="id13" style="margin: 0 2rem 1rem 0;width: 95%; length: 50rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"></textarea>
                        <label for="Plan">Plan (P):</label>
                        <textarea name="plan" id="id14" style="margin: 0 2rem 1rem 0;width: 95%; length: 50rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"></textarea>
                        <label for="observaciones">Observaciones:</label>
                        <textarea name="observaciones" id="id15" style="margin: 0 2rem 1rem 0;width: 95%; length: 50rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"></textarea>
                        <label for="medico" style="margin-top: 2rem;">Médico: <?php echo $_SESSION["nombre"]; ?></label><br>
                        <label for="cedula">Cédula: <?php echo $_SESSION["cedula"]; ?></label><br><br><br>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <button class="btn btn-primary" type="submit" id="btnGuardar1"><i class="fa fa-save"></i> Guardar</button>                              
                              <button class="btn btn-success" onclick="imprimir(event)" type="button" id="btnCancelar"><i class="fa fa-print"></i> Imprimir</button>
                              <button class="btn btn-danger" onclick="cancelarFormulario()" type="button" id="btnCancelar1"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>                              
                              <button class="btn btn-danger pull-right" type="submit" id="btnGuardar2" onclick="vaciarForm1(event)"><i class="fa fa-save"></i> Vaciar formulario</button>
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
<script type="text/javascript" src="scripts/consulta_interna.js"></script>
<?php  
}
ob_end_flush();
?>