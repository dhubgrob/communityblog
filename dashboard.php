<?php

// Connexion à la bdd
$dbh = new PDO(
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

//	Si l'utilisateur n'est pas authentifié
if (!array_key_exists('userid', $_SESSION)) {
	//	Redirection vers la page d'accueil
	header('Location: ./');
	exit;
}



if(!empty($_SESSION)){
// requête qui récupère le username du membre connecté
$query = 'SELECT username FROM writers WHERE id= :iduser';
$sth = $dbh->prepare($query);
$sth->bindValue(':iduser', trim($_SESSION['userid']), PDO::PARAM_STR);
$sth->execute();
$usernameSession = $sth->fetch();
}

// requête qui récupère les articles déjà publiés
$query = 'SELECT title, publication_date, id FROM posts WHERE writerid= :writerid';
$sth = $dbh->prepare($query);
$sth->bindValue(':writerid', $_SESSION['userid'], PDO::PARAM_STR);
$sth->execute();
$publishedArticles = $sth->fetchAll();






include 'dashboard.phtml';
