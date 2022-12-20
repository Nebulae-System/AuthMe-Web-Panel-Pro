<?php include('recover.php'); ?>
<!DOCTYPE html>
<html>
<?php include('../header.php'); ?>

  <?php if($_SESSION['token']){ ?>
    <form class="container" method="post" novalidate>
      <?php //echo $_SESSION['token'] ?>
      <h1>Verifica tu Email</h1>
      <p>Busca el codigo de verificacion que hemos enviado a tu email.</p>
      <input type="text" name="code" id="token" placeholder="Codigo de verificacion" required><br>
      <div class="hint"><img src="https://img.icons8.com/material/16/info--v1.png" draggable="false" oncontextmenu="return false"><p>Tal vez el codigo se encuentre en spam.</p></div>
      <input class="submit" type="submit" name="verificar" value="Verificar Identidad">
    </form>
  <?php }else if($_SESSION['recover']){ ?>
    <form class="container" method="post" novalidate>
      <?php //echo $_SESSION['token'] ?>
      <h1>Establecer Contraseña</h1>
      <input type="password" name="pass1" id="pass1" placeholder="Nueva Contraseña" required><br>
      <div class="hint"><img src="https://img.icons8.com/material/16/info--v1.png" draggable="false" oncontextmenu="return false"><p>Ingresa tu nueva contraseña.</p></div>
      <input type="password" name="pass2" id="pass2" placeholder="Repetir Contraseña" required><br>
      <div class="hint"><img src="https://img.icons8.com/material/16/info--v1.png" draggable="false" oncontextmenu="return false"><p>Debe coincidir con la contraseña anterior.</p></div>
      <input class="submit" type="submit" name="change" value="Cambiar Contraseña">
    </form>
  <?php }else{ ?>
    <form method="post" action="" class="container" novalidate>
      <img class="container-logo" src="<?php echo $container_icon ?>" draggable="false" oncontextmenu="return false">
      <h1>Recuperar Cuenta</h1>
      <h5>Es necesario verificar tu identidad...</h5>
      <br>
      <input type="email" name="email" placeholder="Email" required><br>
      <div class="hint"><img src="https://img.icons8.com/material/16/info--v1.png" draggable="false" oncontextmenu="return false"><p>Ingresa el correo asociado a tu cuenta.</p></div>
      <input class="submit" type="submit" name="enviar" value="Listo">
      <div class="links">
        <a>Aun no tienes una cuenta? </a><a class="clickable" href="/register">Crear Cuenta</a>
        <br>
        <hr style="border-top: 3px dashed #bbb; width: 80%; margin: auto; margin-top: 5px; margin-bottom: 5px;">
        <a href="/login" class="clickable">Iniciar Sesion</a>
      </div>
    </form>
  <?php } ?>
<?php include('../footer.php'); ?>
</html>