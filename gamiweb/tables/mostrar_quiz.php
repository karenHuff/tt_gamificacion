<?php 
  session_start();
  require 'conexion.php';
  require 'funcs.php';

  //Si bandRegistros = 0 NO HAY REGISTRO
  //Si bandRegistros = 1 SI HAY REGISTRO
  //$bandRegistros=0;

  if (!isset($_SESSION['id_usuario'])) {
    // code...
    header("Location: login.php");
  }

  $idUsuario = $_SESSION['id_usuario'];

  $Cx = "SELECT id, nombre, apaterno, amaterno, user, foto FROM usuarios WHERE id = '$idUsuario'";
  $result = $Con->query($Cx);

  $row = $result->fetch_assoc();

  $quiz = $_GET['idActividad'];
  //echo($quiz);
  $QueryConQuiz = "SELECT * FROM quiz where id_actividades = '$quiz' ";
  $ResultadoQC = $Con->query($QueryConQuiz);
  $num_rows = mysqli_num_rows($ResultadoQC);

  //Variables para el quiz.
  $QueryQuiz="SELECT id, pregunta, inc_uno, respuesta, inc_dos, inc_tres, puntaje FROM quiz_preguntas WHERE quiz_id_actividades = '$quiz'";

  //Ejecutamos y guardamos el resultado
  $ResultadoQuiz=mysqli_query($Con,$QueryQuiz);
  $RQuiz = mysqli_fetch_array($ResultadoQuiz);
   
  //Obtener registro x registro
  $bandRegistros=1;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GAMIWEB</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!--Estilo para el quiz-->
    <link rel="stylesheet" href="../tables/css/quiz/estilosQuiz.css">

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
            <!-- /menu profile quick info -->

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
                        $sql="SELECT * FROM grupo WHERE  id_user = '$idUsuario'";
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

            <!-- /menu footer buttons -->
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

        <!-- page content -->
        <div class="right_col" style="height: 150vh;">
          <div class="col-md-12">

            <input type="hidden" name="idActv" id="idActv" value="<?php echo $_GET['idActividad'];?>">

            <?php
              $idActividad = $_GET['idActividad'];
              $mostrarQuiz = "SELECT * FROM quiz WHERE id_actividades = '$idActividad'";
              $resultQuizz = mysqli_query($Con, $mostrarQuiz);
              //echo $resultQuizz;
              $resQuiz = mysqli_fetch_array($resultQuizz);
            ?>
            <div class="x_panel"> 
              <div>
                <p><?php echo $resQuiz['historia_part'];?></p>
              </div>
            </div>
            
          </div>
          <div class="col-md-12">
          <table>
            <tr>
              <td>
                <h3>Vista previa: </h3>
              </td>
              <td>
                 <div class="tile_count" align="center">
                    <h5><?php echo $resQuiz['nom_act']; ?></h5>
                </div>

              </td>
            </tr>
          </table>
          <br>
        </div>
      <div class="col-md-1"></div>
      <div class="col-md-10">
        <div class="x_panel" align="center">
          <div class="x_content">
            <!-- estructura donde se muestran las preguntas y respuestas -->
              <div class="estilos" id="quiz"> <!-- cambio aquí-->
              <div class="encabezado" id="preguntaAux">
                <h3 align="center" id="pregunta"></h3>
              </div>
              <div class="btnR" id="btn1Aux" onclick="oprimir(0)"><h6 align="center" id="btn1"></h6></div>
              <div class="btnR" id="btn2Aux" onclick="oprimir(1)"><h6 align="center" id="btn2"></h6></div>
              <div class="btnR" id="btn3Aux" onclick="oprimir(2)"><h6 align="center" id="btn3"></h6></div>
              <div class="btnR" id="btn4Aux" onclick="oprimir(3)"><h6 align="center" id="btn4"></h6></div>
              </div>
            </div>
          </div>
        </div>

      <div class="col-md-4"></div>
      <div class="col-md-4">
        <div class="x_panel">
          <div class="x_content">
            <br>
            <div align="center">                          
              <a class="btn btn-danger submit" href="crear_actividades.php?idGrupo=<?php echo $_GET['idGrupo'];?>&idHistoria=<?php echo $_GET['idHistoria']?>&idActividad=<?php echo $_GET['idActividad'];?>">Siguiente</a> 
              </div>        
          </div>                      
        </div>
      </div>

    </div>

      </div>
    </div>
</body>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!--Script para el quiz-->
    <script src="../tables/css/quiz/crudRespuestasQuiz.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  </body>
</html>