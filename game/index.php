<?php
  include_once('../modules/sessions/session_map.php');
  include_once('../modules/sessions/session_login.php');
  include_once('../modules/sessions/session_score.php');

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php if(loggedIn()) : ?>
          <title>Üdv <?= $_SESSION['username']; ?></title>
        <?php else : ?>
          <title>Üdv vendég</title>
        <?php endif; ?>
        <script type="text/javascript" src="js/snake.js"></script>
        <script type="text/javascript" src="../modules/ajax.js"></script>
    </head>
    <body>
      <form id="inputForm">
        Pálya Szélessége:
        <?php if(mapChoosen()) : ?>
          <input type="number" name="canvasWidth" id="canvasWidth" value="<?= $_SESSION['width']; ?>" min="400" max="1400" readonly>
        <?php else : ?>
          <input type="number" name="canvasWidth" id="canvasWidth" value="400" min="400" max="1400">
        <?php endif; ?>  
        
        Pálya Magassága:
        <?php if(mapChoosen()) : ?>
            <input type="number" name="canvasHeight" id="canvasHeight" value="<?= $_SESSION['height']; ?>" min="400" max="1400" readonly>
        <?php else : ?>
            <input type="number" name="canvasHeight" id="canvasHeight" value="400" min="400" max="1400">
        <?php endif; ?>
        
        Objektumok száma:
        <?php if(mapChoosen()) : ?>
            <input type="number" name="objectNumber" id="objectNumber" value="<?= $_SESSION['objects']; ?>" min="1" max="6" readonly>
        <?php else : ?>
            <input type="number" name="objectNumber" id="objectNumber" value="1" min="1" max="6">
        <?php endif; ?>
        <?php if(mapChoosen() && setUpObstacles()) : ?>
          <input type="radio" name="obsticles" id="obsticlesRadio" disabled checked> Tereptárgyak bekapcsolása
        <?php elseif(mapChoosen()) : ?>
          <input type="radio" name="obsticles" id="obsticlesRadio" disabled> Tereptárgyak bekapcsolása
        <?php else : ?>
          <input type="radio" name="obsticles" id="obsticlesRadio"> Tereptárgyak bekapcsolása
        <?php endif; ?>
        <input type="button" id="createCanvas" value="Készít" >
        <div id="fps"></div>
        <a href="../index.php">Vissza</a>
      </form>
      <p>Pontszám: <div id="pontszam"><br>
      <?php if(loggedIn() && mapChoosen()) : ?>
      <form>
        </div> <input type="submit" id="pontszamelkuld" name="score" value="Elküldés" onclick="sendScore()" ><br>
      </form>
      <?php endif; ?>
     
    </body>
</html>
