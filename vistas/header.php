<!--cabecera común para todas las páginas.
menú, referencia a CSS, imagenes, etc-->
<?php
if(strlen(session_id())<1){
  session_start();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sanatorio de Oriente</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <link rel="apple-touch-icon" href="../images/SdeO.jpg">
    <link rel="shortcut icon" href="../images/SdeO.jpg">
    <!--Datatables-->    
    <link rel="stylesheet" href="../public/datatables/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../public/datatables/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../public/datatables/responsive.dataTables.min.css">
    <link rel="stylesheet" href="../public/css/bootstrap-select.min.css">
  </head>
  <body class="hold-transition skin-red-light sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="../files/icono.png"></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">Sanatorio de Oriente</span>
          <!--span class="logo-lg"><img src="../files/image.png"></span-->
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">  
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img <?php if($_SESSION['tipo_persona']=='medico'){echo ('src="../files/medicos/'.$_SESSION['imagen'].'"');}else{echo ('src="../files/admin/'.$_SESSION['imagen'].'"');}?> class="user-image" alt="User Image"> 
                  <span class="hidden-xs"><?php if($_SESSION['tipo_persona']=='medico'){echo $_SESSION['nombre'];}else{echo $_SESSION['nombre_usuario'];}?></span>
                </a>
                <ul class="dropdown-menu skin-blue">
                  <!-- User image -->
                  <li class="user-header skin-blue">
                    <img <?php if($_SESSION['tipo_persona']=='medico'){echo ('src="../files/medicos/'.$_SESSION['imagen'].'"');}else{echo ('src="../files/admin/'.$_SESSION['imagen'].'"');}?> class="img-circle" alt="User Image">
                    <p>
                      Sesión iniciada como <?php echo $_SESSION['tipo_persona'];?>
                      <!--small></small-->
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-right">
                      <a <?php if($_SESSION['tipo_persona']=='medico'){echo 'href="../ajax/medico.php?op=salir"';}else{echo 'href="../ajax/admin.php?op=salir"';}?> class="btn btn-warning">Cerrar sesión</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">       
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"></li>
            <li>
              <a href="../vistas/bienvenida.php">
                <i class="fa fa-bookmark"></i><span>Bienvenida</span>
              </a>
            </li>
            <?php  
              if($_SESSION["repositorio"]==1){ //Solo mostrará lo demás del menú si el que ingresó no es el admin
                echo 
            '<li class="treeview">
              <a href="#">
                <i class="fa fa-eyedropper"></i>
                <span>Repositorio</span>
                <i class="fa fa-child pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="admin.php"><i class="fa fa-child"></i> Administradores</a></li>
                <li><a href="medico.php"><i class="fa fa-child"></i> Médicos</a></li>
                <li><a href="paciente.php"><i class="fa fa-child"></i> Pacientes</a></li>
              </ul>
            </li>
            ';}?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-heart"></i>
                <span>Pacientes</span>
                 <i class="fa fa-heartbeat pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="paciente.php"><i class="fa fa-heartbeat"></i> Pacientes</a></li>
                <li><a href="cita.php"><i class="fa fa-heartbeat"></i> Agendar cita</a></li>
                <li><a href="consultaInterna.php"><i class="fa fa-heartbeat"></i> Consulta Interna</a></li>
                <li><a href="consultaExterna.php"><i class="fa fa-heartbeat"></i> Consulta Externa</a></li>
                <li><a href="notas.php"><i class="fa fa-heartbeat"></i> Notas clínicas</a></li>
              </ul>
            </li>
            <li>
              <a href="ayuda.php">
                <i class="fa fa-plus-square"></i> <span>Ayuda</span>
                <small class="label pull-right bg-red">Video</small>
              </a>
            </li>
            <li>
              <a href="informacion.php">
                <i class="fa fa-info-circle"></i> <span>Información</span>
                <small class="label pull-right bg-yellow">+</small>
              </a>
            </li>          
          </ul>
        </section>
        <!-- /.sidebar -->
    
  </aside>