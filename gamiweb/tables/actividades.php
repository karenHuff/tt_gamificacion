<?php 
  session_start();
  require 'conexion.php';
  require 'funcs.php';

  if (!isset($_SESSION['id_usuario'])) {
    // code...
    header("Location: login.php");
  }

  $idUsuario = $_SESSION['id_usuario'];

  $Cx = "SELECT id, nombre, apaterno, amaterno, user, foto FROM usuarios WHERE id = '$idUsuario'";
  $result = $Con->query($Cx);

  $row = $result->fetch_assoc();

  $errores = array();
  $resultado = array();

  $sql ="SELECT u.idgrupo_usuarios, g.id, g.nomGrupo, g.descripcion, us.nombre, us.apaterno, us.amaterno FROM grupo_usuarios u, grupo g, usuarios us  WHERE id_usuario = '$idUsuario' AND u.id_grupo = g.id AND us.id = g.id_user";
  $result = mysqli_query($Con, $sql);
  $Renglon = mysqli_num_rows($result);
  //echo $Renglon;
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">

    <title>GAMIWEB</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../tables/estilosRanking.css">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title">
              <a class="site_title"><i class="fa fa-desktop"></i>  <span>GAMIWEB</span></a>
            </div>

            <div class="clearfix"></div>
            <!-- imagen de bienvenida-->
            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                 <img src="<?php echo $row['foto']; ?>" alt="..." class="img-circle profile_img"> 
              </div>
              <div class="profile_info">
                <span>Bienvenido</span>
                <h2><?php echo $row['nombre'];?></h2>
              </div>
            </div>

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Inicio</h3>
                <ul class="nav side-menu">
                  <li><a href="index.php"><i class="fa fa-user"></i> Perfil </a></li>
                  <li><a href="actividades.php"><i class="fa fa-gamepad"></i> Actividades</a>
                    
                  </li>
                  <li><a href="ranking.php"><i class="fa fa-sitemap"></i>Ranking</a></li>
                  <li><a href="premiaciones.php"><i class="fa fa-gift"></i> Premiaciones</a></li>
                  <li><a><i class="fa fa-group"></i>Tus grupos<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php
                        $sql="SELECT id, nomGrupo from grupo WHERE  id_user = '$idUsuario'";
                        $result= $Con ->query($sql);
                        while ($mostrar=$result->fetch_assoc()) {
                        
                      ?>
                      <li><a href="nom_clase.php?idGrupo=<?php echo $mostrar['id']?>"><?php echo $mostrar['nomGrupo'];?></a></li>

                      <?php

                        } 
                      ?>
                      <li><a href="nuevo_grupo.php">Crear grupo</a></li>
                    </ul>
                  </li>
                </ul>
                <!--agregar calendario-->
                
               
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons --> <!-- modificaciones de barra inferior-->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="">
                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="">
                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="">
                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.php">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <div class="nav toggle">
                  <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>
                <nav class="nav navbar-nav">
                <ul class=" navbar-right">
                  <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                      <img src="<?php echo $row['foto']; ?>" alt=""><?php echo utf8_decode($row['user'])?>
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item"  href="login.php"><i class="fa fa-user"></i>Cerrar sesión</a>
                    </div>
                  </li>
  
                  
                </ul>
              </nav>
            </div>
          </div>
        <!-- Página básica en blanco -->
        <div class="right_col">
          <div class="row">
            
            <?php 
              if($Renglon == 0){
                echo '<h3 class="tituloAct">No perteneces a un <b>Grupo</b></h3>';
              }else{
            ?>
            <div class="col-md-12 col-sm-12 col-center">
              <div class="x_panel">
                <h5 align="center">Actividades</h5>
                <div class="x_content">
                  
                <?php
                  $QueryAc ="SELECT u.idgrupo_usuarios, g.id, g.nomGrupo, g.descripcion, us.nombre, us.apaterno, us.amaterno FROM grupo_usuarios u, grupo g, usuarios us  WHERE id_usuario = '$idUsuario' AND u.id_grupo = g.id AND us.id = g.id_user";
                  $Res_Query = mysqli_query($Con, $QueryAc);
                  while ($mostrar=mysqli_fetch_array($Res_Query)) {
                ?>

                <div class="col-md-12 col-center" >
                  <div class="animated flipInY col-lg-12 col-md-12 col-sm-12">
                    <div class="tile-stats" align="left">
                      <div >
                        <h3><a id="mostrar" href="mostrar_actividad.php?idGrupo=<?php echo $mostrar['id']?>"><i class="fa fa-group"> <?php echo $mostrar['nomGrupo'];?></i></a></h3>
                        <h6><a><?php echo $mostrar['descripcion'];?> </a></h6>
                        <h4>Profesor: <?php echo $mostrar['nombre']?> </h4>
                        <input type="hidden" name="idGrupo" id="idGrupo" value="<?php echo $mostrar['id']?>" >
                      </div>
                    </div>
                  </div>
                </div>
                <br>
                 <?php
                  }
                ?>
                    
                </div>
              </div>
            </div>
            <?php 
              }
            ?>
          </div>
        </div>


      </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
  </body>
</html>
