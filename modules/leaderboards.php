<?php
  include_once('data.php');
  include_once('consts.php');
  include_once('sessions/session_login.php');
  include_once('sessions/session_map.php');

  $scores = adat_betoltes($SCORES);
  $users_scores = adat_betoltes($USERS_SCORES);
  $numbers = array();
  $width;
  $height;
  $obstacle;
  $objects;
  $score;
  $uzik = array();
  $talal = false;

  if(isset($_POST['play'])){
   // header('Location : ../index.php');
    $index = $_POST['play'];
    $width =  $scores[$index]['width'];
    $height = $scores[$index]['height'];
    $obstacle = $scores[$index]['obstacle'];
    $objects = $scores[$index]['objects'];
    $score = $scores[$index]['score'];

    if($scores[$index]['obstacle'] == "Igen"){
      $_SESSION['setUpObstacles'] = true;
    }else{
      $_SESSION['setUpObstacles'] = false;
    }
    //$_SESSION['width'] = $width;
    //$_SESSION['height'] = $height;
    //$_SESSION['obstacle'] = $obstacle;
    setParameters($width, $height, $objects, $obstacle, $index);
    $_SESSION['score'] = $score;
    $_SESSION['mapChoosen'] = true;
    header('Location: ../game/index.php');
    exit();
  }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <?php if(loggedIn()) : ?>
    <title>Üdv <?=$_SESSION['username'];?></title>
  <?php endif; ?>
</head>
<body>
  <?php foreach($uzik as $uzi) : ?>
    <p><?= $uzi; ?></p>
  <?php endforeach; ?>
  <h1>Ranglista</h1>
  <form action="" method="post">
  <table border="2px">
      <tr>
        <td>Pálya</td>
      	<td>Vízszintes méret</td>
      	<td>Függőleges méret</td>
        <td>Objektumok száma</td>
      	<td>Akadályok</td>
      	<td>A rekord tartója</td>
        <td>Rekord</td>
        <td>A te pontszámod</td>
        <td>Játék</td>
      </tr>
    <?php if($scores != null) : ?>
  	<?php foreach($scores as $key=>$value) : ?>
  	  <tr>
        <td><?= $key ?></td>
        <td><?= $value['width'] ?></td>
        <td><?= $value['height'] ?></td>
        <td><?= $value['objects'] ?></td>
        <td><?= $value['obstacle'] ?></td>
        <td><?= $value['name'] ?></td>
        <td><?= $value['score'] ?></td>
        <?php $talal = false; ?>
        <?php if($users_scores != null) : ?>
          <?php foreach($users_scores as $sck => $scv) : ?>
            <?php if($key == $scv['level_id'] && $scv['user'] == $_SESSION['username']) : ?>
              <?php $talal = true; ?>
              <td><?= $scv['score']; ?></td>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endif; ?>
        <?php if(!$talal) : ?>
          <td>0</td>
        <?php endif; ?>
        <td colspan = 2><input type="submit" name="play" value="<?=$key; ?>" /></td>
  	  </tr>
  	<?php endforeach; ?>
    <?php endif; ?>
  </table>
  <p><a href="../index.php">Vissza a kezdőlapra</p>
  </form>
</body>
</html>