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

  $historia=$_GET['idHistoria'];
  $tipo = $_GET['tipo'];
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
                      <img src="<?php echo $row['foto']; ?>" alt=""><?php echo $row['user']?>
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

        <!-- inicio página blanco -->
        <div class="right_col" style="height: 126vh;">
          <h3 align="right"><button type="button" name="tipsMem" class="btn-round btn-primary" data-toggle="modal" data-target="#tipsMem" align="right"><i class="fa fa-info-circle"></i></button></h3>

          <h1>Memorama</h1>
          <input type="hidden" name="tipo" id="idTipo" value="<?php echo $tipo;?>">
          <input type="hidden" name="idGrupo" id="idGrupo" value="<?php echo $_GET['idGrupo'];?>">
          <input type="hidden" name="idHistoria" id="idHistoria" value="<?php echo $_GET['idHistoria'];?>">
          <div class="tile_count" align="center">
            <form class="form-horizontal" method="POST">
              <div align="left">
                <table>
                  <tr style="align-items: center;">
                    <td width=""><h3>Nombre actividad  </h3></td>
                    <td style="align-content: center;"><input type="text" name="nom_act" id="nom_act" placeholder="Nombre actividad" style="border-radius: 10px; width: 200px;"></td>
                  </tr>
                </table>
              </div>

              <br>
              <div>
                <div class="col-md-12">
                  <div class="x_panel">
                    <div class="x_title"><h5>Definir historia</h5></div>
                    <div class="clearfix"></div>

                    <div class="x_content"><!-- Text area -->
                    <div id="alerts"></div>
                    <textarea id="descr" required="required" class="form-control" name="message" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10" style="height: 55vh;"></textarea>
                    <br>

                      <input type="button" align="center" class="btn btn-success " name="guardar" value="Guardar Historia" onclick="crearActividad(<?php echo $_GET['idHistoria']?>,<?php echo $_GET['tipo']?>);  guardarText();">
                     <br>

                    <!--Modal tips-->
                    <div id="tipsMem" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content" style="width: 110%;">
                          <div class="modal-header">
                            <h3 class="modal-title" id="myModalLabel" style="color: #75163F">Tips</h3>
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                          </div>
                        <div class="modal-body">
                          <table>
                            <!--Recuadro para el tip-->
                            <div class="col-md-12" style="height: 30vh;">
                            <div class="box box-solid" style="background: #EBB9F8; border-color: #EBB9F8; height: 200px;">
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="width:800px; height: 170px; align-items: center;">
                              <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                
                              </ol>
                              <div class="carousel-inner" style="width:800px">
                                <div class="carousel-item active">
                                  <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="First slide">¿Qué debe ir en el campo "Definir Historia"?</h5>
                                  <hr style="background-color: #75163F; width: 50%;">
                                  <br>
                                  <h6 style="color: #75163F; font-family:sans-serif;">La historia particular debe tener una completa relación con la historia principal antes descrita ya que sirve para <b>complementar</b> y <b>agregar detalles específicos</b> de cada actividad al contexto del juego.</h6>
                                </div>
                                <div class="carousel-item" >
                                  <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="Second slide">¿En qué consiste el juego?</h5>
                                  <hr style="background-color: #75163F; width: 50%;">
                                  <h6 style="color: #75163F; font-family:sans-serif;">El memorama es un juego que puede ayudar a memorizar conceptos e información, consiste en una serie de cartas con pares acomodadas de manera inversa y aleatoria en la pantalla a manera de tablero. El usuario va destapando cartas al azar para descubrir las imágenes iguales. El juego termina cuando se agoten los intentos permitidos</h6>
                                </div>
                              </div>
                            </div>
                            </div>
                            <!-- /.box -->
                            </div>
                          </table>
                        </div>
                          <div class="modal-footer"></div>
                        </div>
                      </div>
                    </div>

                  </div>

                </div>
              </div> 
            </form>
          </div>          
        </div>
        <!-- fin página blanco-->

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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../tables/crudMemorama.js"></script>
  
  </body>
</html>
