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


$query = 'SELECT posts.id AS postid, posts.title, posts.image, posts.content, posts.publication_date, posts.writerid, writers.id, writers.username FROM posts INNER JOIN writers ON writers.id = posts.writerid WHERE posts.id = :postid';
$sth = $dbh->prepare($query);
$sth->bindValue(':postid', trim($_GET['id']), PDO::PARAM_STR);
$sth->execute();
$theArticle = $sth->fetch();


include 'article.phtml';