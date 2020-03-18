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

	//	Si l'utilisateur n'est pas authentifié
	if(!array_key_exists('authentification', $_SESSION))
	{
		//	Redirection vers la page d'accueil
		header('Location: ./');
		exit;
	}



	
	$query = 'SELECT id, username, hashed_password FROM writers WHERE username = :email';
	$sth = $dbh->prepare($query);
	$sth->bindValue(':email', trim($_POST['username']), PDO::PARAM_STR);
	$sth->execute();
	$user = $sth->fetch();

	var_dump($user);

	// Je ne me souviens plus comment on récupère les infos de l'utilisateur dont la session est active. Var_dump renvoie 'false'.

	include 'dashboard.phtml';