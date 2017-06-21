<?php
	include('includes/header.php');

	$email_username = "";
	$msg = "";

	if(isset($_POST['login-submit'])) {
		$msg = loginUser($connection);
		if($msg !== "success") {
			$email_username = $_POST['email-username'];
			echo $msg;
		}
	}

	if(isset($_GET['sign-in'])) {
		$msg = '<div class="alert alert-danger">';
		$msg .= '<p>You must be logged in first!</p>';
		$msg .= '</div>';

		echo $msg;
	}
?>

<div id="login-form-div" class="container-fluid">
	<form id="login-form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
	  <h3>Login Form</h3><br>
	  <div class="form-group">
	    <label for="email-username">Email or Username</label>
	    <input type="text" name="email-username" class="form-control" id="email-username" placeholder="Email or Username" value="<?php echo $email_username; ?>" required>
	  </div>
	  <div class="form-group">
	    <label for="password">Password</label>
	    <input type="password" name="login-password" class="form-control" id="login-password" placeholder="Password" required>
	  </div><br>
	  <div id="login-btns" class="pull-right">
		  <button id="login-btn" name="login-submit" type="submit" class="btn btn-primary">Login</button>
		  <a href="login.php" id="login-cancel-btn" class="btn btn-danger">Cancel</a>
	  </div>
	</form>
</div>

<?php include('includes/footer.php'); ?>