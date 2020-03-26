<?php

// Connexion à la bdd
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

// Lancement de la session
	session_start();
	var_dump($_SESSION['authentification']);

	//	Si l'utilisateur n'est pas authentifié
	if(!array_key_exists('userid', $_SESSION))
	{
		//	Redirection vers la page d'accueil
		header('Location: ./');
		exit;
	}


// requête qui récupère le username du membre connecté
	$query = 'SELECT username FROM writers WHERE id= :iduser';
	$sth = $dbh->prepare($query);
	$sth->bindValue(':iduser', trim($_SESSION['authentification']), PDO::PARAM_STR);
	$sth->execute();
	$usernameSession = $sth->fetch();

	var_dump($usernameSession);

// requête qui récupère les articles déjà publiés
	$query = 'SELECT title, publication_date FROM posts WHERE writerid= :writerid';
	$sth = $dbh->prepare($query);
	$sth->bindValue(':writerid', $_SESSION['authentification'], PDO::PARAM_STR);
	$sth->execute();
	$publishedArticles = $sth->fetch();

//Pour publication nouvel article

	$query = 'INSERT INTO posts (title, content, writerid, image) VALUES (:title, :content, :writerid, :image)';
	$sth = $dbh->prepare($query);
	$sth->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
	$sth->bindValue(':content', $_POST['content'], PDO::PARAM_STR);
	$sth->bindValue(':writerid', $_SESSION['authentification'], PDO::PARAM_STR);
	$sth->bindValue(':image', 'null', PDO::PARAM_STR);
	$sth->execute();

	var_dump($publishedArticles);
	var_dump($_POST);
	include 'dashboard.phtml';
