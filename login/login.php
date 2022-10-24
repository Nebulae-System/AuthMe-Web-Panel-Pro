<?php
  //INICIAMOS LA SESION
  session_start();
  
  // OCULTAMOS LOS WARNING
  error_reporting(E_ERROR | E_PARSE);
  
  // INCLUIMOS LAS OPCIONES
  include('../config.php');
  
  // CREAMOS LA CONEXION
  $conn = new mysqli($ip, $user, $pass, $db);

  if($_SESSION['recover']){
    header('location: /recover');
  }
  
  if($_SESSION['vkey']){
    $result = mysqli_query($conn, "SELECT vkey FROM authme WHERE username='".$_SESSION['username']."'");
    if(mysqli_num_rows($result) == 1) {
      $fetch = mysqli_fetch_array($result);
      if($fetch['vkey'] !== "VERIFY"){
        $_SESSION['vkey'] = $fetch['vkey'];
        header('location: /register');
      }
    }
  }

  if(isset($_SESSION['username'])){
    $result = mysqli_query($conn, "SELECT * FROM Players WHERE Nick='".$_SESSION['username']."'");
    if(mysqli_num_rows($result) == 1) {
      $fetch = mysqli_fetch_array($result);
      // Tiene una skin que no es su nombre
      $_SESSION['skin'] = getskin($fetch['Skin']);
    }else{
      $_SESSION['skin'] = getskin($_SESSION['realname']);
    }
    $logged = mysqli_query($conn, "SELECT isLogged FROM authme WHERE username='".$_SESSION['username']."'");
    $fetch = mysqli_fetch_array($logged);
    $_SESSION['online'] = $fetch['isLogged'];
  }

  if(isset($_POST['edit'])) {
    $_SESSION['edit'] = TRUE;
    $_SESSION['find-skin'] = $_SESSION['skin'];
  }
  if(isset($_POST['edit-back'])) {
    unset($_SESSION['edit']);
    unset($_SESSION['find-skin']);
  }

  if(isset($_POST['search-skin'])){
    $skin = getskin($_POST['skin-name']);
    if($skin == '../src/images/unknown.png'){
      $error = $incorrect_player;
    }else{
      $_SESSION['skin'] = $skin;
      // $_SESSION['skin_name'] = $_POST['skin-name'];
      $result = mysqli_query($conn, "SELECT * FROM Players WHERE Nick='".$_SESSION['username']."'");
      if(mysqli_num_rows($result) == 1) {
        $sql = mysqli_query($conn, "UPDATE Players SET Skin='".$_POST['skin-name']."' WHERE Nick='".$_SESSION['username']."'");
      }else{
        $sql = mysqli_query($conn, "INSERT INTO Players (Nick, Skin) VALUES ('".$_SESSION['username']."', '".$_POST['skin-name']."')");
      }
    }
  }
  if(isset($_POST['reset-skin'])){
    
    $_SESSION['skin'] = getskin($_SESSION['username']);
    $result = mysqli_query($conn, "SELECT * FROM Players WHERE Nick='".$_SESSION['username']."'");
    if(mysqli_num_rows($result) == 1) {
      $sql = mysqli_query($conn, "DELETE FROM Players WHERE Nick='".$_SESSION['username']."';");
    }
  }
  if(isset($_POST['save-skin'])){
    $result = mysqli_query($conn, "SELECT * FROM Players WHERE Nick='".$_SESSION['username']."'");
    if(mysqli_num_rows($result) == 1) {
      $sql = mysqli_query($conn, "UPDATE Players SET Skin='".$_SESSION['skin_name']."' WHERE Nick='".$_SESSION['username']."'");
    }else{
      $sql = mysqli_query($conn, "INSERT INTO Players (Nick, Skin) VALUES ('".$_SESSION['skin_name']."', '".$_SESSION['username']."'");
    }
  }

  if(isset($_POST['login'])) {
    
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);

    $user = strtolower($user);

    $result = mysqli_query($conn, "SELECT * FROM authme WHERE username='".$user."'");
    if(mysqli_num_rows($result) == 1) {
      $fetch = mysqli_fetch_array($result);
      if (password_verify($pass, $fetch['password'])) {
        $_SESSION['username'] = $fetch['username'];
        $_SESSION['realname'] = $fetch['realname'];
        $_SESSION['password'] = $fetch['password'];
        $_SESSION['email'] = $fetch['email'];
        $_SESSION['vkey'] = $fetch['vkey'];
        //$_SESSION['ip'] = $fetch['ip'];
        $_SESSION['online'] = $fetch['isLogged'];

        if($_SESSION['vkey'] !== "VERIFY"){
          header('location: /register');
        }
        
        $result = mysqli_query($conn, "SELECT * FROM Players WHERE Nick='".$_SESSION['username']."'");
        if(mysqli_num_rows($result) == 1) {
          $fetch = mysqli_fetch_array($result);
          // Tiene una skin que no es su nombre
          $_SESSION['skin'] = getskin($fetch['Skin']);
          $_SESSION['skin_name'] = $fetch['Skin'];
        }else{
          $_SESSION['skin'] = getskin($_SESSION['realname']);
          $_SESSION['skin_name'] = $_SESSION['realname'];
        }
      } else {
        $error = $incorrect_pass;
      }
    } else {
      $error = $incorrect_user;
    }
    // $conn->close();
  }

  if(isset($_POST['logout'])){
		unset($_SESSION['realname']);
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['email']);
    unset($_SESSION['skin']);
    unset($_SESSION['vkey']);
    session_destroy();
    // header('location: /login');
  }

  function getskin($nickname){
    $apiurl = file_get_contents("https://api.minetools.eu/uuid/$nickname");
    $api = json_decode($apiurl,true);
    if($api['id'] == ""){
      $uuid = '../src/images/unknown.png';
    }else{
      $uuid = 'https://crafatar.com/renders/body/'.$api['id'].'?scale=10&overlay';
    }
    return $uuid;
  }

  function getbase64(){
    $img = file_get_contents($_SESSION['skin']);
    $skin_base64 = base64_encode($img);
    return $skin_base64;
  }
  
?>