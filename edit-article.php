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

var_dump($_GET);

if(array_key_exists("idedit", $_GET)) {

    $query = 'SELECT * FROM posts WHERE id = ?';
    $sth = $dbh->prepare($query);
    $sth -> bindValue(1, $_GET['idedit'], PDO::PARAM_INT);
    $sth->execute();
    $articleEdition = $sth->fetch();

    var_dump($articleEdition);


if(!empty($_POST)) {

// suppression de l'ancien article

$query = 'DELETE FROM POSTS WHERE id = ?';
$sth = $dbh->prepare($query);
$sth -> bindValue(1, $_POST['idedit'], PDO::PARAM_INT);
$sth->execute();


// ajout nouvel article

    $query = 'INSERT INTO posts (title, content, writerid, image) VALUES (:title, :content, :writerid, :image)';
	$sth = $dbh->prepare($query);
	$sth->bindValue(':title', $_POST['newTitle'], PDO::PARAM_STR);
	$sth->bindValue(':content', $_POST['newContent'], PDO::PARAM_STR);
	$sth->bindValue(':writerid', $_SESSION['userid'], PDO::PARAM_STR);
	$sth->bindValue(':image', 'null', PDO::PARAM_STR);
    $sth->execute();


    

}
include 'edit-article.phtml';
}


