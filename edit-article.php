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

	// requête qui récupère le username du membre connecté
	$query = 'SELECT username FROM writers WHERE id= :iduser';
	$sth = $dbh->prepare($query);
	$sth->bindValue(':iduser', trim($_SESSION['userid']), PDO::PARAM_STR);
	$sth->execute();
	$usernameSession = $sth->fetch();

$query = 'SELECT * FROM posts WHERE id = ?';
$sth = $dbh->prepare($query);
$sth->bindValue(1, $_GET['idedit'], PDO::PARAM_INT);
$sth->execute();
$articleEdition = $sth->fetch();

var_dump($articleEdition);


if (!empty($_POST)) {

    if (array_key_exists("newMonFichier", $_FILES)) {
        if ($_FILES["newMonFichier"]['error'] == 0) {
            if (in_array(mime_content_type($_FILES["newMonFichier"]['tmp_name']), ['image/png', 'image/jpeg'])) {
                if ($_FILES["newMonFichier"]['size'] <= 3000000) {
                    $urlImageEdit = uniqid() . "." . pathinfo($_FILES["newMonFichier"]['name'], PATHINFO_EXTENSION);
                    move_uploaded_file($_FILES["newMonFichier"]['tmp_name'], 'uploads/' . $urlImageEdit);



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
    $sth->bindValue(':image', $urlImageEdit, PDO::PARAM_STR);
    $sth->execute();


    header('Location: http://localhost/projets/community_blog/dashboard.php');
    exit;
}
} else {
    echo 'Le fichier est trop volumineux…';
}
} else {
echo 'Le type mime du fichier est incorrect…';
}
} else {
echo 'Le fichier n\'a pas pu être récupéré…';
}
}


include 'edit-article.phtml';
