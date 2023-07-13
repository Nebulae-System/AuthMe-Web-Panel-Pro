<!DOCTYPE html>
<html>
<?php include('../header.php'); ?>
    <form method="post" class="container" novalidate>
        <?php if($img){ ?>
          <img class="container-logo" src="<?php echo $img; ?>" draggable="false" oncontextmenu="return false">
        <?php }else{ ?>
          <img class="container-logo" src="https://img.icons8.com/?size=512&id=17947&format=png" draggable="false" oncontextmenu="return false">
        <?php } ?>
        <br>
        <h1><?php echo $problema; ?></h1>
        <button class="submit" name="back" onclick="window.location.href='<?php echo $back; ?>';">Volver</button>
    </form>
<?php include('../footer.php'); ?>
</html>