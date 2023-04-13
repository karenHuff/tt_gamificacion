<?php
  include 'conexion.php';
  //echo "hola mundo";
  $Resultado = array();
  if (isset($_POST['palabra']) && isset($_POST['desc']) && isset($_POST['idActv']) && isset($_POST['accion'])) {
  # code...
  if ($_POST['accion']=='guardarPaCruci') {
    # code...
    $idCrucigrama = $_POST['idActv'];
    $conAct = "SELECT * FROM crucigrama WHERE id_actividades = '$idCrucigrama'";
    $result = $Con->query($conAct);
    $row = $result->fetch_assoc();
    $palabraC = $_POST['palabra'];
    $descripcion = $_POST['desc'];
   
    $QueryAddP ="INSERT INTO crucigrama_preguntas(id, palabra, descripcion, crucigrama_id_actividades) VALUES (NULL, '".$palabraC."','".$descripcion."', '".$row['id_actividades']."')";
    //echo $QueryAddP;
      if (mysqli_query($Con,$QueryAddP)) {
        $idNew = mysqli_insert_id($Con);
        $Resultado['estado']=1;
        $Resultado['mensaje']="Palabra agregada";
        $Resultado['id']=$idNew;    
      }else{
        $Resultado['estado']=0;
        $Resultado['mensaje']="Ocurrió un error desconocido";
      }
    mysqli_close($Con);
  }else{
    $Resultado['estado']=0;
    $Resultado['mensaje']="Acción no válida";
  }
}else{
  $Resultado['estado']=0;
  $Resultado['mensaje']="Faltan parámetros";
}
echo json_encode($Resultado);


  ?>