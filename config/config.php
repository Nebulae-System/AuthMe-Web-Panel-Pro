<?php
include('../config.php');

session_start();

// OCULTAMOS LOS WARNING
error_reporting(E_ERROR | E_PARSE);
// error_reporting(0);

// Verificar si el archivo SQLite existe
$archivo_sqlite = 'config.sqlite';

if (!file_exists($archivo_sqlite)) {
  // Crear el archivo SQLite si no existe
  $conexion = new PDO('sqlite:' . $archivo_sqlite);

  // Crear la tabla usuarios
  $creacion_tabla = 'CREATE TABLE usuarios (
                      id INTEGER PRIMARY KEY AUTOINCREMENT,
                      usuario TEXT NOT NULL,
                      contrasena TEXT NOT NULL
                    )';
  $conexion->exec($creacion_tabla);

  // Establecer el usuario "admin" con contraseña encriptada usando bcrypt
  $usuario_admin = 'admin';
  $contrasena_admin = password_hash('admin', PASSWORD_DEFAULT);
  $insercion_admin = "INSERT INTO usuarios (usuario, contrasena) VALUES (:usuario, :contrasena)";
  $declaracion_admin = $conexion->prepare($insercion_admin);
  $declaracion_admin->bindParam(':usuario', $usuario_admin);
  $declaracion_admin->bindParam(':contrasena', $contrasena_admin);
  $declaracion_admin->execute();

  // Cerrar la conexión a la base de datos
  $conexion = null;
}

if(isset($_POST['login'])){
  $usuario = $_POST['user'];
  $contrasena = $_POST['pass'];

  try {
    // Verificar las credenciales en la base de datos SQLite utilizando PDO
    $conexion = new PDO('sqlite:' . $archivo_sqlite);
  
    // Realizar la consulta SQL para buscar las credenciales en la tabla de usuarios
    $consulta = "SELECT * FROM usuarios WHERE usuario = :usuario";
    $declaracion = $conexion->prepare($consulta);
    $declaracion->bindParam(':usuario', $usuario);
    $declaracion->execute();
  
    // Verificar si se encontró el usuario y si la contraseña coincide
    if ($fila = $declaracion->fetch(PDO::FETCH_ASSOC)) {
      if (password_verify($contrasena, $fila['contrasena'])) {
        $_SESSION['admin'] = $usuario;
      } else {
        $error = "Credenciales inválidas. Inicio de sesión fallido.";
      }
    } else {
      $error = "Credenciales inválidas. Inicio de sesión fallido.";
    }
  } catch (PDOException $e) {
    $error = "Error al conectar con la base de datos: " . $e->getMessage();
  }
  
  // Cerrar la conexión a la base de datos
  $conexion = null;
}

if(isset($_POST['change-pass'])){
  $_SESSION['admin-edit'] = true;
}

if(isset($_POST['change-back'])){
  unset($_SESSION['admin-edit']);
}

if(isset($_POST['change'])){
  // Obtener los valores enviados por el formulario
  $oldPass = $_POST['old-pass'];
  $newPass1 = $_POST['pass1'];
  $newPass2 = $_POST['pass2'];

  if(!$oldPass or !$newPass1 or !$newPass2){
    $error = "Por favor rellena todos los datos!";
  }else{
    // Verificar si la contraseña anterior coincide con la clave almacenada en el archivo SQLite
    $conexion = new PDO('sqlite:' . $archivo_sqlite);
    $consulta = "SELECT contrasena FROM usuarios WHERE usuario = :usuario";
    $declaracion = $conexion->prepare($consulta);
    $declaracion->bindParam(':usuario', $_SESSION['admin']);
    $declaracion->execute();
    $fila = $declaracion->fetch(PDO::FETCH_ASSOC);
    $claveAlmacenada = $fila['contrasena'];

    if (!password_verify($oldPass, $claveAlmacenada)) {
      $error = "La contraseña actual es incorrecta.";
    } else if ($newPass1 !== $newPass2) {
      $error = "Las contraseñas nuevas no coinciden.";
    } else {
      // Encriptar la nueva contraseña
      $nuevaClaveEncriptada = password_hash($newPass1, PASSWORD_DEFAULT);

      // Actualizar la clave en el archivo SQLite
      $actualizacion = "UPDATE usuarios SET contrasena = :nuevaClave WHERE usuario = :usuario";
      $declaracion = $conexion->prepare($actualizacion);
      $declaracion->bindParam(':nuevaClave', $nuevaClaveEncriptada);
      $declaracion->bindParam(':usuario', $_SESSION['admin']);
      $declaracion->execute();

      unset($_SESSION['admin-edit']);

      $error = "La contraseña se ha actualizado correctamente.";
    }
  }
}

if(isset($_POST['messages'])){
  $_SESSION['admin-messages'] = true;
}

if(isset($_POST['messages-back'])){
  unset($_SESSION['admin-messages']);
}

if(isset($_POST['logout'])){
  unset($_SESSION['admin']);
}
?>
