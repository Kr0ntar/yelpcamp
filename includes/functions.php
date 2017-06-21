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

	function loginUser($conn) {
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$username = $post['login-username'];
		$password = md5($post['login-password']);

		$query = "SELECT * FROM campers WHERE username = :username AND password = :password";

		$statement = $conn->prepare($query);
		$statement->bindValue(':username', $username);
		$statement->bindValue(':password', $password);
		$statement->execute();
		$matchFound = $statement->fetch();
		$statement->closeCursor();

		if($matchFound) {
			$_SESSION['logged_in'] = true;
			$_SESSION['camper_data'] = ["id"=>$matchFound['id'], "name"=>$matchFound['username']];
			header("Location: mainpage.php");

			// $msg = '<div class="alert alert-success">';
			// $msg .= '<p>Logged In!</p>';
			// $msg .= '</div>';
			// return $msg;
		} else {
			// $error = '<div class="alert alert-danger">';
			// $error .= '<p>Not yet registered!</p>';
			// $error .= '</div>';
			header("Location: login.php?login-error");
			// return $error;
		}
	}

	function logOut() {
		unset($_SESSION['logged_in']);
        unset($_SESSION['camper_data']);
        session_destroy();
        // header("Location: mainpage.php");
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

	function editComment($conn, $comment_id, $post_id) {
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$updatedComment = $post['edit-comment-box'];

		$query = "UPDATE comments SET comment = :edit_comment WHERE id = :comment_id";
		$statement = $conn->prepare($query);
		$statement->bindValue(':edit_comment', $updatedComment);
		$statement->bindValue(':comment_id', $comment_id);
		$statement->execute();
		$statement->closeCursor();

		$_SESSION['edit-comment'] = "success";

		header("Location: campinfo.php?post-id=$post_id");
	}

	function insertEditHistory($conn, $comment_id, $post_id) {
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$updatedComment = $post['edit-comment-box'];
		$date = date('Y-m-d H:i:s');

		$query = "INSERT INTO edit_comment_history(comment_id, post_id, username, updated_comment, updated_comment_date) 
				  VALUES(:comment_id, :post_id, :username, :updated_comment, :updated_comment_date)";
		$statement = $conn->prepare($query);
		$statement->bindValue(':comment_id', $comment_id);
		$statement->bindValue(':post_id', $post_id);
		$statement->bindValue(':username', $_SESSION['camper_data']['name']);
		$statement->bindValue(':updated_comment', $updatedComment);
		$statement->bindValue(':updated_comment_date', $date);
		$statement->execute();
		$statement->closeCursor();
	}

	function commentForEditing($conn, $id) {
		$query = "SELECT * FROM comments WHERE id = :id";
		$statement = $conn->prepare($query);
		$statement->bindValue(':id', $id);
		$statement->execute();
		$comment = $statement->fetch();
		$statement->closeCursor();

		return $comment;
	}

	function displayEditHistory($conn, $comment_id, $post_id) {
		$query = "SELECT * FROM edit_comment_history WHERE comment_id = :comment_id AND post_id = :post_id 
				  ORDER BY updated_comment_date DESC";

		$statement = $conn->prepare($query);
		$statement->bindValue(':comment_id', $comment_id);
		$statement->bindValue(':post_id', $post_id);
		$statement->execute();
		$history = $statement->fetchAll();
		$statement->closeCursor();

		return $history;
	}

	function checkEditHistory($conn, $id) {
		$query = "SELECT * FROM edit_comment_history WHERE comment_id = :id";
		$statement = $conn->prepare($query);
		$statement->bindValue(':id', $id);
		$statement->execute();
		$comment_history_count = $statement->fetch();
		$statement->closeCursor();

		return $comment_history_count;
	}

	function addComment($conn, $post_id) {
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$textComment = $post['comment-text'];
		$date = date('Y-m-d H:i:s');

		$query = "INSERT INTO comments(user_id, post_id, username, comment, comment_date) VALUES(:user_id, :post_id, :username, :comment, :comment_date)";
		$statement = $conn->prepare($query);
		$statement->bindValue(':user_id', $_SESSION['camper_data']['id']);
		$statement->bindValue(':post_id', $post_id);
		$statement->bindValue(':username', $_SESSION['camper_data']['name']);
		$statement->bindValue(':comment', $textComment);
		$statement->bindValue(':comment_date', $date);
		$statement->execute();
		$statement->closeCursor();

		$msg = '<div class="alert alert-success"><p>Comment added!</p></div>';

		echo $msg;
	}

	function deleteComment($conn, $post_id) {
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$comment_id = $post['comment-id'];

		$query = "DELETE FROM comments WHERE id = :comment_id ";
		$statement = $conn->prepare($query);
		$statement->bindValue(':comment_id', $comment_id);
		$statement->execute();
		$statement->closeCursor();

		$msg = '<div class="alert alert-danger"><p>Comment deleted!</p></div>';

		echo $msg;
	}

	function deleteCommentHistory($conn, $post_id) {
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$comment_id = $post['comment-id'];

		$query = "DELETE FROM edit_comment_history WHERE comment_id = :comment_id ";
		$statement = $conn->prepare($query);
		$statement->bindValue(':comment_id', $comment_id);
		$statement->execute();
		$statement->closeCursor();	
	}

?>