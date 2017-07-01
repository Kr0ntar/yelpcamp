<?php 
	include('includes/header.php');

	$value = "";

	if(isset($_GET['username'])) {
		$value = $_SESSION['camper_data']['name'];
	} else if(isset($_GET['email'])) {
		$value = $_SESSION['camper_data']['email'];
	}

	if(isset($_POST['edit-username-btn']) || isset($_POST['edit-email-btn'])) {
		if($_POST['edit-username'] === $value || $_POST['edit-email'] === $value) {
			header("Location: user.php");
			exit();
		} else {
			editUsernameEmail($connection);
		}
	}

	if(isset($_SESSION['password-mismatch'])) {
		$value = '<div class="alert alert-danger"><p>Password does not match!</p></div>';
		unset($_SESSION['password-mismatch']);
	}

	if(isset($_SESSION['wrong-old-password'])) {
		$value = '<div class="alert alert-danger"><p>Old password is incorrect!</p></div>';
		unset($_SESSION['wrong-old-password']);
	}
?>

<?php if(isset($_SESSION['logged_in'])) : ?>
<div id="edit-account-div" class="container-fluid flex-container">

	<?php if(isset($_GET['username'])) : ?>
		<form id="edit-username-form"  class="edit-account-form" method="post">
		  <h3>Change Username</h3><br>
		  <div class="form-group">
		    <label for="edit-username">Enter New Username</label>
		    <input type="text" name="edit-username" class="form-control" id="edit-username" placeholder="" value="<?php echo $value; ?>" required>
		  </div>
		  <div class="pull-right">
			  <button id="" name="edit-username-btn" type="submit" class="btn btn-primary">Save Changes</button>
			  <a href="user.php" id="" class="btn btn-danger">Cancel</a>
		  </div>
		</form>

	<?php elseif(isset($_GET['email'])) : ?>
		<form id="edit-email-form"  class="edit-account-form" method="post">
		  <h3>Change Email</h3><br>
		  <div class="form-group">
		    <label for="edit-email">Enter New Email Address</label>
		    <input type="text" name="edit-email" class="form-control" id="edit-email" placeholder="" value="<?php echo $value; ?>" required>
		  </div>
		  <div class="pull-right">
			  <button id="" name="edit-email-btn" type="submit" class="btn btn-primary">Save Changes</button>
			  <a href="user.php" id="" class="btn btn-danger">Cancel</a>
		  </div>
		</form>

	<?php else : ?>
		<form id="edit-password-form"  action="login.php" class="edit-account-form" method="post">
		  <h3>Change Password</h3><br>
		  <div class="form-group">
		    <label for="old-password">Enter Old Password</label>
		    <input type="password" name="old-password" class="form-control" id="old-password" placeholder="" value="" required>
		  </div>
		  <div class="form-group">
		    <label for="new-password">Enter New Password</label>
		    <input type="password" name="new-password" class="form-control" id="new-password" placeholder="" value="" minlength="8" maxlength="100" required>
		  </div>
		  <div class="form-group">
		    <label for="confirm-new-password">Confirm New Password</label>
		    <input type="password" name="confirm-new-password" class="form-control" id="confirm-new-password" placeholder="" value="" required>
		  </div>
		  <?php echo $value; ?>
		  <a href="passwordreset.php">Forgot Password?</a><br><br>
		  <div class="pull-right">
			  <button id="" name="edit-password-btn" type="submit" class="btn btn-primary">Save Changes</button>
			  <a href="user.php" id="" class="btn btn-danger">Cancel</a>
		  </div>
		</form>
	<?php endif; ?>
</div>
<?php else : ?>
	<?php header("Location: index.php"); ?>
	<?php exit(); ?>
<?php endif; ?>

<?php include('includes/footer.php'); ?>