<?php 
	include('includes/header.php'); 
?>

<?php if(!isset($_SESSION['logged_in'])) : ?>
	<?php header("Location: login.php?sign-in"); ?>
	<?php exit(); ?>
<?php else : ?>
	<div id="add-camp-div" class="container-fluid flex-container">
		<form id="add-camp-form" class="flex-form" action="mainpage.php" method="post">
		  <h3>Suggest a New Campground</h3><br>
		  <div class="form-group">
		    <label for="campname">Camp Name</label>
		    <input type="text" name="camp-name" class="form-control" id="campname" placeholder="Camp Name" required>
		  </div>
		  <div class="form-group">
		    <label for="img-url">Image URL</label>
		    <input type="url" name="camp-img-url" class="form-control" id="img-url" placeholder="Image URL" required>
		  </div>
		  <div class="form-group">
		    <label for="description">Description</label>
		    <textarea name="description" id="description" class="form-control" placeholder="Description"></textarea><br>
		  </div>
		  <div id="add-btn-div-lg" class="pull-right">
		  	<button name="add-camp" type="submit" class="btn btn-primary">Submit</button>
		  	<a href="mainpage.php" class="btn btn-danger">Cancel</a>
		  </div>
		</form>
	</div>
<?php endif; ?>

<?php include('includes/footer.php'); ?>