<?php


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


if(!empty($_SESSION)){
// requête qui récupère le username du membre connecté
$query = 'SELECT username FROM writers WHERE id= :iduser';
$sth = $dbh->prepare($query);
$sth->bindValue(':iduser', trim($_SESSION['userid']), PDO::PARAM_STR);
$sth->execute();
$usernameSession = $sth->fetch();
}

$query = 'SELECT posts.id AS postid, posts.title, posts.image, posts.content, posts.publication_date, posts.writerid, writers.id, writers.username FROM posts INNER JOIN writers ON writers.id = posts.writerid ORDER BY posts.publication_date DESC';
$sth = $dbh->prepare($query);
$sth->execute();
$allArticles = $sth->fetchAll();
include 'index.phtml';
