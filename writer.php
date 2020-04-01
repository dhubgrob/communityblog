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

$query = 'SELECT id, username FROM writers WHERE id=:id';
$sth = $dbh->prepare($query);
$sth->bindValue(':id', trim($_GET['id']), PDO::PARAM_STR);
$sth->execute();
$basicInfo = $sth->fetch();

$query = 'SELECT posts.id AS postid, posts.title, posts.image, posts.content, posts.publication_date, posts.writerid, writers.id, writers.username FROM posts INNER JOIN writers ON writers.id = posts.writerid WHERE writers.id = :writerid';
$sth = $dbh->prepare($query);
$sth->bindValue(':writerid', trim($_GET['id']), PDO::PARAM_STR);
$sth->execute();
$theArticles = $sth->fetchAll();


include 'writer.phtml';
