<?php
  include_once('sessions/session_login.php');
  setUser();
  //$_SESSION['loggedIn'] = false;
  header('Location: ../index.php');
  exit();
?>