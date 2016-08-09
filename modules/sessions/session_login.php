<?php

  if(!isset($_SESSION)){
  	session_start();
  }

  function setUser($username = null){
  	if($username){
  		$_SESSION['username'] = $username;
  	}else{
  		unset($_SESSION['username']);
  	}
  }

  function loggedIn(){
  	return isset($_SESSION['username']);
  }
  
?>