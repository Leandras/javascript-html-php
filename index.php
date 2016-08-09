<?php
  include_once('modules/sessions/session_login.php');
?>

<!DOCTYPE html>
<html>
<head>
  <?php if(loggedIn()) : ?>
    <title>Üdv <?=$_SESSION['username'];?></title>
  <?php endif; ?>
  <meta charset="utf-8">
  <img src="src/logo.png" alt="snake_logo" height="80" width="80">
</head>
<body>
  <p>Az ősi Kínában – a feljegyzések legalábbis erre utalnak – jóval az időszámításunk előtt volt egy furcsa megmérettetés: kínai vitézek rátermettségüket azzal bizonyították, hogy minél tovább próbálták megülni Chai-Si hegyvidék varázslatos sárkányát. A legjobb vitéz lett az év sárkányharcosa.
  <br>
  <br>
  A szerencsét próbáló vitézek egy arénánál gyülekeztek. Egyesével ültek fel az aréna bejáratánál a sárkány hátára, majd a sárkányt beengedték az arénába. A cél az volt, hogy a sárkánnyal minél több tekercset gyűjtsön be a vitéz. Egyszerre egy tekercset dobtak az aréna véletlenszerű helyére. Ha a sárkány felvette a tekercset, akkor annak hatására bölcsebb és nagyobb lett. Voltak azonban olyan tekercsek, amelyek egyéb varázslatot tartalmaztak. Az arénában ezek mellett lehettek tereptárgyak is.
  <br>
  <br>
  A játékban Te a fiatal és ügyes vitézt, Teng Lenget alakítod. Segíts neki sárkányharcossá válni!</p>
  <?php if(loggedIn()) : ?>
      <p><a href="modules/logout.php">Kijelentkezés</p>
      <p><a href="modules/quitmap.php">Játék</p>
      <p><a href="modules/leaderboards.php">Pályák</p>
      <?php if($_SESSION['username'] == 'admin') : ?>
        <p><a href="modules/adminsite.php">Pálya hozzáadása</p>
      <?php endif; ?>
  <?php else : ?>
  	  <p><a href="modules/login.php">Bejelntkezés</p>
  	  <a href="modules/register.php">A regisztrációhoz kattints ide.
      <p><a href="modules/quitmap.php">Játék</p>
  <?php endif; ?>
</body>
</html>	