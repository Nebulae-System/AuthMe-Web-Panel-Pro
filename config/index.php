<?php include('config.php'); ?>
<!DOCTYPE html>
<html>
<?php include('../header.php'); ?>
  <?php if($_SESSION['admin']){ ?>
    <?php include('messages.php'); ?>
    <?php if($_SESSION['admin-messages']){ ?>
      <form method="post" class="container" novalidate>
        <h1>Registros</h1>
        <br>
        <?php
          $notify = 0;
          foreach ($notificaciones as $notificacion) {
            $notify +=1;
            echo "<h4>".$notify.") ".$notificacion."</h4><br>";
          }
        ?>
        <input class="submit" type="submit" name="messages-back" value="Volver">
      </form>
    <?php }elseif($_SESSION['admin-edit']){ ?>
      <form method="post" class="container" novalidate>
        <h1>Cambiar Clave</h1>
        <input type="password" name="old-pass" placeholder="Contraseña Actual" required><br>
        <input type="password" name="pass1" placeholder="Contraseña Nueva" required><br>
        <input type="password" name="pass2" placeholder="Repetir Contraseña Nueva" required><br>
        <input class="button-list" type="submit" name="change" value="Cambiar Contraseña">
        <button class="submit" name="change-back">Volver</button>
      </form>
    <?php }else{ ?>
      <form method="post" class="container" novalidate>
        <h1>Panel Configuracion</h1>
        <button class="button-list" name=config">Cambiar Configuracion</button>
        <button class="button-list" name="messages">Registros (<?php echo count($notificaciones); ?>)</button>
        <button class="button-list" name="change-pass">Cambiar Contraseña</button>
        <button class="submit" name="logout">Cerrar Sesion</button>
      </form>
    <?php } ?>
  <?php }else{ ?>
    <form method="post" action="" class="container" novalidate>
      <h1>Panel Configuracion</h1>
      <input type="text" name="user" placeholder="Usuario" required><br>
      <input type="password" name="pass" placeholder="Contraseña" required><br>
      <input class="submit" type="submit" name="login" value="Iniciar Sesion">
    </form>
  <?php } ?>

<?php include('../footer.php'); ?>
  
</html>