<?php


if (!empty($_POST)) {

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

	$query = 'SELECT id, username, hashed_password FROM writers WHERE username = :email';
	$sth = $dbh->prepare($query);
	$sth->bindValue(':email', htmlspecialchars(trim($_POST['username'])), PDO::PARAM_STR);
	$sth->execute();
	$user = $sth->fetch();


	//	S'il l'authentification est réussie…
	if ($user !== false and password_verify(trim($_POST['password']), $user['hashed_password'])) {
		session_start();

		$_SESSION['userid'] = intval($user['id']);

		//	Redirection vers la page privée
		header('Location: ./dashboard.php');
		exit;
	}
	//	Sinon…
	else {
		//	Redirection vers la page d'accueil
		header('Location: ./index.php');
		exit;
	}
}

include 'login.phtml';
