<?php 
	include('includes/header.php'); 

	$comment_id = $_GET['comment-id'];
	$post_id = $_GET['post-id'];

	$comment = commentForEditing($connection, $comment_id);

	$unedited_comment = $comment['comment'];

	if(isset($_POST['edit-comment'])) {
		if($unedited_comment === $_POST['edit-comment-box']) {
			header("Location: campinfo.php?post-id=$post_id");
		} else {
			insertEditHistory($connection, $comment_id, $post_id);
			editComment($connection, $comment_id, $post_id);
		}
	}
?>

<div id="edit-comment-div" class="container-fluid">
	<form id="edit-comment-form" method="post">
	  <h3>Edit Comment</h3><br>
	  <div class="form-group">
	    <label for="description">Description</label>
	    <textarea name="edit-comment-box" id="description" class="form-control" placeholder="" required><?php echo $comment['comment']; ?></textarea><br>
	  </div>
	  <div id="edit-comment-btns" class="pull-right">
	  	<button id="edit-comment-btn" name="edit-comment" type="submit" class="btn btn-primary">Submit</button>
	  	<a href="campinfo.php?post-id=<?php echo $comment['post_id']; ?>" class="btn btn-danger">Cancel</a>
	  </div>
	</form>
</div>

<?php include('includes/footer.php'); ?>