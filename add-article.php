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


if(!empty($_POST)) {
	$query = 'INSERT INTO posts (title, content, writerid, image) VALUES (:title, :content, :writerid, :image)';
	$sth = $dbh->prepare($query);
	$sth->bindValue(':title', htmlspecialchars($_POST['title']), PDO::PARAM_STR);
	$sth->bindValue(':content', htmlspecialchars($_POST['content']), PDO::PARAM_STR);
	$sth->bindValue(':writerid', $_SESSION['userid'], PDO::PARAM_STR);
	$sth->bindValue(':image', $urlImage, PDO::PARAM_STR);
	$sth->execute();
}

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