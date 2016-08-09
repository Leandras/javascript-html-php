<?php
  if(!isset($_SESSION)){
  	start_session();
  }

  function getScore(){
  	if(isset($_SESSION['score'])){
  		return $_SESSION['score'];
  	}else{
  		return array();
  	}
  }

  function setScore($score){
  	$_SESSION['score'] = $score;
  }
?>