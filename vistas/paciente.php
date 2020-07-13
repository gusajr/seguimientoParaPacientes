<!--
    Nombre: paciente.php
    Objetivo/propósito: pantalla paciente. Se muestran todos los pacientes registrados, así como acciones que se pueden hacer con cada paciente.
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
                          <h1 class="box-title pull-center">Pacientes</h1>                          
                        <div class="box-tools pull-right">
                          <button class="btn btn-success" onclick="mostrarFormulario(true)" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar paciente</button>                        
                        </div>
                    </div>                                        
                    <div class="panel-body table-responsive" id="listadoRegPac">
                      <table id="tablalistado" class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                          <th>Opciones</th>
                          <th>Curp</th>
                          <th>Nombre del paciente</th>
                          <th>Nombre del médico</th>
                          <th>Imagen</th>
                          <th>Fecha de nacimiento</th>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        <tfoot>
                          <th>Opciones</th>
                          <th>Curp</th>
                          <th>Nombre del paciente</th>
                          <th>Nombre del médico</th>
                          <th>Imagen</th>
                          <th>Fecha de nacimiento</th>
                        </tfoot>
                      </table>
                    </div>
                    <div class="panel-body" id="formularioRegPac">
                      <form name="formulario" id="formulario" method="POST" >
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Curp:</label>
                          <input type="hidden" name="id_paciente" id="id_paciente">
                          <input type="text" class="form-control" name="curp" id="curp"  placeholder="Ej. AAAA000000AAAAAA00" >
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Medico que registra:</label>
                          <select name="id_medico" id="id_medico" class="form-control selectpicker" data-live-search="true">
                          </select>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Nombre:</label>
                          <input type="text" class="form-control" name="nombre" id="nombre" maxlength="60" placeholder="Ej. Juan Pérez" >
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Fecha de nacimiento (MM/DD/YYYY): </label>
                          <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento">
                        </div>                        
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Teléfono: </label>
                          <input type="text" class="form-control" name="telefonoHist" id="telefono" maxlength="10" placeholder="Ej. 0123456789" >
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Correo: </label>
                          <input type="text" class="form-control" name="correo" id="correo" maxlength="60" placeholder="Ej. ejemplo@ejemplo.com" >
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Dirección: </label>
                          <input type="textarea" class="form-control" name="direccion" id="direccion" placeholder="Ej. Insurgentes sur 600">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="sel1">Género:</label>
                          <select class="form-control" id="genero" name="genero">
                            <option value="F">Femenino</option>
                            <option value="M">Masculino</option>
                            <option value="O">Otro</option>
                          </select>  
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Fecha de registro (MM/DD/YYYY): </label>
                          <input type="date" class="form-control" name="fecha_registro" id="fecha_registro">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Imagen: </label>
                          <input type="file" class="form-control" name="imagen" id="imagen">
                          <input type="hidden" name="imagen_actual" id="imagen_actual">
                          <img src="" width="150px" height="120px" id="imagen_muestra">
                        </div>
                        <input type="hidden" value="1" name="activo" id="activo">
                        <textarea style="display:none;" name="historia_clinica" id="historia_clinica"></textarea>                        
                      </form>
                    </div>
                    <div id="histClinica" class="panel-body">
                      <form id="formHistoriaClinica">
                        <fieldset>

                          <legend>Identificación</legend>

                          <label for="fecha">Fecha:</label>
                          <input type="date" style="display: block; width: 17.5rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id1">

                          <label for="nombreHist">Nombre:</label>
                          <input type="text" style="display: block; width: 50%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"  id="id2" name="nombreHist" placeholder="Nombre del paciente">

                          <label for="edad">Edad:</label>
                          <input type="number" style=" width: 6rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"  id="id3" placeholder="Edad del paciente">

                          <label for="sexo">Género:</label>
                          <select id="id4" style="width: 8rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;">
                              <option value="" disabled selected></option>
                              <option value="Masculino">Masculino</option>
                              <option value="femenino">Femenino</option>
                          </select>

                          <label for="fechaNacimiento">Lugar y fecha de nacimiento</label>
                          <input type="date" style="width: 17.5rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id121">
                          <input type="text" style="width: 30%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id122" placeholder="Lugar de nacimiento">

                          <label for="ocupacion">Ocupación:</label>
                          <input type="textplace" style="width: 15rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"  id="id5" placeholder="Ocupación">

                          <label for="escolaridad">Escolaridad:</label>
                          <input type="text" style="width: 15rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"  id="id6" placeholder="Escolaridad">

                          <label for="estadoCivil">Estado Civil:</label>
                          <input type="text" style="width: 15rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"  id="id7" placeholder="Estado civil">

                          <label for="religion">Religión:</label>
                          <input type="text" style="width: 15rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"  id="id8" placeholder="Religión"><br>

                          <label for="telefonoHist">Teléfono</label>
                          <input type="tel" style="width: 15rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"  id="id9" placeholder="Teléfono del paciente"><br>
                          
                          <label for="domicilio">Domicilio:</label><br>
                          <textarea type="text" style="width: 80%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;"  id="id10" placeholder="Domicilio del paciente"></textarea>
                          
                        </fieldset>
                        
                        <fieldset>

                          <legend>Antecedentes Heredofamiliares</legend>
                          
                          <label for="metabolicos"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id11" placeholder="Metabólicos">

                          <label for="cardiovasculares"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id12" placeholder="Cardiovasculares">

                          <label for="neoplasticos"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id13" placeholder="Neoplásticos">

                          <label for="endocrinos"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id14" placeholder="Endócrinos">

                          <label for="gastro"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id15" placeholder="Gastrointestinales">

                          <label for="pulmonares"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id16" placeholder="Pulmonares">

                          <label for="renales"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id17" placeholder="Renales">
                          
                          <label for="osteoar"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id18" placeholder="Osteoartríticos">

                          <label for="hemat"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id19" placeholder="Hematológicos">

                          <label for="neuro"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id20" placeholder="Neurológicos">

                          <label for="psi"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id21"  placeholder="Psiquiátricos">

                          <label for="infeccioso"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id22" placeholder="Infecciosos">

                          <label for="otros"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id23" placeholder="Otros">

                        </fieldset>
                        
                        <fieldset>

                          <legend>Antecedentes personales no patoloógicos</legend>

                          <label for="vivienda"></label>
                          <input type="text" style="width: 30%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id24" placeholder="Vivienda">

                          <label for="servUr"></label>
                          <input type="text" style="width: 30%;padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id25" placeholder="Ser. Urbanos">

                          <label for="higiene"></label>
                          <input type="text" style="width: 30%;padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id26" placeholder="Higiene">

                          <label for="hacimiento"></label>
                          <input type="text" style="width: 30%;padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id27" placeholder="Hacimiento">

                          <label for="promiscuidad"></label>
                          <input type="text" style="width: 30%;padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id28" placeholder="Promiscuidad">

                          <label for="animales"></label>
                          <input type="text" style="width: 30%;padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id29" placeholder="Animales">

                          <label for="tabaquismo"></label>
                          <input type="text" style="width: 30%;padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id30" placeholder="Tabaquismo">

                          <label for="etilismo"></label>
                          <input type="text" style="width: 30%;padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id31" placeholder="Etilismo">

                          <label for="drogas"></label>
                          <input type="text" style="width: 30%;padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id32" placeholder="Drogas">

                          <label for="alimentación"></label>
                          <input type="text" style="width: 30%;padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id33" placeholder="Alimentación">

                          <label for="inmun"></label>
                          <input type="text" style="width: 30%;padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id34" placeholder="Inmunizaciones">

                          <label for="otros2"></label>
                          <input type="text" style="width: 30%;padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id35" placeholder="Otros">

                        </fieldset>

                        <fieldset>

                          <legend>Antecedente Personales Patológicos</legend>

                          <label for="congenitos"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id36" placeholder="Congénitos">

                          <label for="infecto"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id37" placeholder="Infectocontagiosos">

                          <label for="exan"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id38" placeholder="Exantemáticos">

                          <label for="gastroint"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id39" placeholder="Gastrointestinales">

                          <label for="traumaticos"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id40" placeholder="Traumáticos">

                          <label for="quirurgicos"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id41" placeholder="Quirúrgicos">

                          <label for="alergicos"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id42" placeholder="Alérgicos">

                          <label for="has"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id43" placeholder="H.A.S.">

                          <label for="transf"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id44" placeholder="Transfusionales">

                          <label for="cardiacos"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id45" placeholder="Cardíacos">

                          <label for="diabetes"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id46" placeholder="Diabetes">

                          <label for="otros3"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id47" placeholder="Otros">

                        </fieldset>

                        <fieldset>

                          <legend>Antecedentes Gineco Obstétricos</legend>

                          <label for="menarca"></label>
                          <input type="text" style="width:30; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id48" placeholder="Menarca">

                          <label for="ritmo"></label>
                          <input type="text" style="width:30; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id49" placeholder="Ritmo">

                          <label for="dimenorrea"></label>
                          <input type="text" style="width:30; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id50" placeholder="Dismenorrea">

                          <label for="ivsa"></label>
                          <input type="text" style="width:30; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id51" placeholder="IVSA">

                          <label for="g"></label>
                          <input type="text" style="width:30; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id52" placeholder="G">

                          <label for="p"></label>
                          <input type="text" style="width:30; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id53" placeholder="P">

                          <label for="c"></label>
                          <input type="text" style="width:30; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id54" placeholder="C">

                          <label for="fup"></label>
                          <input type="text" style="width:30; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id55" placeholder="FUP">

                          <label for="a"></label>
                          <input type="text" style="width:30; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id56" placeholder="A">

                          <label for="fua"></label>
                          <input type="text" style="width:30; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id57" placeholder="FUA">

                          <label for="fur"></label>
                          <input type="text" style="width:30; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id58" placeholder="FUR">

                          <label for="fpp"></label>
                          <input type="text" style="width:30; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id59" placeholder="FPP">

                          <label for="pap"></label>
                          <input type="text" style="width:30; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id60" placeholder="PAP">

                          <label for="docma"></label>
                          <input type="text" style="width:30; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id61" placeholder="DOCMA">

                          <label for="ppf"></label>
                          <input type="text" style="width:30; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id62" placeholder="PPF">

                          <label for="leuco"></label>
                          <input type="text" style="width:30; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id63" placeholder="Leucorrea">

                          <label for="otros4"></label>
                          <input type="text" style="width:30; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id64" placeholder="Otros">

                        </fieldset>

                        <fieldset>

                          <legend>Antecedentes Perinatales</legend>

                          <label for="numhijos">Número de hijos:</label>
                          <input type="number" style="width: 8rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id65"  placeholder="Num. de hijos">

                          <label for="fechaNamH">Fecha de nacimiento:</label>
                          <input type="datetime" style="width: 17.5rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id66" placeholder="Fecha de nacimiento"><br>

                          <label for="lugar"></label>
                          <input type="text" style="width:30%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id67" placeholder="Lugar">

                          <label for="vianac"></label>
                          <input type="text" style="width:30%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id68" placeholder="Vía de nacimiento">

                          <label for="semenasnac"></label>
                          <input type="number" style="width:30%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id69" placeholder="Semanas al nacer">

                          <label for="peso"></label>
                          <input type="text" style="width:30%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id70" placeholder="Peso">

                          <label for="talla"></label>
                          <input type="text" style="width:30%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id71" placeholder="Talla">

                          <label for="apgar"></label>
                          <input type="text" style="width:30%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id72" placeholder="APGAR">

                          <label for="silverman"></label>
                          <input type="text" style="width:30%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id73" placeholder="Silverman">

                          <label for="enfMater"></label>
                          <input type="text" style="width:30%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id74" placeholder="Enf. Maternas o complicaciones">

                          <label for="senoM"></label>
                          <input type="text" style="width:30%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id75" placeholder="Seno Mat.">

                          <label for="tipoLeche"></label>
                          <input type="text" style="width:30%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id76" placeholder="Tipo de Leche">

                          <label for="ablactacion"></label>
                          <input type="text" style="width:30%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id77" placeholder="Ablactación">

                          <label for="otros5"></label>
                          <input type="text" style="width:30%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id78" placeholder="Otros">

                        </fieldset>

                        <fieldset>

                          <legend>Padecimiento Actual (Inicio, Evolución, Edo. Actual)</legend>

                          <textarea style=" width: 100%; length: 50rem;padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" name="" id="id79"></textarea>

                        </fieldset>

                        <fieldset>

                          <legend>Interrogatorio por aparatos y sistemas</legend>

                          <label for="urinario"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id80" placeholder="Urinario">

                          <label for="digestivo"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id81" placeholder="Digestivo">

                          <label for="nervioso"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id82" placeholder="Nervioso">

                          <label for="genital"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id83" placeholder="Genital">

                          <label for="hemolin"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id84" placeholder="Hemlinfático">

                          <label for="dermat"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id85" placeholder="Dermatológico">

                          <label for="musc"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id86" placeholder="Musculoeso">

                          <label for="respiratorio"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id87" placeholder="Respiratorio">

                          <label for="cadiacc"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id88" placeholder="Cardíaco">

                          <label for="vascperif"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id89" placeholder="Vascular Perfiférico">

                          <label for="psiquia"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id90" placeholder="Psiquiátricos">

                          <label for="orgSent"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id91" placeholder="Órganos de los sentidos">

                          <label for="otros6"></label>
                          <input type="text" style="width: 45%; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id92" placeholder="Otros">

                        </fieldset>

                        <fieldset>

                          <legend>Exploración física</legend>

                          <label for="pesoo">Peso:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id93" placeholder="Peso">

                          <label for="tallaa">Talla:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id94" placeholder="Talla">

                          <label for="fc">F.C.:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id95" placeholder="F.C.">

                          <label for="fr">F.R.:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id96" placeholder="F.R.">

                          <label for="temp">Temp.:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id97" placeholder="Temp.">

                          <label for="ta">T.A.:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id98" placeholder="T.A.">

                          <label for="nivelSo">Nivel sociec.:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id99" placeholder="Nivel sociec.">

                          <label for="edoemoc">Edo. Emocional:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id100" placeholder="Edo. Emocional">

                          <label for="fascies">Fascies:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id101" placeholder="Fascies">

                          <label for="actitud">Actitud:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id102" placeholder="Actitud">

                          <label for="integridad">Integridad:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id103" placeholder="Integridad">

                          <label for="constitucion">Constitución:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id104" placeholder="Constitución">

                          <label for="marcha">Marcha:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id105" placeholder="Marcha">

                          <label for="movan">Mov. Anormales:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id106" placeholder="Mov. Anormales">

                          <label for="orientacion">Orientación:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id107" placeholder="Orientación">

                          <label for="edonutric">Edo. Nutricional:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id108" placeholder="Edo. Nutricional">

                          <label for="cabeza">Cabeza:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id109" placeholder="Cabeza">

                          <label for="cuello">Cuello:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id110" placeholder="Cuello">

                          <label for="torax">Torax:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id111" placeholder="Torax">

                          <label for="abdomen">Abdomen:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id112" placeholder="Abdomen">

                          <label for="extremidades">Extremidades:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id113" placeholder="Extremidades">

                          <label for="ginecologica">Exp. Ginecológica:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id114" placeholder="Ginecológica">

                          <label for="otros7">Otros:</label>
                          <input type="text" style="width: 25; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id115" placeholder="Otros">

                        </fieldset>

                        <fieldset>

                          <legend>Resultados de laboratorio y gabinete</legend>
                          <div class="separatedBlocks">
                          <textarea name="" style="width: 45%; length: 50rem; border: none; border-radius: 1rem; background-color: #ebebeb; margin-right: 8rem;" id="id116"></textarea>
                          <textarea name="" style="width: 45%; length: 50rem;border: none; border-radius: 1rem; background-color: #ebebeb;" id="id117"></textarea>
                          </div>
                          </fieldset>

                        <fieldset>

                          <legend>Diagnóstico</legend>
                          <textarea name="" style="width: 100%; length: 50rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id118"></textarea>

                        </fieldset>

                        <fieldset>

                          <legend>Plan terapéutico</legend>
                          <textarea name="" style="width: 100%; length: 50rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id119"></textarea>

                        </fieldset>

                        <fieldset>

                          <legend>Pronóstico</legend>
                          <textarea name="" style="width: 100%; length: 50rem; padding: .5rem 0; border: none; border-radius: 1rem; background-color: #ebebeb;" id="id120"></textarea>

                        </fieldset>                        
                          <label for="medico" style="margin-top: 2rem;">Médico: <?php echo $_SESSION["nombre"]; ?></label><br>                                            
                          <label for="cedula">Cédula: <?php echo $_SESSION["cedula"]; ?></label>
                          <br><br>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <button class="btn btn-primary" type="submit" id="btnGuardar1" onclick="guardaryeditar2(event)"><i class="fa fa-save"></i> Guardar</button>                              
                              <button class="btn btn-success" onclick="imprimir(event)" type="button" id="btnCancelar"><i class="fa fa-print"></i> Imprimir</button>
                              <button class="btn btn-danger" onclick="cancelarFormulario()" type="button" id="btnCancelar1"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>                              
                              <button class="btn btn-danger pull-right" type="submit" id="btnGuardar2" onclick="vaciarForm1(event)"><i class="fa fa-save"></i> Vaciar formulario</button>
                          </div>
                      </form>
                      </div>
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
<script type="text/javascript" src="scripts/paciente.js"></script>
<?php  
}
ob_end_flush();
?>