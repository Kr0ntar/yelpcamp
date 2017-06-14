<?php include('includes/header.php'); ?>

<div id="register-form-div" class="container-fluid">
	<form id="reg-form">
	  <h3>Sign Up Form</h3><br>
	  <div class="form-group">
	    <label for="reg-username">Username</label>
	    <input type="text" name="reg-username" class="form-control" id="reg-username" placeholder="Username">
	  </div>
	  <div class="form-group">
	    <label for="reg-password">Password</label>
	    <input type="password" name="reg-password" class="form-control" id="reg-password" placeholder="Password">
	  </div>
	  <div class="form-group">
	    <label for="confirm-password">Confirm Password</label>
	    <input type="password" name="confirm-password" class="form-control" id="confirm-password" placeholder="Confirm Password">
	  </div>
	  <a href="login.php">Already Registered? Please Login</a><br><br>
	  <div id="reg-btns" class="pull-right">
		  <button id="reg-btn" type="submit" class="btn btn-primary">Register</button>
		  <a href="mainpage.php" id="reg-cancel-btn" class="btn btn-danger">Cancel</a>
	  </div>
	</form>
</div>

<?php include('includes/footer.php'); ?>