<?php
	include('config.php');
	
	function registerUser($conn) {
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$username = $post['reg-username'];
		$password = md5($post['reg-password']);

		$query = "SELECT username, password FROM campers WHERE username = :user AND password = :pass";
		$statement = $conn->prepare($query);
		$statement->bindValue(':user', $username, PDO::PARAM_STR);
		$statement->bindValue(':pass', $password, PDO::PARAM_STR);
		$statement->execute();
		$count = count($statement->fetchAll());
		$statement->closeCursor();

		if($count > 0) {
			$error = '<div class="alert alert-danger">';
			$error .= '<p>User already exists</p>';
			$error .= '</div>';
			return $error;
		} else {
			$query = "INSERT INTO campers (username, password) VALUES (:user, :pass)";
			$statement = $conn->prepare($query);
			$statement->bindValue(':user', $username, PDO::PARAM_STR);
			$statement->bindValue(':pass', $password, PDO::PARAM_STR);
			$statement->execute();
			$statement->closeCursor();

			$msg = '<div class="alert alert-success">';
			$msg .= '<p>Registered successfully!</p>';
			$msg .= '</div>';
			return $msg;
		}
	}
?>