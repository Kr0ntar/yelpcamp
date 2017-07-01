<?php 
	include('includes/header.php');
	$msg = "";

	if(isset($_POST['search-email-btn'])) {
		$temp_password = mt_rand(10000000, 9999999999);
		$msg = resetPassword($connection, $temp_password);
		echo $msg;
		echo '<style>#search-email-form { margin-top: 80px; }</style>';
	}
?>

<div id="search-email-div" class="container-fluid flex-container">
	<form id="search-email-form" class="flex-form" method="post">
	  <h3>Find Your Account</h3><br>
	  <div class="form-group">
	    <label for="search-email">Please enter your email address to search for your account.</label>
	    <input type="email" name="search-email" class="form-control" id="search-email" placeholder="Email address" required>
	  </div>
	  <div class="pull-right">
		  <button name="search-email-btn" type="submit" class="btn btn-primary">Search</button>
		  <a href="login.php" class="btn btn-danger">Cancel</a>
	  </div>
	</form>
</div>
<?php include('includes/footer.php'); ?>