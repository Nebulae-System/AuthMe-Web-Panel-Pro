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

  if($_SESSION['vkey']){
    $result = mysqli_query($conn, "SELECT vkey FROM authme WHERE username='".$_SESSION['username']."'");
    if(mysqli_num_rows($result) == 1) {
      $fetch = mysqli_fetch_array($result);
      if($fetch['vkey'] !== "VERIFY"){
        if($_SESSION['vkey'] !== "VERIFY"){
          $error = $need_verification;
          // echo $_SESSION['vkey'];
        }else{
          header('location: /login');
        }
      }
    }
  }
  if($_SESSION['vkey']){
    if($_SESSION['vkey'] !== "VERIFY"){
      $error = $need_verification;
      // echo $_SESSION['vkey'];
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

    $v_user = mysqli_query($conn, "SELECT * FROM authme WHERE username='".$user_hash."'");

    $v_email = mysqli_query($conn, "SELECT * FROM authme WHERE email='".$email."'");


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

      $vkey = random_int(100000, 999999);

      $sql = "INSERT INTO authme (username, realname, password, email, vkey)
      VALUES ('".$user_hash."', '".$user."', '".$pass_hash."', '".$email."', '".$vkey."')";

      if ($conn->query($sql) === TRUE) {
        // Se registro correctamente!
        session_start();
        $_SESSION['username'] = $user_hash;
        $_SESSION['realname'] = $user;
        $_SESSION['password'] = $pass_hash;
        $_SESSION['email'] = $email;
        $_SESSION['vkey'] = $vkey;
        $_SESSION['online'] = 0;

        // echo $_SESSION['vkey'];

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
          $sql = "UPDATE authme SET vkey='VERIFY' WHERE username='".$_SESSION['username']."'";
          if ($conn->query($sql) === TRUE) {
            $_SESSION['vkey'] = "VERIFY";
            sleep(1);
            header('location: /login');
          }
        }
      } else {
        $error = $registration_problem;
      }
    }
    
  }

  if(isset($_POST['vkey'])){
    if($_POST['code'] == ""){
      $error = $vkey_empty;
    }else if($_POST['code'] == $_SESSION['vkey']){
      $_SESSION['vkey'] = "VERIFY";
      $sql = "UPDATE authme SET vkey='VERIFY' WHERE username='".$_SESSION['username']."'";
      if ($conn->query($sql) === FALSE) {
        $_SESSION['vkey'] = $_POST['code'];
        $error = $try_again;
      }else{
        $_SESSION['vkey'] = "VERIFY";
        header('location: /login');
      }
    }else{
      $error = $code_no_match;
    }
  }
?>