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

  if($_SESSION['recover']){
    header('location: /recover');
  }

  if($_SESSION['token']){
    $result = mysqli_query($conn, "SELECT token FROM ".$table." WHERE username='".$_SESSION['username']."'");
    if(mysqli_num_rows($result) == 1) {
      $fetch = mysqli_fetch_array($result);
      if($fetch['token'] !== "VERIFIED"){
        if($_SESSION['token'] !== "VERIFIED"){
          $error = $need_verification;
          // echo $_SESSION['token'];
        }else{
          header('location: /login');
        }
      }
    }
  }
  if($_SESSION['token']){
    if($_SESSION['token'] !== "VERIFIED"){
      $error = $need_verification;
      // echo $_SESSION['token'];
    }else{
      header('location: /login');
    }
  }

  if(isset($_POST['register'])){

    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);
    $vpass = mysqli_real_escape_string($conn, $_POST['vpass']);

    $user_hash = strtolower($user);

    $email = strtolower($email);

    $v_user = mysqli_query($conn, "SELECT * FROM ".$table." WHERE username='".$user_hash."'");

    $v_email = mysqli_query($conn, "SELECT * FROM ".$table." WHERE email='".$email."'");


    if($user == ""){
      $error = $please_nick;
    }else if($email == ""){
      $error = $please_email;
    }else if($pass == ""){
      $error = $please_pass;
    }else if($vpass == ""){
      $error = $please_vpass;
    }else if($pass !== $vpass){
      $error = $pass_no_match;
    }else if(strlen($pass) < 8){
      $error = $pass_lenght;
    }else if(mysqli_num_rows($v_user) == 1) {
      $error = $alredy_user;
    }else if(mysqli_num_rows($v_email) == 1) {
      $error = $alredy_email;
    }else{
      $options = [
        'cost' => 10,
      ]; 
      $pass_hash = password_hash($pass, PASSWORD_BCRYPT, $options);

      $token = random_int(100000, 999999);

      $sql = "INSERT INTO ".$table." (username, realname, password, email, token)
      VALUES ('".$user_hash."', '".$user."', '".$pass_hash."', '".$email."', '".$token."')";

      if ($conn->query($sql) === TRUE) {
        // Se registro correctamente!
        session_start();
        $_SESSION['username'] = $user_hash;
        $_SESSION['realname'] = $user;
        $_SESSION['password'] = $pass_hash;
        $_SESSION['email'] = $email;
        $_SESSION['token'] = $token;
        $_SESSION['online'] = 0;

        // echo $_SESSION['token'];

        $to = $email;
        $subject = "Codigo de Verificacion";
        
        $message = "<h1>Tu codigo es:</h1>";
        $message .= "<h1>".$token."</h1>";
        
        $header = "From:".$companymail." \r\n";
        // $header .= "Cc:afgh@somedomain.com \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";
        
        $retval = mail ($to,$subject,$message,$header);
        
        if( $retval == false ) {
          // El email no se pudo enviar, asi que omitimos este paso...
          $sql = "UPDATE ".$table." SET token='VERIFIED' WHERE username='".$_SESSION['username']."'";
          if ($conn->query($sql) === TRUE) {
            $_SESSION['token'] = "VERIFIED";
            header('location: /login');
          }
        }
      } else {
        $error = $registration_problem;
      }
    }
    
  }

  if(isset($_POST['token'])){
    if($_POST['code'] == ""){
      $error = $token_empty;
    }else if($_POST['code'] == $_SESSION['token']){
      $_SESSION['token'] = "VERIFIED";
      $sql = "UPDATE ".$table." SET token='VERIFIED' WHERE username='".$_SESSION['username']."'";
      if ($conn->query($sql) === FALSE) {
        $_SESSION['token'] = $_POST['code'];
        $error = $try_again;
      }else{
        $_SESSION['token'] = "VERIFIED";
        header('location: /login');
      }
    }else{
      $error = $code_no_match;
    }
  }
?>