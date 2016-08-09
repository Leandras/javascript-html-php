<?php
  include_once('sessions/session_map.php');
  
  setParameters();
  $_SESSION['mapChoosen'] = false;
  header('Location: ../game/index.php');
  exit();
?>