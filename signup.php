<?php

include 'signup.phtml';

session_start();



if(!empty($_SESSION)){
// requête qui récupère le username du membre connecté
$query = 'SELECT username FROM writers WHERE id= :iduser';
$sth = $dbh->prepare($query);
$sth->bindValue(':iduser', trim($_SESSION['userid']), PDO::PARAM_STR);
$sth->execute();
$usernameSession = $sth->fetch();
}

if (!empty($_POST)) {

	$dbh = new PDO(
			'mysql:host=localhost;dbname=communityblog;charset=utf8',
			'root',
			'',
			[
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			]
		);

	session_start();

	$query = 'INSERT INTO writers (username, hashed_password) VALUES (:email, :passwordHash)';
	$sth = $dbh->prepare($query);
	$sth->bindValue(':email', htmlspecialchars(trim($_POST['username'])), PDO::PARAM_STR);
	$sth->bindValue(':passwordHash', password_hash(trim($_POST['password']), PASSWORD_BCRYPT), PDO::PARAM_STR);
	$sth->execute();



	header('Location:index.php');
	exit;
}
