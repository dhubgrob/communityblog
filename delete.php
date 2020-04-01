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

// suppression d'article

array_flip($_GET);

if (array_key_exists('id', $_GET) and intval($_GET['id']) > 0) {

	$query = 'DELETE FROM POSTS WHERE id = ?';
	$sth = $dbh->prepare($query);
	$sth->bindValue(1, $_GET['id'], PDO::PARAM_INT);
	$sth->execute();

	header('Location: http://localhost/projets/community_blog/dashboard.php');
	exit;
}
