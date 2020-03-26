<?php

$dbh = new PDO
(
	'mysql:host=localhost;dbname=communityblog;charset=utf8',
	'root',
	'',
	[
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	]
);

	session_start();
	var_dump($_SESSION['authentification']);

	//	Si l'utilisateur n'est pas authentifié
	if(!array_key_exists('userid', $_SESSION))
	{
		//	Redirection vers la page d'accueil
		header('Location: ./');
		exit;
	}



	

	$query = 'SELECT username FROM writers WHERE id= :iduser';
	$sth = $dbh->prepare($query);
	$sth->bindValue(':iduser', trim($_SESSION['authentification']), PDO::PARAM_STR);
	$sth->execute();
	$usernameSession = $sth->fetch();

	var_dump($usernameSession);

	include 'dashboard.phtml';
