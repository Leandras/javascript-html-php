<?php

  include_once('data.php');
  include_once('sessions/session_login.php');
  include_once('consts.php');

  $scores = adat_betoltes($SCORES);

  $idn;
  $width;
  $height;
  $obstacles;
  $objects;

  $hibak = array();

  if($_POST){
  	$idn = $_POST['idn'];
  	$width = $_POST['width'];
  	$height = $_POST['height'];
  	$objects = $_POST['objects'];

  	if($idn == ''){
  		$hibak[] = "Nem adta meg a pálya nevét!";
  	}
  	if($width == ''){
  	  $hibak[] = "Nem adott meg szélességet!";
  	}else if(!is_numeric($width)){
  	  $hibak[] = "Meglepő módon, a szélesség csak szám lehet.";
  	}else if($width < 100){
  	  $hibak[] = "A pálya szélessége minimum 100 legyen!";
  	}else if($width > 800){
  	  $hibak[] = "A pálya szélessége maxumum 800 lehet!";
  	}
  	if($height == ''){
  	  $hibak[] = "Nem adott meg magasságot!";
  	}else if(!is_numeric($height)){
  	  $hibak[] = "Meglepő módon, a magasság csak szám lehet.";
  	}else if($height < 100){
  	  $hibak[] = "A pálya magassága minimum 100 legyen!";
  	}else if($height > 800){
  	  $hibak[] = "A pálya magassága maxumum 800 lehet!";
  	}
  	if($objects == ""){
  	  $hibak[] = "Nem adta meg az objektumok számát!";
  	}else if(!is_numeric($objects)){
  	  $hibak[] = "Meglepő módon, az objektumok SZÁMA csak szám lehet.";
  	}else if($objects < 1){
  	  $hibak[] = "Az objektumok száma legalább egy darab kell hogy legyen!";
  	}else if($objects > 6){
  	  $hibak[] = "Az objektumok száma maximum hat lehet";
  	}

  	if(!$hibak){
  	 if(isset($_POST['obstacles'])){
  	 	$obstacles = "Igen";
  	 }else{
  	 	$obstacles = "Nem";
  	 }
  	 $scores[$idn] = array(
  	   'width' => $width,
  	   'height' => $height,
  	   'objects' => $objects,
  	   'obstacle' => $obstacles,
  	   'name' => '',
  	   'score' => ''

  	 );
  	 adat_mentes($SCORES, $scores);
  	}

  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Üdv <?= $_SESSION['username']; ?></title>
</head>
<body>
  <?php if($hibak) : ?>
  	<ul>
      <?php foreach($hibak as $hiba) : ?>
      	<li><?= $hiba; ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <h1>Új pálya felvétele</h1>
  <form method="post">
  	<table>
  	  <tr>
  	  	<td>A pálya neve:</td>
  	  	<td><input type="text" name="idn"></td>
  	  </tr>
  	  <tr>
  	  	  <td>A pálya szélessége:</td>
  	  	  <td><input type="text" name="width"></td></br>
  	  </tr>
  	  <tr>
  	  	  <td>A pálya magassága:</td>
  	  	  <td><input type="text" name="height"></td></br>
  	  </tr>
  	  <tr>
  	  	  <td>Objektumok száma:</td>
  	  	  <td><input type="text" name="objects"></td></br>
  	  </tr>
  	  <tr>
  	  	  <td>Akadályok bekapcsolása:</td>
  	  	  <td><input type="radio" name="obstacles"></td>
  	  </tr>
  	  <tr>
  	  	  <td><input type="submit" value="Elküldés" /></td>
  	  </tr>
  	</table>
  </form>
  <p><a href="../index.php">Vissza</p>
</body>
</html>