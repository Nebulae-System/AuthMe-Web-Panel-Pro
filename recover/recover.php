<?php
  //INICIAMOS LA SESION
  session_start();
  
  // OCULTAMOS LOS WARNING
  error_reporting(E_ERROR | E_PARSE);
  
  // INCLUIMOS LAS OPCIONES
  include('../config.php');
  
  // CREAMOS LA CONEXION
  $conn = new mysqli($ip, $user, $pass, $db);

  if($_SESSION['password']){
    header('location: /login');
  }

  if($_SESSION['vkey']){
    if($_SESSION['recover'] !== TRUE){
      header('location: /register');
    }
  }

  if(isset($_POST['change'])){
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    if($pass1 == ""){
      $error = $please_pass;
    }else if($pass2 == ""){
      $error = $please_vpass;
    }else if($pass1 !== $pass2){
      $error = $pass_no_match;
    }else if(strlen($pass1) < 8){
      $error = $pass_lenght;
    }else{
      
      $options = [
        'cost' => 10,
      ]; 
      $pass_hash = password_hash($pass1, PASSWORD_BCRYPT, $options);

      $sql = "UPDATE authme SET password='".$pass_hash."' WHERE email='".$_SESSION['email']."'";
      $_SESSION['password'] = $pass_hash;
      unset($_SESSION['recover']);

      if ($conn->query($sql) === FALSE) {
        // Verifico identidad correctamente!
        $_SESSION['recover'] = TRUE;
        header('location: /recover');
      }
    }
  }

  if(isset($_POST['verificar'])){
    if($_POST['code'] == ""){
      $error = $vkey_empty;
    }else if($_POST['code'] == $_SESSION['vkey']){
      unset($_SESSION['vkey']);
      $sql = "UPDATE authme SET vkey='VERIFY' WHERE email='".$_SESSION['email']."'";
      if ($conn->query($sql) === FALSE) {
        $_SESSION['vkey'] = $_POST['code'];
        $error = $try_again;
      }else{
        unset($_SESSION['vkey']);
        header('location: /login');
      }
    }else{
      $error = $code_no_match;
    }
  }

  if(isset($_POST['enviar'])){
    if($_POST['email'] == ""){
      $error = $please_email;
    }else{
      $email = $_POST['email'];
      $result = mysqli_query($conn, "SELECT * FROM authme WHERE email='".$email."'");
      if(mysqli_num_rows($result) == 1) {
        $fetch = mysqli_fetch_array($result);
  
        $vkey = random_int(100000, 999999);
  
        $to = $email;
        $subject = "Codigo de Verificacion";
        
        $message = "<h1>Tu codigo es:</h1>";
        $message .= "<h1>".$vkey."</h1>";
        
        $header = "From:".$companymail." \r\n";
        // $header .= "Cc:afgh@somedomain.com \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";
        
        $retval = mail ($to,$subject,$message,$header);

        if( $retval == false ) {
          // El email no se pudo enviar, asi que omitimos este paso...
          $error = $smtp_error;
        }else{
          // Crear UPDATE
          $sql = "UPDATE authme SET vkey='".$vkey."' WHERE email='".$email."'";

          if ($conn->query($sql) === FALSE) {
            $error = $try_again;
          }else{
            $_SESSION['username'] = $fetch['username'];
            $_SESSION['realname'] = $fetch['realname'];
            $_SESSION['email'] = $fetch['email'];
            $_SESSION['vkey'] = $vkey;
            $_SESSION['recover'] = TRUE;
          }
        }
      }else{
        $error = $incorrect_user;
      }
    }
  }
?>