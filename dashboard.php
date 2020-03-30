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
	$sth->bindValue(':iduser', trim($_SESSION['userid']), PDO::PARAM_STR);
	$sth->execute();
	$usernameSession = $sth->fetch();

// requête qui récupère les articles déjà publiés
	$query = 'SELECT title, publication_date, id FROM posts WHERE writerid= :writerid';
	$sth = $dbh->prepare($query);
	$sth->bindValue(':writerid', $_SESSION['userid'], PDO::PARAM_STR);
	$sth->execute();
	$publishedArticles = $sth->fetchAll();

// gestion des upload d'images
	if(array_key_exists('monFichier', $_FILES))
	{
		if($_FILES['monFichier']['error'] == 0)
		{
			if(in_array(mime_content_type($_FILES['monFichier']['tmp_name']), ['image/png', 'image/jpeg']))
			{
				if($_FILES['monFichier']['size'] <= 3000000)
				{
					$urlImage = uniqid() . "." . pathinfo($_FILES['monFichier']['name'], PATHINFO_EXTENSION);
					move_uploaded_file($_FILES['monFichier']['tmp_name'], 'uploads/' . $urlImage);
				}
				else
				{
					echo 'Le fichier est trop volumineux…';
				}
			}
			else
			{
				echo 'Le type mime du fichier est incorrect…';
			}
		}
		else
		{
			echo 'Le fichier n\'a pas pu être récupéré…';
		}
	}

//Pour publication nouvel article
if(!empty($_POST)) {
	$query = 'INSERT INTO posts (title, content, writerid, image) VALUES (:title, :content, :writerid, :image)';
	$sth = $dbh->prepare($query);
	$sth->bindValue(':title', htmlspecialchars($_POST['title']), PDO::PARAM_STR);
	$sth->bindValue(':content', htmlspecialchars($_POST['content']), PDO::PARAM_STR);
	$sth->bindValue(':writerid', $_SESSION['userid'], PDO::PARAM_STR);
	$sth->bindValue(':image', $urlImage, PDO::PARAM_STR);
	$sth->execute();
}



	include 'dashboard.phtml';
