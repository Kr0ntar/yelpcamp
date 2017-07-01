<?php 
	include('includes/header.php');

	$post_id = $_GET['post-id'];
	$camp_info = showCampInfo($connection, $post_id);

	if(isset($_POST['edit-camp'])) {
    	editCamp($connection, $post_id);
  	}
?>

<div id="edit-camp-div" class="container-fluid flex-container">
	<form id="edit-camp-form" class="flex-form" method="post">
	  <h3>Edit Campground</h3><br>

	  <div class="form-group">
	    <label for="campname">Camp Name</label>
	    <input type="text" name="edit-camp-name" class="form-control" id="campname" value="<?php echo $camp_info['title']; ?>" required>
	  </div>

	  <div class="form-group">
	    <label for="img-url">Image URL</label>
	    <input type="url" name="edit-camp-img" class="form-control" id="img-url" value="<?php echo $camp_info['img_link']; ?>" required>
	  </div>

	  <div class="form-group">
	    <label for="description">Description</label>
	    <textarea name="edit-description" id="description" class="form-control"><?php echo $camp_info['description']; ?></textarea><br>
	  </div>

	  <div id="add-camp-btns" class="pull-right">
	  	<button id="edit-camp-btn" name="edit-camp" type="submit" class="btn btn-primary">Save Changes</button>
	  	<a href="campinfo.php?post-id=<?php echo $_GET['post-id']; ?>" class="btn btn-danger">Cancel</a>
	  </div>
	  
	</form>
</div>

<?php include('includes/footer.php'); ?>