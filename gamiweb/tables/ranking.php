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
  /****************************************************************/
  $QueryRanking = "SELECT * FROM ranking_gen ORDER BY total DESC";
  $ResultadoRan = mysqli_query($Con, $QueryRanking);
  $Renglon = mysqli_fetch_array($ResultadoRan);
  $Renglon1 = mysqli_fetch_array($ResultadoRan);
  $Renglon3 = mysqli_fetch_array($ResultadoRan);

  $filas = mysqli_num_rows($ResultadoRan);

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
    <!-- bootstrap-progressbar -->
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../tables/ranking.css">
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
                <h2><?php echo $row['nombre']?></h2>
              </div>
            </div>

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Inicio</h3>
                <ul class="nav side-menu">
                  <li><a href="index.php"><i class="fa fa-user"></i> Perfil </a></li>
                  <li><a href="actividades.php"><i class="fa fa-gamepad"></i> Actividades</a></li>
                  <li><a href="ranking.php"><i class="fa fa-sitemap"></i>Ranking</a></li>
                  <li><a href="premiaciones.php"><i class="fa fa-gift"></i> Premiaciones</a></li>
                  <li><a><i class="fa fa-group"></i>Tus grupos<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      
                      <?php
                        $sql="SELECT id, nomGrupo from grupo WHERE  id_user = '$idUsuario'";
                        $result= $Con ->query($sql);
                        while ($mostrar=$result->fetch_assoc()) {
                                              
                      ?>
                      <li><a href="nom_clase.php?idGrupo=<?php echo $mostrar['id']?>"><?php echo $mostrar['nomGrupo']?></a></li>

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
                      <a class="dropdown-item"  href="login.php"><i class="fa fa-sign-out pull-right"></i>Cerrar sesión</a>
                    </div>
                  </li>                  
                </ul>
              </nav>
            </div>
          </div>
        <!-- /top navigation -->

        <!-- Página básica en blanco--> 
        <div class="right_col" >
          <div class="row" >

            <?php 
              if($filas >= 3){
            ?>
            <div class="col-md-12" align="center">
              
              <table align="center" width="60%"> 
                <tr>
                  <td align="center">
                    <div style=" height: 345px;"> 
                      <h3 align="center"><?php echo $Renglon1['nombre'];?></h3>
                      <h3 align="center"><?php echo $Renglon1['total'];?> Pts.</h3>
                      <img src="../tables/images/2do.png"  height="120px"><br>
                      <canvas id="segundo_lugar" height="242px"></canvas>
                    </div>
                  </td>

                  <td align="center">
                    <div style=" height: 550px;">
                      <h3 align="center"><?php echo $Renglon['nombre'];?></h3>
                      <h3 align="center"><?php echo $Renglon['total'];?> Pts.</h3>
                      <img src="../tables/images/1er.png" height="140px"><br>
                      <canvas id="primer_lugar" height="325px"></canvas>
                    </div>
                  </td>

                  <td align="center">
                    <div style=" height: 200px;">
                      <h3 align="center"><?php echo $Renglon3['nombre'];?></h3>
                      <h3 align="center"><?php echo $Renglon3['total'];?> Pts.</h3>
                      <img height="100px" src="../tables/images/3er.png"><br> 
                      <canvas id="tercer_lugar" height="190px"></canvas>
                    </div>
                  </td>

                </tr>
                <tr>
                  <td height="10px"></td>
                  <td height="10px"></td>
                  <td height="10px"></td>
                </tr>
                <?php
                  while($Renglon_ = mysqli_fetch_array($ResultadoRan)){
                ?>
                  <tr align="center">
                    <td colspan="3" class="fondoPodium" align="center" style="border-radius: 25px;"><h5 id="lugar" align="center"><?php echo $Renglon_['nombre']?>  ............................................................................................  <?php echo $Renglon_['total']?> Pts</h5></td>
                  </tr>
                  <tr><td colspan="3" width="10px" height="5px"></td></tr>
                <?php 
                  }
                ?>
                
              </table>

              <br>
              <br>

            </div>

            <?php 
              }else{
            ?>
              <div class="col-md-12">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <div class="x_title" align="center" style="color: #831eae;">
                  <h1 style="font-family: sans-serif; color: #831eae;">Aún no puedes ver el Ranking</h1>

                </div>
              </div>
            <?php
              }
            ?>
          </div>
        </div>

        
        <!-- /page content -->
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
