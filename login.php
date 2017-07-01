<?php
	include('includes/header.php');

	$email_username = "";
	$msg = "";

	if(isset($_POST['login-submit'])) {
		$msg = loginUser($connection);
		if($msg) {
			echo '<style>#login-form { height: 70%; }</style>';
		}
		if($msg !== "success") {
			$email_username = $_POST['email-username'];
		}
	}

	if(isset($_GET['sign-in'])) {
		echo '<div class="alert alert-danger"><p>You must be logged in first!</p></div>';
	}

	if(isset($_SESSION['edited'])) {
		echo '<div class="alert alert-success"><p>Changes saved.</p></div>';
	}

	if(isset($_POST['edit-password-btn'])) {
		if($_POST['new-password'] !== $_POST['confirm-new-password']) {
			$_SESSION['password-mismatch'] = true;
			header("Location: editaccount.php?password");
			exit();
		} else if(md5($_POST['old-password']) !== $_SESSION['camper_data']['password']) {
			$_SESSION['wrong-old-password'] = true;
			header("Location: editaccount.php?password");
			exit();
		}
		else {
			changePassword($connection);
		}
	}

	if(isset($_GET['change_pass'])) {
		echo '<div class="alert alert-success"><p>Password changed! Login with your new password.</p></div>';
	}

	if($msg) {
		echo '<style>
				#forgot-account-link { 
					display: none;
				}
			  </style>';
	}
?>

<?php if(isset($_SESSION['logged_in'])) : ?>
	<?php header("Location: mainpage.php"); ?>
	<?php exit(); ?>
<?php else : ?>
	<div id="login-form-div" class="container-fluid">
		<form id="login-form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
		  <h3>Login Form</h3><br>
		  <div class="form-group">
		    <label for="email-username">Email or Username</label>
		    <input type="text" name="email-username" class="form-control" id="email-username" placeholder="Email or Username" value="<?php echo $email_username; ?>" required>
		  </div>
		  <div class="form-group">
		    <label for="password">Password</label>
		    <input type="password" name="login-password" class="form-control" id="login-password" placeholder="Password" required >
		  </div>
		  <?php echo $msg; ?>
		  <p><a href="passwordreset.php" id="forgot-account-link">Forgot Account/Password?</a></p>
		  <div id="login-btns" class="pull-right">
			  <button id="login-btn" name="login-submit" type="submit" class="btn btn-primary">Login</button>
			  <a href="login.php" id="login-cancel-btn" class="btn btn-danger">Cancel</a>
		  </div>
		</form>
	</div>
<?php endif; ?>

<?php include('includes/footer.php'); ?>