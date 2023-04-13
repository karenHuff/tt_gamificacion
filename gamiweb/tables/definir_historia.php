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
  
  //obtener id de la tabla grupo
  $sql="SELECT id, nomGrupo FROM grupo WHERE  id_user = '$idUsuario'";
  $result= $Con->query($sql); 

  $sqlHistoria = "SELECT * FROM historia";
  $resHis = $Con->query($sqlHistoria); 
  $renglonResHistoria=mysqli_fetch_array($resHis);

  $queryPaisaje = "SELECT * FROM paisaje";
  $ResultadoP = $Con->query($queryPaisaje);

  $queryPersonaje = "SELECT * FROM personaje";
  $ResultadoPer = $Con->query($queryPersonaje);
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
    <style type="text/css">
      tablescroll{
        height: 150px;
        width: 50%;
        overflow:auto;
      }
    </style>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
             <a href="" class="site_title"><i class="fa fa-desktop"></i> <span>GAMIWEB</span></a>
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
                  <li><a href="actividades.php"><i class="fa fa-gamepad"></i> Actividades</a></li>
                  <li><a href="ranking.php"><i class="fa fa-sitemap"></i>Ranking</a></li>
                  <li><a href="premiaciones.php"><i class="fa fa-gift"></i> Premiaciones</a></li>
                  <li><a><i class="fa fa-group"></i>Tus grupos<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php
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

       <!-- Página básica en blanco--> 
        <div class="right_col" >
          <div class="row">
          <h3>Crear actividades</h3>
          <div class="tile_count" align="center" >
            <form  method="POST"> 
              <br>
                <!-- text area-->
                <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h5>Definir historia</h5>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div id="alerts" ></div>
                      <textarea id="descr" required="required" class="form-control" name="message" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10" style="height: 55vh;"></textarea>
                      
                      <!--<div id="editorOne" class="editor-wrapper"></div>
                      <textarea name="descr" id="descr" style="display:none;"></textarea>-->
                      <br>
                      <br>
                      <!--inicio vista modal-->
                        <div class="x_title">
                          <h5>Definir persoanje</h5>
                        </div>

                        <div class="col-md-6">
                         <!--imagen 1 -->
                          <?php 
                            while ($newRen = $ResultadoP->fetch_assoc() ) {
                            
                          ?>
                          <div class="col-md-6 col-sm-6"  align="center">
                            <div class="animated flipInY" >
                             <img src="<?php echo $newRen['imagen_paisaje']; ?>" height="190" width="210" align="center"><br>
                                <input type="radio" name="idPaisaje" id="idPaisaje_<?php echo $newRen['id_paisaje'];?>" style="align-content: center;" value="<?php echo $newRen['id_paisaje']?>">
                            </div>
                            <br>
                          </div>
                          <?php
                            }
                          ?> 
                        
                        </div>


                      <div class="col-md-6">
                        <?php 
                          while ($ren = $ResultadoPer->fetch_assoc() ) {
                          
                        ?>
                          <div class="col-md-6 col-sm-6">
                            <div class="animated flipInY">
                              <img src="<?php echo $ren['imagen_personaje']; ?>" height="190" width="210" align="center"><br>
                              <input type="radio" name="idPersonaje" id="idPersonaje_<?php echo $ren['id_personaje'];?>" value="<?php echo $ren['id_personaje'];?>">
                              
                            </div>
                            <br>
                          </div>
                        <?php
                          }
                        ?> 
                        
                      </div>

                      <br>
                      <br>
                      <div class="col-md-6"></div>
                      <div class="col-md-12"></div>
                        <div align="center" class="col-md-12">
                          <input type="button" align="center" class="btn btn-success btn-block" name="guardar" style="width: 80px;" value="Guardar" onclick="Guardar();">
                        </div>

                      <div>
                        <input type="hidden" name="idGrupo" id="idGrupo" value="<?php echo $_GET['idGrupo']?>">
                      </div>

                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        </div>

        <!-- footer content
        <footer>
          <div class="pull-right">
            
          </div>
          <div class="clearfix"></div>
        </footer>
       footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="../vendors/google-code-prettify/src/prettify.js"></script>
    <script type="text/javascript" src="../tables/crudDefinir_historia.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
  </body>
</html>
