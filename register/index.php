<?php include('register.php'); ?>
<!DOCTYPE html>
<html>
<?php include('../header.php'); ?>
  <?php if($_SESSION['token']){ ?>
    <?php if($_SESSION['token'] !== "VERIFIED"){ ?>
      <form class="container" method="post" novalidate>
        <?php //echo $_SESSION['token'] ?>
        <h1>Verifica tu Email</h1>
        <p>Busca el codigo de verificacion que hemos enviado a tu email.</p>
        <input type="text" name="code" id="token" placeholder="Codigo de verificacion" required><br>
        <div class="hint"><img src="https://img.icons8.com/material/16/info--v1.png" draggable="false" oncontextmenu="return false"><p>Tal vez el codigo se encuentre en spam.</p></div>
        <input class="submit" type="submit" name="token" value="Enviar Codigo">
      </form>
    <?php }else{
      header('location: /login');
    } ?>
  <?php }else{ ?>
    <form method="post" action="" class="container" novalidate>
      <?php if ($conn->connect_error) { ?>
        <h1>Conexion Fallida</h1>
        <p>Por favor, vuelva a intentarlo mas tarde...</p>
        <input class="submit" type="submit" onclick="window.location.reload();" value="Recargar...">
      <?php die();} ?>
      <img class="container-logo" src="<?php echo $container_icon ?>" draggable="false" oncontextmenu="return false">
      <h1>Crear Cuenta</h1>
      <input type="text" name="user" placeholder="Nickname" required><br>
      <div class="hint"><img src="https://img.icons8.com/material/16/info--v1.png" draggable="false" oncontextmenu="return false"><p>El nombre que utilizaras en el juego.</p></div>
      <input type="email" name="email" placeholder="Email" required><br>
      <div class="hint"><img src="https://img.icons8.com/material/16/info--v1.png" draggable="false" oncontextmenu="return false"><p>Asegurate de que sea un email real.</p></div>
      <input type="password" name="pass" placeholder="Contraseña" required><br>
      <div class="hint"><img src="https://img.icons8.com/material/16/info--v1.png" draggable="false" oncontextmenu="return false"><p>Debe tener minino 8 caracteres.</p></div>
      <input type="password" name="vpass" placeholder="Confirmar contraseña" required><br>
      <div class="hint"><img src="https://img.icons8.com/material/16/info--v1.png" draggable="false" oncontextmenu="return false"><p>Vuelve a ingresar tu contraseña.</p></div>
      <input class="submit" type="submit" name="register" value="Registrarse">
      <div class="links">
        <a>Ya tienes cuenta? </a><a href="/login" class="clickable">Iniciar Sesion</a>
      </div>
      
    </form>
  <?php } ?>

<?php include('../footer.php'); ?>
  
</html>