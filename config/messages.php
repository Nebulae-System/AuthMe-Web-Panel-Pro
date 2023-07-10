<?php
$notificaciones = array();

try{
  $conn = new mysqli($ip, $user, $pass, $db);
}catch (Exception $e){
  if (str_contains($e , "mysqli_sql_exception: Unknown database") == true){
    $mensaje = "La base de datos llamada '".$db."' no existe.";
    array_push($notificaciones, $mensaje);
    // echo "<h1>Error:</h1><br><h2>La base de datos llamada '".$db."' no existe.<br><br>Si el problema persiste, revisa la configuracion del sitio web y compara con la base de datos.</h2>";
    // exit();
  }else{
    $mensaje = "Las especificaciones de la base de datos no coinciden...";
    array_push($notificaciones, $mensaje);
    // echo "<h1>Error:</h1><h2>Las especificaciones dentro del archivo 'config.php' no coinciden con la base de datos...</h2><br>".$e;
  }
}

if($conn){
  try{
    $row = mysqli_query($conn, "ALTER TABLE ".$table." ADD column token VARCHAR(8) AFTER totp;");
  }catch (Exception $e){
    if (str_contains($e , "mysqli_sql_exception: Duplicate column name 'token'") == false){
      $mensaje = "Al parecer no has instalado <a href='https://www.spigotmc.org/resources/authmereloaded.6269/'>AuthMeReloaded</a> o no has configurado la conexion con la base de datos.";
      array_push($notificaciones, $mensaje);
      // echo "<h1>Error:</h1><br><h2>New Authme Panel PRO Requiere <a href='https://www.spigotmc.org/resources/authmereloaded.6269/'>AuthMeReloaded</a>.<br>(Requiere configurar base de datos).<br><br>Si el problema persiste, revisa la configuracion del sitio web y compara con la base de datos.</h2>";
      // exit();
    }
  }

  try{
    $result = mysqli_query($conn, "SELECT * FROM Players");
  }catch (Exception $e){
    $mensaje = "Al parecere no has instalado <a href='https://www.spigotmc.org/resources/skinsrestorer.2124/'>SkinsRestorer</a> o no has configurado la conexion con la base de datos.";
    array_push($notificaciones, $mensaje);
    // echo "<h1>Error:</h1><br><h2>New Authme Panel PRO Requiere <a href='https://www.spigotmc.org/resources/skinsrestorer.2124/'>SkinsRestorer</a>.<br>(Requiere configurar base de datos).</h2>";
  }
}else{
  $mensaje = "No se ha establecido conexion con la base de datos...";
  array_push($notificaciones, $mensaje);
}
?>