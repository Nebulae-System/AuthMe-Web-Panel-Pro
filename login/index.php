<?php include('login.php'); ?>
<!DOCTYPE html>
<html>
<?php include('../header.php'); ?>
<script type="text/javascript" src="../src/js/nickname.js"></script>
  <?php if($_SESSION['realname']){ ?>
    <?php if($_SESSION['edit']){ ?>
      <form class="container" action="" method="post" novalidate>
        <h1>Editar Perfil</h1>
        <div class="center"><p class="minecraft-nickname"><?php echo $_SESSION['realname']; ?></p></div>
        <div class="edit-profile">
          <div class="img" id="skinbg">
            <img id="skin" src="data:image/jpeg;base64,<?php echo getbase64(); ?>" draggable="false" oncontextmenu="return false" onclick="
              if(this.offsetHeight == 110){
                this.style.height = '220px';
              }else{
                this.style.height = '110px';
              }">
          </div>
        </div>
        <input type="text" class="input-left" name="skin-name" id="skin-name" placeholder="Nombre Jugador">
        <button for="skin-name" type="submit" class="input-right" name="search-skin">
          <img src="https://img.icons8.com/ios-glyphs/120/reviewer-male.png" draggable="false" oncontextmenu="return false">
        </button>
        <div class="submenu floatr">
          <button type="submit" class="save floatl" name="reset-skin" title="Reiniciar Skin" draggable="false" oncontextmenu="return false">
            <img src="https://img.icons8.com/ios-glyphs/120/synchronize.png">
          </button>
        </div>
        <div class="hint"><img src="https://img.icons8.com/material/16/info--v1.png" draggable="false" oncontextmenu="return false">
          <p>Replica la skin de un jugador premium.</p>
        </div>
        <input class="submit" type="submit" name="edit-back" value="Volver">
      </form>
    <?php }else{ ?>
      <form class="container" action="" method="post" novalidate>
        <h1>Hola de nuevo!</h1>
        <div class="profile">
          <div class="img" id="skinbg">
            <button type="submit" name="edit" class="edit">
              <img src="https://img.icons8.com/ios-glyphs/120/edit--v1.png" draggable="false" oncontextmenu="return false">
            </button>
            <img id="skin" src="data:image/jpeg;base64,<?php echo getbase64(); ?>" draggable="false" oncontextmenu="return false">
          </div>
          <div class="info">
            <h3>Nickname:</h3>
            <p><?php echo $_SESSION['realname']; ?></p>
            <h3>Email:</h3>
            <p><?php echo $_SESSION['email']; ?></p>
          </div>
        </div>
        <?php if($_SESSION['online'] == 0){ ?>
          <button class="button-list">Entrar al Servidor</button>
        <?php } ?>
        <button class="submit" type="submit" name="logout">Cerrar Sesion</button>
      </form>
    <?php } ?>
  <?php }else{ ?>
    <form method="post" action="" class="container" novalidate>
      <?php if ($conn->connect_error) { ?>
        <h1>Conexion Fallida</h1>
        <p>Por favor, vuelva a intentarlo mas tarde...</p>
        <input class="submit" type="submit" onclick="window.location.reload();" value="Recargar...">
      <?php die();} ?>
      <img class="container-logo" src="<?php echo $container_icon ?>" draggable="false" oncontextmenu="return false">
      <h1>Iniciar Sesion</h1>
      <input type="text" name="user" placeholder="Nickname" required><br>
      <input type="password" name="pass" placeholder="Contraseña" required><br>
      <input class="submit" type="submit" name="login" value="Iniciar Sesion">
      <div class="links">
        <a>Aun no tienes una cuenta? </a><a href="/register" class="clickable">Crear Cuenta</a>
        <br>
        <hr style="border-top: 3px dashed #bbb; width: 80%; margin: auto; margin-top: 5px; margin-bottom: 5px;">
        <a href="/recover" class="clickable">Olvide mi contraseña</a>
      </div>
      
    </form>
  <?php } ?>
<script type="text/javascript" src="../src/js/skincolor.js"></script>

<?php include('../footer.php'); ?>
  
</html>