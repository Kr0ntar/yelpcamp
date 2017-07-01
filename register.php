<?php
	include('includes/header.php');

	$email = "";
	$username = "";
	$msg = "";

	if(isset($_POST['submit'])) {
		if($_POST['reg-password'] !== $_POST['confirm-password']) {
			$msg = '<div class="alert alert-danger"><p>Password does not match!</p></div>';
		} else {
			$msg = registerUser($connection);
			if($msg !== "success") {
				$email = $_POST['reg-email'];
				$username = $_POST['reg-email'];
			} else {
				$msg = '<div class="alert alert-success"><p>Registered successfully! <a href="login.php">Login Now!</a></p></div>';
			}
		}
	}

	if($msg) {
		echo '<style>
				#reg-form { 
					height: 95%; 
				}
				#registered-link {
					display: none;
				}
			  </style>';
	}
?>

<?php if(isset($_SESSION['logged_in'])) : ?>
	<?php header("Location: mainpage.php"); ?>
	<?php exit(); ?>
<?php else : ?>
	<div id="register-form-div" class="container-fluid flex-container">
		<form id="reg-form" class="flex-form" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
		  <h3>Sign Up Form</h3><br>
		  <div class="form-group">
		    <label for="reg-email">Email</label>
		    <input type="email" name="reg-email" class="form-control" id="reg-email" placeholder="Email Address" value="<?php echo $email; ?>" required>
		  </div>
		  <div class="form-group">
		    <label for="reg-username">Username</label>
		    <input type="text" name="reg-username" class="form-control" id="reg-username" placeholder="Username" value="<?php echo $username; ?>" required>
		  </div>
		  <div class="form-group">
		    <label for="reg-password">Password</label>
		    <input type="password" name="reg-password" class="form-control" id="reg-password" placeholder="Password" minlength="8" maxlength="100" required>
		  </div>
		  <div class="form-group">
		    <label for="confirm-password">Confirm Password</label>
		    <input type="password" name="confirm-password" class="form-control" id="confirm-password" placeholder="Confirm Password" required>
		  </div>
		  <p><a id="registered-link" href="login.php">Already Registered? Please Login</a></p>
		  <?php echo $msg; ?>
		  <div id="reg-btns" class="pull-right">
			  <button id="reg-btn" name="submit" type="submit" class="btn btn-primary">Register</button>
			  <a href="register.php" id="reg-cancel-btn" class="btn btn-danger">Cancel</a>
		  </div>
		</form>
	</div>
<?php endif; ?>

<?php include('includes/footer.php'); ?>