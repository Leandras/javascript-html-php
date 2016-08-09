<?php
  if(!isset($_SESSION)){
  	session_start();
  }


  function setParameters($width = null, $height = null, $objects = null, $obstacle = null, $currentlevel = null){
  	if($width){
  		$_SESSION['width'] = $width;
  	}else{
  		unset($_SESSION['width']);
  	}
  	if($height){
  		$_SESSION['height'] = $height;
  	}else{
  		unset($_SESSION['height']);
  	}if($objects){
  		$_SESSION['objects'] = $objects;
  	}else{
  		unset($_SESSION['objects']);
  	}if($obstacle){
  		$_SESSION['obstacle'] = $obstacle;
  	}else{
  		unset($_SESSION['obstacle']);
  	}if($currentlevel){
      $_SESSION['currentlevel'] = $currentlevel;
    }else{
      unset($_SESSION['currentlevel']);
    }
  }

  function setUpObstacles(){
  	if(isset($_SESSION['obstacle'])){
  		if($_SESSION['obstacle'] == 'Igen'){
  			return true;
  		}else{
  			return false;
  		}
  	}else{
  		return false;
  	}
  }

  function mapChoosen(){
  		if(isset($_SESSION['width']) &&
  		   isset($_SESSION['height']) &&
  		   isset($_SESSION['objects']) 
  		   ){
  			return true;
  		}else{
  			return false;
  		}
  	}


?>