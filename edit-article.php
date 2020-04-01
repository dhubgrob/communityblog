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


    $query = 'SELECT * FROM posts WHERE id = ?';
    $sth = $dbh->prepare($query);
    $sth->bindValue(1, $_GET['idedit'], PDO::PARAM_INT);
    $sth->execute();
    $articleEdition = $sth->fetch();

    var_dump($articleEdition);


    if (!empty($_POST)) {

        // suppression de l'ancien article

       

        // ajout nouvel article

        $query = 'UPDATE posts 
        SET title=:title,
         content=:content,
         writerid=:writerid,
         image=:image
        WHERE id = :id';
        $sth = $dbh->prepare($query);
        $sth->bindValue(':title', $_POST['newTitle'], PDO::PARAM_STR);
        $sth->bindValue(':content', $_POST['newContent'], PDO::PARAM_STR);
        $sth->bindValue(':writerid', $_SESSION['userid'], PDO::PARAM_STR);
        $sth->bindValue(':id', $_POST['newid'], PDO::PARAM_STR);
        $sth->bindValue(':image', 'null', PDO::PARAM_STR);
        $sth->execute();


        header('Location: http://localhost/projets/community_blog/dashboard.php');
        exit;
    }
    

include 'edit-article.phtml';