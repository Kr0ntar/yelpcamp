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

	function showCamps($conn) {
		$query = "SELECT * FROM camp_posts";
		$statement = $conn->prepare($query);
		$statement->execute();
		$camp_posts = $statement->fetchAll();
		$statement->closeCursor();

		return $camp_posts;		
	}

	function showCampInfo($conn, $id) {
		$query = "SELECT * FROM camp_posts WHERE id = :id";
		$statement = $conn->prepare($query);
		$statement->bindValue(':id', $id);
		$statement->execute();
		$camp_info = $statement->fetch();
		$statement->closeCursor();

		return $camp_info;
	}

	function displayComments($conn, $id) {
		$query = "SELECT * FROM comments WHERE post_id = :id ORDER BY comment_date DESC";
		$statement = $conn->prepare($query);
		$statement->bindValue(':id', $id);
		$statement->execute();
		$comments = $statement->fetchAll();
		$statement->closeCursor();

		return $comments;	
	}
?>