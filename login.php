<?php
	include('includes/functions.php'); 
	include('includes/header.php');
?>

<div id="login-form-div" class="container-fluid">
	<form id="login-form" action="<?php $_SERVER['PHP_SELF'] ?>">
	  <h3>Login Form</h3><br>
	  <div class="form-group">
	    <label for="username">Username</label>
	    <input type="text" name="login-username" class="form-control" id="login-username" placeholder="Username">
	  </div>
	  <div class="form-group">
	    <label for="password">Password</label>
	    <input type="password" name="login-password" class="form-control" id="login-password" placeholder="Password">
	  </div><br>
	  <div id="login-btns" class="pull-right">
		  <button id="login-btn" name="submit" type="submit" class="btn btn-primary">Login</button>
		  <a href="mainpage.php" id="login-cancel-btn" class="btn btn-danger">Cancel</a>
	  </div>
	</form>
</div>

<?php include('includes/footer.php'); ?>