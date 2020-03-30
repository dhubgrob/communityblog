<?php

include 'signup.phtml';

	if(!empty($_POST))
	{

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

		$query = 'INSERT INTO writers (username, hashed_password) VALUES (:email, :passwordHash)';
		$sth = $dbh->prepare($query);
		$sth->bindValue(':email', htmlspecialchars(trim($_POST['username'])), PDO::PARAM_STR);
		$sth->bindValue(':passwordHash', password_hash(trim($_POST['password']), PASSWORD_BCRYPT), PDO::PARAM_STR);
		$sth->execute();

		header('Location:index.php');
		exit;
	}










