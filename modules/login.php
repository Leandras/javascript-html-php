<?php

  include_once('sessions/session_login.php');
  include_once('data.php');
  include_once('consts.php');

  $hibak = array();
  $users = adat_betoltes('data/users.json');
  if($_POST){
    $email = trim($_POST['email']);
  	$password = $_POST['password'];


  	if($email == ''){
  	  $hibak[] = 'Nincs megadva az email cím!';
  	}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $hibak[] = 'Hibásan megadott email cím!';
    }
  	if($password == ''){
  	  $hibak[] = 'Nincs megadva jelszó!';
  	}
    if($users != null){
  	  if(!array_key_exists($email, $users)){
  	    $hibak[] = 'Nincs ilyen felhasználó!';
  	  }else{
  	    if(md5($password) != $users[$email]['password']){
  	  	  $hibak[] = 'Hibás jelszó!';
  	   }
  	 }
    }else{
      $hibak[] = "Nincs egy felhasználó sem!";
    }

  	if(!$hibak){
  		$_SESSION['loggedIn'] = true;
      $_SESSION['usern'] = $users[$email]['usern'];
  		setUser($users[$email]['usern']);
  		header('Location: leaderboards.php');
  		exit();
  	}
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
</head>
<body>
 <ul>
    
	<?php foreach ($hibak as $hiba) : ?>
	  <li><?= $hiba; ?></li>
	<?php endforeach; ?>
	
  </ul>
  <h1>Bejelentkezés</h1>
  <form action="" method="post">
			<table >
				<tr>
					<td>Email cím:</td>
					<td><input type="text" name="email"></td>
				</tr>
				<tr>
					<td>Jelszó:</td>
					<td><input type="password" name="password"></td>
				<tr>
				<tr>
					<td colspan = 2><input type="submit" value="Bejelentkezés"></td>
				</tr>
			</table>
		</form>
		<p><a href="../index.php">Vissza
</body>
</html>