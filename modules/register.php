<?php
  include_once('data.php');
  include_once('consts.php');
  include_once('sessions/session_login.php');

  $hibak = array();
  $username = '';
  $pass = '';
  $passagain = '';
  $email = '';


  if ($_POST) {
    $username = trim($_POST['username']);
	$pass = $_POST['pass'];
	$passagain = $_POST['passagain'];
	$email = $_POST['email'];

	$users = adat_betoltes($USERS);

	if($username == ''){
		$hibak[] = 'Nincs megadva a felhasználói név!';
	}
	if($users && array_key_exists($username, $users)){
		$hibak[] = 'Ilyen felhasdználó név már létezik!';
	}
	if($pass == ''){
		$hibak[] = 'Nincs megadva jelszó!';
	}else if($passagain == ''){
		$hibak[] = 'Nincs megadva az ellenörző jelszó!';
	}else if($pass != $passagain){
		$hibak[] = 'Nem egyezik a két jelszó!';
	}
	if($email == ''){
		$hibak[] = 'Nincs megadva email cím!';
	}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$hibak[] = 'Hibásan megadott email cím!';
	}

	if(!$hibak){
	  
	  $users[$email] = array(
	  	'usern' => $username,
	  	'password' => md5($pass),
	  );
	  adat_mentes($USERS, $users);
	  header('Location: ../index.php');
	  exit();
	}
  }

?>

<!DOCTYPE html>
<html>
<head>
	<charset meta="utf-8">
</head>
<body>
    <ul>
    
	  <?php foreach ($hibak as $hiba) : ?>
		<li><?= $hiba; ?></li>
	  <?php endforeach; ?>
	
	</ul>
	<h1>Regisztácoió</h1>
	<form action="" method="post">
			<table >
				<tr>
					<td>Felhasználónév:</td>
					<td><input type="text" name="username"></td>
				</tr>
				<tr>
					<td>Email cím:</td>
					<td><input type="text" name="email"></td>
				</tr>
				<tr>
					<td>Jelszó:</td>
					<td><input type="password" name="pass"></td>
				<tr>
				<tr>
					<td>Jelszó még egyszer:</td>
					<td><input type="password" name="passagain"></td>
				</tr>
				<tr>
					<td colspan = 2><input type="submit" value="Regisztráció"></td>
				</tr>
			</table>
			<p><a href="../index.php">Vissza</p>
		</form>
</body>
</html>