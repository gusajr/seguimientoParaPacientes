<!--
    Nombre: ayuda.php
    Objetivo/propósito: archivo contenedor de recursos de soporte como correo de la empresa y videomanuales.
    Creado por: GHAMASWARE
                -Ing. Casillas Toledo Mauricio Enrique
                -Ing. Gómez Segovia Álvaro
                -Ing. Jiménez Ruiz Gustavo Alfredo
                -Ing. Ramírez Martínez Humberto
    Fecha: 4/enero/2020
    Versión: 1.0
-->

<?php
require 'header.php';
?>    
      <div class="content-wrapper"> 
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box box-warning">
                    <div class="box-header with-border">
                        <h1 class="box-title">Ayuda acerca del uso de SSPSO</h1>
                    </div>
                    <div class="panel-body table-responsive" style="height:70%" align="center">
                        <img src="../files/gw.jpeg" height="10%" width="15%">
                        <h2 class="panel-body table-responsive">Video de uso del sistema.</h2><br>
                                    
                        <label>Videomanual para médico</label><br>
                        <video width="320" height="240" controls>
                          <source src="../files/videomanual_medico_registrado.mp4" type="video/mp4">                    
                          Tu navegador no soporta el tipo de video.
                        </video><br><br>

                        <label>Videomanual para médico invitado</label><br>
                        <video width="320" height="240" controls>
                          <source src="../files/videomanual_invitado.mp4" type="video/mp4">                    
                          Tu navegador no soporta el tipo de video.
                        </video><br><br>

                        <label>Videomanual para administrador</label><br>
                        <video width="320" height="240" controls>
                          <source src="../files/videomanual_admin.mp4" type="video/mp4">                    
                          Tu navegador no soporta el tipo de video.
                        </video><br>
                        <p>Para mayor información favor de enviar correo electrónico a: <a>ghamasware@correo.com</a>
                    </div>            
                  </div>
              </div>
            </div>
        </section>
      </div>
<?php
require 'footer.php';
?>