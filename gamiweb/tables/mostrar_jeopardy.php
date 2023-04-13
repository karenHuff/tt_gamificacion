<?php 
  session_start();
  require 'conexion.php';

  $errores = array();
  $resultado = array();

  if (!isset($_SESSION['id_usuario'])) {
    // code...
    header("Location: login.php");
  }

  $idUsuario = $_SESSION['id_usuario'];

  $Cx = "SELECT id, nombre, apaterno, amaterno, user, foto FROM usuarios WHERE id = '$idUsuario'";
  $result = $Con->query($Cx);

  $row = $result->fetch_assoc();

  $idActividad = $_GET['idActividad'];
  //echo $idActividad;



  $QueryCategoria = "SELECT * FROM jeopardy_categoria WHERE Jeopardy_id_actividades = '$idActividad'";
  $ResultadoCategoria = $Con->query($QueryCategoria);

  $QueryJeopardy = "SELECT j.id_actividades, jc.Jeopardy_id_actividades, jc.nom_cat, jp.pregunta, jp.resp_uno, jp.resp_dos, jp.resp_tres, jp.resp_cuatro, jp.puntaje, jp.id, jp.categoria_id FROM jeopardy as j JOIN jeopardy_categoria as jc ON(j.id_actividades=jc.Jeopardy_id_actividades) JOIN jeopardy_preguntas as jp ON(jc.id=jp.categoria_id) WHERE j.id_actividades='$idActividad' ORDER by jp.puntaje ASC, jp.categoria_id"; 
  //echo $QueryJeopardy;
  $ResultadoJeopardy = $Con->query($QueryJeopardy);
 
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
    <!--estructura jeopardy-->
    <link rel="stylesheet" href="../tables/css/jeopardy/estilosJeopardy.css">
    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
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
                <h2><?php echo $row['nombre']; ?></h2> <!-- nombre de usuario-->
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
                  <li><a><i class="fa fa-group"></i>Grupos<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php
                        $sql="SELECT * from grupo WHERE id_user = '$idUsuario'";
                        $result= mysqli_query($Con, $sql);

                        while ($mostrar=mysqli_fetch_array($result)
                        ) {
                        
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
                      <!-- se tiene que agregar el nombre del usuario-->
                      <img src="<?php echo $row['foto']; ?>" alt=""><?php echo $row['user'];?> <!--cambio aquí--> 
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item"  href="login.php"><i class="fa fa-sign-out pull-right"></i>Cerrar sesión</a>
                    </div>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- Página básica en blanco--> 
        <div class="right_col">
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" name="idActv" id="idActv" value="<?php echo $_GET['idActividad'];?>">
            <?php
              $mostrarJeopardy = "SELECT * FROM jeopardy WHERE id_actividades = '$idActividad'";
              $resultJeopardy = mysqli_query($Con, $mostrarJeopardy);
              $resJeopa = mysqli_fetch_array($resultJeopardy);
            ?>
            <div class="x_panel"> 
              <div>
                <p><?php echo $resJeopa['historia_part'];?>
              </div>
            </div>
            
          </div>
            <table>
            <tr>
              <td>
                <h3>Vista previa: </h3>
              </td>
              <td>
                 <div class="tile_count" align="center">
                    <h5><?php echo $resJeopa['nom_act'];?></h5>
                </div>
              </td>
            </tr>
          </table>
            <div class="col-md-12">
                <div class="x_panel">
                  <table class="content_t"> 
                    <thead>
                      <?php
                        $NumCate = mysqli_num_rows($ResultadoCategoria);
                        //echo $NumCate;
                        while($mostrar = $ResultadoCategoria->fetch_assoc()){
                      ?>
                    <td>
                      <?php echo $mostrar['nom_cat'];?>
                    </td> 
                      <?php
                        }
                      ?>
                    </thead>
                    <tbody>
                      <tr>
                      <?php 
                        $Contador=1;
                        $NumCate = mysqli_num_rows($ResultadoCategoria);
                        // echo ("son: ".$NumCate." categorias");
                        while ($mostrarPuntaje = $ResultadoJeopardy->fetch_assoc()) {
                          //echo "-".$mostrarPuntaje['puntaje']."-";
                          if($Contador==$NumCate){ 
                            ?>
                             <td>
                            <button type="button" class="btn btn-block fondoPuntaje" data-toggle="modal" data-target=".bs-example-modal-lg" id="btn_puntaje_<?php echo $mostrarPuntaje['id'];?>" onclick="identificaID(<?php echo $mostrarPuntaje['id'];?>);"><?php echo $mostrarPuntaje['puntaje'];?> 
                            </button>
                            </td>
                        <?php
                            echo "</tr>";
                            $Contador=0;
                            //echo $Contador;
                            echo "<tr>";
                          }
                          else{

                              //echo $Contador;
                        ?>
                        <td>
                          <button type="button" class="btn btn-block fondoPuntaje" data-toggle="modal" data-target=".bs-example-modal-lg" id="btn_puntaje_<?php echo $mostrarPuntaje['id'];?>" onclick="identificaID(<?php echo $mostrarPuntaje['id'];?>);"><?php echo $mostrarPuntaje['puntaje'];?> 
                          </button>
                        </td>
                        <?php
                          }
                          $Contador++;
                        }
                        echo "</tr>";
                      ?>
                    </tbody>
                  </table>
                  <br>
                  <!-- modal para abrir la pregunta-->
                  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal-lg">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content" class="estilos" id="jeo">
                      <div class="modal-header" class="text-edit">
                        <div class="encabezado" id="categoriaAux"><h5 id="categoria" align="left"></h5></div>
                      </div>
                      <div class="modal-body" align="center">
                        <div class="encabezado" align="center" id="preguntaAux"><h3 align="center" id="pregunta"></h3></div>
                        <br>
                        <table width="100%" align="center">
                          <tr>
                            <td width="50%"><div class="btnR" id="btn1Aux" onclick="oprimir(0);"><h6 align="left" id="btn1"></h6></div></td>
                            <td width="50%"><div class="btnR" id="btn2Aux" onclick="oprimir(1);"><h6 align="left" id="btn2"></h6></div></td>
                          </tr>
                          <tr>
                            <td width="50%"><div class="btnR" id="btn3Aux" onclick="oprimir(2);"><h6 align="left" id="btn3"></h6></div></td>
                            <td width="50%"><div class="btnR" id="btn4Aux" onclick="oprimir(3);"><h6 align="left" id="btn4"></h6></div></td>
                          </tr>
                        </table>
                      </div>   
                    </div>
                  </div>
                </div>
                  
                  <div class="col-md-4"></div>
                  <div class="col-md-4" align="center">
                  <div class="x_panel">
                    <div class="x_content">
                      <div align="center">                          
                      <a class="btn btn-danger submit" href="crear_actividades.php?idGrupo=<?php echo $_GET['idGrupo'];?>&idHistoria=<?php echo $_GET['idHistoria']?>&idActividad=<?php echo $_GET['idActividad'];?>">Siguiente</a> 
                      </div>        
                    </div>                      
                  </div>
                </div>    
              </div>            
          </div>
          
        </div>
        
       <!--footer content -->
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
    <script src="../tables/css/jeopardy/crudRespuestasJeopardy.js"></script>
    <!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>
    
  </body>
</html>
