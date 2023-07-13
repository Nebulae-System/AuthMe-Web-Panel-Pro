<?php include('config.php'); ?>
<!DOCTYPE html>
<html>
<?php include('../header.php'); ?>
  <?php if($_SESSION['admin']){ ?>
    <?php include('messages.php'); ?>
    <?php if($_SESSION['admin-db']){ ?>
      <form method="post" class="container" novalidate>
        <?php if($img){
          echo '<img class="container-logo" src="'.$img.'" draggable="false" oncontextmenu="return false">';
        }else{ ?>
          <img class="container-logo" src="https://img.icons8.com/?size=512&id=17947&format=png" draggable="false" oncontextmenu="return false">
        <?php } ?>
        <h1>Especificar una Base de Datos</h1>
        <input type="text" name="db" placeholder="Nombre Base de Datos" required><br>
        <input type="text" name="table" placeholder="Tabla Base de Datos" required><br>
        <input class="button-list" type="submit" name="verify-db" value="Comprobar Conexion">
        <button class="submit" name="db-back">Volver</button>
      </form>
    <?php }elseif($_SESSION['admin-config']){ ?>
      <form method="post" class="container" novalidate>
        <?php if($img){
          echo '<img class="container-logo" src="'.$img.'" draggable="false" oncontextmenu="return false">';
        }else{ ?>
          <img class="container-logo" src="https://img.icons8.com/?size=512&id=17947&format=png" draggable="false" oncontextmenu="return false">
        <?php } ?>
        <h1>Cambiar Configuracion</h1>
        <input type="text" name="ip" placeholder="IP Base de Datos" required><br>
        <input type="text" name="user" placeholder="Usuario Base de Datos" required><br>
        <input type="password" name="pass" placeholder="Clave Base de Datos" required><br>
        <input class="button-list" type="submit" name="connect" value="Probar Conexion">
        <button class="submit" name="config-back">Volver</button>
      </form>
    <?php }elseif($_SESSION['admin-messages']){ ?>
      <form method="post" class="container" novalidate>
        <h1>Registros</h1>
        <br>
        <?php
          if(count($notificaciones) > 0){
            $notify = 0;
            foreach ($notificaciones as $notificacion) {
              $notify +=1;
              echo "<h4>".$notify.") ".$notificacion."</h4><br>";
            }
          }
        ?>
        <input class="submit" type="submit" name="messages-back" value="Volver">
      </form>
    <?php }elseif($_SESSION['admin-edit']){ ?>
      <form method="post" class="container" novalidate>
        <img class="container-logo" src="https://img.icons8.com/?size=512&id=17947&format=png" draggable="false" oncontextmenu="return false">
        <h1>Cambiar Clave</h1>
        <input type="password" name="old-pass" placeholder="Contraseña Actual" required><br>
        <input type="password" name="pass1" placeholder="Contraseña Nueva" required><br>
        <input type="password" name="pass2" placeholder="Repetir Contraseña Nueva" required><br>
        <input class="button-list" type="submit" name="change" value="Cambiar Contraseña">
        <button class="submit" name="change-back">Volver</button>
      </form>
    <?php }else{ ?>
      <form method="post" class="container" novalidate>
        <img class="container-logo" src="https://img.icons8.com/?size=512&id=17947&format=png" draggable="false" oncontextmenu="return false">
        <h1>Panel de Configuracion</h1>
        <button class="button-list" name="config">Cambiar Configuracion</button>
        <?php
          if(count($notificaciones) > 0){
            echo '<button class="button-list" name="messages">Registros ('.count($notificaciones).')</button>';
          }
        ?>
        <button class="button-list" name="change-pass">Cambiar Contraseña</button>
        <button class="submit" name="logout">Cerrar Sesion</button>
      </form>
    <?php } ?>
  <?php }else{ ?>
    <form method="post" action="" class="container" novalidate>
      <img class="container-logo" src="https://img.icons8.com/?size=512&id=17947&format=png" draggable="false" oncontextmenu="return false">
      <h1>Panel de Configuracion</h1>
      <input type="text" name="user" placeholder="Usuario" required><br>
      <input type="password" name="pass" placeholder="Contraseña" required><br>
      <input class="submit" type="submit" name="login" value="Iniciar Sesion">
    </form>
  <?php } ?>

<?php include('../footer.php'); ?>
  
</html>