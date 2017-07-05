<?php
	include('config.php');
	
	/* user account functions */
	function registerUser($conn) {
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$email = $post['reg-email'];
		$username = $post['reg-username'];
		$password = md5($post['reg-password']);

		$query = "SELECT * FROM campers WHERE email = :email OR username = :user";
		$statement = $conn->prepare($query);
		$statement->bindValue(':email', $email, PDO::PARAM_STR);
		$statement->bindValue(':user', $username, PDO::PARAM_STR);
		$statement->execute();
		$userExists = $statement->fetch();
		$statement->closeCursor();

		if($userExists) {
			if($userExists['username'] === $username && $userExists['email'] === $email) {
				$error = '<div class="alert alert-danger errors"><p>User already exists!</p></div>';
				return $error;
			} else if($userExists['email'] === $email) {
				$error = '<div class="alert alert-danger"><p>Email already taken!</p></div>';
				return $error;
			} else if($userExists['username'] === $username) {
				$error = '<div class="alert alert-danger"><p>Username not available!</p></div>';
				return $error;
			}		
		} else {
			$query = "INSERT INTO campers (email, username, password) VALUES (:email, :user, :pass)";
			$statement = $conn->prepare($query);
			$statement->bindValue(':email', $email, PDO::PARAM_STR);
			$statement->bindValue(':user', $username, PDO::PARAM_STR);
			$statement->bindValue(':pass', $password, PDO::PARAM_STR);
			$statement->execute();
			$statement->closeCursor();

			$msg = "success";
			return $msg;
		}
	}

	function editUsernameEmail($conn) {
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

		if(isset($post['edit-username'])) {
			$query = "UPDATE campers SET username = :username WHERE id = :id";
			$statement = $conn->prepare($query);
			$statement->bindValue(':username', $post['edit-username']);
		} else if(isset($post['edit-email'])) {
			$query = "UPDATE campers SET email = :email WHERE id = :id";
			$statement = $conn->prepare($query);
			$statement->bindValue(':email', $post['edit-email']);
		}

		$statement->bindValue(':id', $_SESSION['camper_data']['id']);
		$statement->execute();
		$statement->closeCursor();

		$query = "SELECT * FROM campers WHERE id = :id";
		$statement = $conn->prepare($query);
		$statement->bindValue(':id', $_SESSION['camper_data']['id']);
		$statement->execute();
		$newUser = $statement->fetch();
		$statement->closeCursor();
		
		$_SESSION['camper_data']['name'] = $newUser['username'];
		$_SESSION['camper_data']['email'] = $newUser['email'];
		$_SESSION['edited'] = "success";

		$statement1 = $conn->prepare("UPDATE camp_posts SET username = :username WHERE user_id = :user_id");
		$statement2 = $conn->prepare("UPDATE comments SET username = :username WHERE user_id = :user_id");
		$statement3 = $conn->prepare("UPDATE edit_comment_history SET username = :username WHERE user_id = :user_id");
		$statement1->bindValue(':user_id', $_SESSION['camper_data']['id']);
		$statement1->bindValue(':username', $_SESSION['camper_data']['name']);
		$statement2->bindValue(':user_id', $_SESSION['camper_data']['id']);
		$statement2->bindValue(':username', $_SESSION['camper_data']['name']);
		$statement3->bindValue(':user_id', $_SESSION['camper_data']['id']);
		$statement3->bindValue(':username', $_SESSION['camper_data']['name']);
		$statement1->execute();
		$statement1->closeCursor();
		$statement2->execute();
		$statement2->closeCursor();
		$statement3->execute();
		$statement3->closeCursor();

		header("Location: user.php");
		exit();
	}

	function changePassword($conn) {
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$old_password = md5($post['old-password']);
		$new_password = md5($post['new-password']);

		$query = "UPDATE campers SET password = :password WHERE id = :id";
		$statement = $conn->prepare($query);
		$statement->bindValue(':id', $_SESSION['camper_data']['id']);
		$statement->bindValue(':password', $new_password);
		$statement->execute();
		$statement->closeCursor();

		logOut();
		
		header("Location: login.php?change_pass=true");
		exit();
	}

	function deleteUser($conn) {
		$statement1 = $conn->prepare("DELETE FROM campers WHERE id = :id");
		$statement2 = $conn->prepare("DELETE FROM camp_posts WHERE user_id = :id");
		$statement3 = $conn->prepare("DELETE FROM comments WHERE user_id = :id");
		$statement4 = $conn->prepare("DELETE FROM edit_comment_history WHERE user_id = :id");

		$statement1->bindValue(':id', $_SESSION['camper_data']['id']);
		$statement2->bindValue(':id', $_SESSION['camper_data']['id']);
		$statement3->bindValue(':id', $_SESSION['camper_data']['id']);

		$statement1->execute();
		$statement1->closeCursor();
		$statement2->execute();
		$statement2->closeCursor();
		$statement3->execute();
		$statement3->closeCursor();

		logOut();

		header("Location: mainpage.php?user_deleted=true");
		exit();
	}

	function loginUser($conn) {
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$email = $post['email-username'];
		$username = $post['email-username'];
		$password = md5($post['login-password']);

		$query = "SELECT * FROM campers WHERE email = :email OR username = :username";

		$statement = $conn->prepare($query);
		$statement->bindValue(':email', $email);
		$statement->bindValue(':username', $username);
		$statement->execute();
		$matchFound = $statement->fetch();
		$statement->closeCursor();

		if($matchFound) {
			if( ($matchFound['email'] === $email || $matchFound['username'] === $username) && $matchFound['password'] !== $password) {
				return '<div class="alert alert-danger"><p>Incorrect Password! <a href="passwordreset.php">Forgot Password?</a></p></div>';
			} else {
				$_SESSION['logged_in'] = true;
				$_SESSION['camper_data'] = ["id"=>$matchFound['id'], "email"=>$matchFound['email'], "name"=>$matchFound['username'], "password"=>$matchFound['password']];
				header("Location: mainpage.php");
				exit();
			}
		} else {
			return '<div class="alert alert-danger"><p>Email or Username cannot be found. <a href="register.php">Sign up for an account.</a></p></div>';
		}
	}

	function logOut() {
		unset($_SESSION['logged_in']);
        unset($_SESSION['camper_data']);
        session_destroy();
	}

	function resetPassword($conn, $temp_pass) {
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$email = $post['search-email'];
		$new_password = md5($temp_pass);

		$statement1 = $conn->prepare("SELECT *FROM campers WHERE email = :email");
		$statement1->bindValue(':email', $email);
		$statement1->execute();
		$emailFound = $statement1->fetch();
		$statement1->closeCursor();

		if($emailFound) {
			$statement2 = $conn->prepare("UPDATE campers SET password = :password WHERE email = :email");
			$statement2->bindValue(':password', $new_password);
			$statement2->bindValue(':email', $email);
			$statement2->execute();
			$statement2->closeCursor();

			$emailTo = $emailFound['email'];
		    $subject = "Password Reset";        
		    $message = "Your new password is ". $temp_pass . ". Please use this to login to your account. You can then change your password anytime after you logged in using the passcode that you received. Thank you very much."; 
		    $headers = "From: YelpCamp Team <jleorico@gmail.com>";
    
    		mail($emailTo, $subject, $message, $headers);

			return '<div class="alert alert-success">Password reset success! Please check your email for the new passcode (min. 8 characters).</div>';
		} else {
			return '<div class="alert alert-danger">Email not found!</div>';
		}
	}


	/* camp posts functions */
	function addCamp($conn) {
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$title = $post['camp-name'];
		$img_url = $post['camp-img-url'];
		$description = $post['description'];
		$date = date('Y-m-d H:i:s');

		$query = "INSERT INTO camp_posts(user_id, username, title, description, img_link, post_date) 
				  VALUES(:user_id, :username, :title, :description, :img_link, :post_date)";
		$statement = $conn->prepare($query);
		$statement->bindValue(':user_id', $_SESSION['camper_data']['id']);
		$statement->bindValue(':username', $_SESSION['camper_data']['name']);
		$statement->bindValue(':title', $title);
		$statement->bindValue(':description', $description);
		$statement->bindValue(':img_link', $img_url);
		$statement->bindValue(':post_date', $date);
		$statement->execute();
		$statement->closeCursor();

		return '<div class="alert alert-success"><p>New campsite added!</p></div>';
	}

	function showCamps($conn) {
		$query = "SELECT * FROM camp_posts ORDER BY title";
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

	function editCamp($conn, $post_id) {
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$title = $post['edit-camp-name'];
		$img_url = $post['edit-camp-img'];
		$description = $post['edit-description'];
		$date = date('Y-m-d H:i:s');

		$query = "UPDATE camp_posts SET title = :title,
				  description = :description,
				  img_link = :img_link,
				  post_date = :post_date
				  WHERE id = :post_id";
		
		$statement = $conn->prepare($query);
		$statement->bindValue(':post_id', $post_id);
		$statement->bindValue(':title', $title);
		$statement->bindValue(':description', $description);
		$statement->bindValue(':img_link', $img_url);
		$statement->bindValue(':post_date', $date);
		$statement->execute();
		$statement->closeCursor();

		$_SESSION['post-edited'] = "success";

		header("Location: campinfo.php?post-id=$post_id");
		exit();
	}

	function deleteCamp($conn, $post_id) {
		$statement1 = $conn->prepare("DELETE FROM camp_posts WHERE id = :post_id");
		$statement2 = $conn->prepare("DELETE FROM comments WHERE post_id = :post_id");
		$statement3 = $conn->prepare("DELETE FROM edit_comment_history WHERE post_id = :post_id");

		$statement1->bindValue(':post_id', $post_id);
		$statement2->bindValue(':post_id', $post_id);
		$statement3->bindValue(':post_id', $post_id);

		$statement1->execute();
		$statement1->closeCursor();

		$statement2->execute();
		$statement2->closeCursor();

		$statement3->execute();
		$statement3->closeCursor();

		$_SESSION['post-deleted'] = "success";

		header("Location: mainpage.php");
		exit();
	}

	
	/* comments functions */
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
		$date = date('Y-m-d H:i:s');

		$query = "INSERT INTO edit_comment_history(comment_id, post_id, user_id, username, updated_comment, updated_comment_date) 
				  VALUES(:comment_id, :post_id, :user_id, :username, :updated_comment, :updated_comment_date)";
		$statement1 = $conn->prepare("UPDATE comments SET comment = :edit_comment WHERE id = :comment_id");
		$statement2 = $conn->prepare($query);

		$statement1->bindValue(':edit_comment', $updatedComment);
		$statement1->bindValue(':comment_id', $comment_id);

		$statement2->bindValue(':comment_id', $comment_id);
		$statement2->bindValue(':post_id', $post_id);
		$statement2->bindValue(':user_id', $_SESSION['camper_data']['id']);
		$statement2->bindValue(':username', $_SESSION['camper_data']['name']);
		$statement2->bindValue(':updated_comment', $updatedComment);
		$statement2->bindValue(':updated_comment_date', $date);

		$statement1->execute();
		$statement1->closeCursor();
		$statement2->execute();
		$statement2->closeCursor();

		$_SESSION['edited'] = "success";

		header("Location: campinfo.php?post-id=$post_id");
		exit();
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

	function deleteComment($conn, $post_id) {
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$comment_id = $post['comment-id'];

		$statement1 = $conn->prepare("DELETE FROM comments WHERE id = :comment_id");
		$statement2 = $conn->prepare("DELETE FROM edit_comment_history WHERE comment_id = :comment_id");

		$statement1->bindValue(':comment_id', $comment_id);
		$statement2->bindValue(':comment_id', $comment_id);
		
		$statement1->execute();
		$statement1->closeCursor();

		$statement2->execute();
		$statement2->closeCursor();

		$msg = '<div class="alert alert-danger"><p>Comment deleted!</p></div>';

		echo $msg;
	}
?>