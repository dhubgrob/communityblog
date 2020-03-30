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

// pour récupérer l'article
$query = 'SELECT posts.id AS postid, posts.title, posts.image, posts.content, posts.publication_date, posts.writerid, writers.id, writers.username FROM posts INNER JOIN writers ON writers.id = posts.writerid WHERE posts.id = :postid';
$sth = $dbh->prepare($query);
$sth->bindValue(':postid', htmlspecialchars($_GET['id']), PDO::PARAM_STR);
$sth->execute();
$theArticle = $sth->fetch();
// pour récupérer les commentaires de l'article

$query = 'SELECT username, content, articleid FROM comments WHerE articleid=:articleid';
$sth = $dbh->prepare($query);
$sth->bindValue(':articleid', htmlspecialchars($theArticle['postid']), PDO::PARAM_STR);
$sth->execute();
$allComments = $sth->fetchAll();


//gestion ajout de commentaires
if(!empty($_POST))
{



    $query = 'INSERT INTO comments (username, content, articleid) VALUES (:username, :content, :articleid)';
    $sth = $dbh->prepare($query);
    $sth->bindValue(':username', htmlspecialchars($_POST['pseudo']), PDO::PARAM_STR);
    $sth->bindValue(':content', htmlspecialchars($_POST['commentaire']), PDO::PARAM_STR);
    $sth->bindValue(':articleid', htmlspecialchars($_POST["postidcomment"]), PDO::PARAM_STR);
    $sth->execute();

    var_dump($_POST);
header('Location:index.php');
    exit;
}





include 'article.phtml';