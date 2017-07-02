<?php 
  include('includes/header.php'); 

  $post_id = $_GET['post-id'];
  $camp_info = showCampInfo($connection, $post_id);
  $comments = displayComments($connection, $post_id);
  $received = "";
  $error = "";
  $msg = "";

  if(isset($_POST['add-comment'])) {
      $msg = addComment($connection, $post_id);
      $comments = displayComments($connection, $post_id);
  }

  if(isset($_POST['delete-comment'])) {
      deleteComment($connection, $post_id);
      $comments = displayComments($connection, $post_id);
  }

  if(isset($_POST['delete-post'])) {
      deleteCamp($connection, $post_id);
  }

  if(isset($_SESSION['edited'])) {
      $msg = '<div class="alert alert-success"><p>Comment updated!</p></div>';
      unset($_SESSION['edited']);
  }

  if(isset($_SESSION['post-edited'])) {
      $msg = '<div class="alert alert-success"><p>Changes saved!</p></div>';
      unset($_SESSION['post-edited']);
  }
?>

<?php echo $msg; ?>

<div id="camp-info-div" class="flex-container">
	<div class="thumbnail camp-img">
 	  <img src="<?php echo $camp_info['img_link']; ?>" alt="camp-info">
    <div class="container-fluid camp-description">
      <h2><?php echo $camp_info['title']; ?></h2>
      <p><?php echo $camp_info['description']; ?></p>
      <p><em>Submitted by <?php echo $camp_info['username']; ?> on <?php echo $camp_info['post_date']; ?></em></p>

      <?php if(isset($_SESSION['logged_in']) && $_SESSION['camper_data']['name'] == $camp_info['username']) : ?>
        <a href="editcampground.php?post-id=<?php echo $_GET['post-id']; ?>" class="btn btn-warning edit-btn">Edit</button>
        <a href="" data-toggle="modal" data-target="#delete-post-modal" class="btn btn-danger delete-btn">Delete</a>

        <div class="modal" id="delete-post-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                    <h4>Delete Post</h4>
                </div>    
                <div class="modal-body">
                  <p>Are you sure you want to delete this post?</p>
                </div>
                <div class="modal-footer">
                <form action="campinfo.php?post-id=<?php echo $_GET['post-id']; ?>" method="post" role="form">
                  <input type="hidden" name="comment-id" value="<?php //echo $comment['id']; ?>">
                  <button type="submit" name="delete-post" class="btn btn-success">Yes</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                </form>
                </div>
              </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- modal -->
      <?php endif; ?>    
    </div><!-- container-fluid -->
  </div><!-- thumbnail -->

  <div class="well camp-comments">
    <?php if(isset($_SESSION['logged_in'])) : ?>
      <form id="add-comment-form" method="post">
        <div class="form-group">
          <textarea id="comment-box" name="comment-text" class="form-control" required></textarea>
        </div>
        <button id="add-comment-btn" name="add-comment" class="btn btn-primary">Add Comment</button>
      </form>
      <hr>
    <?php endif; ?>

    <?php if(count($comments) == 0) : ?>
      <p class="text-center">No posted comments yet.</p>
    <?php else: ?>
      <?php foreach($comments as $comment) : ?>
        <p><?php echo $comment['username'] ?></p>
        <p><?php echo $comment['comment_date'] ?></p>

        <?php if(isset($_SESSION['logged_in']) && $_SESSION['camper_data']['name'] == $comment['username']) : ?>
          <p id="p-comment"><?php echo $comment['comment']; ?></p>
          <a href="editcomment.php?comment-id=<?php echo $comment['id']; ?>&post-id=<?php echo $_GET['post-id']; ?>" class="btn btn-warning btn-sm edit-btn">Edit</button>
          <a href="" data-toggle="modal" data-target="#delete-comment-modal" class="btn btn-danger btn-sm delete-btn">Delete</a>
          
          <div class="modal" id="delete-comment-modal" role="dialog" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                      <h4>Delete Comment</h4>
                  </div>    
                  <div class="modal-body">
                    <p>Are you sure you want to delete this comment?</p>
                  </div>
                  <div class="modal-footer">
                  <form action="campinfo.php?post-id=<?php echo $_GET['post-id']; ?>" method="post" role="form">
                    <input type="hidden" name="comment-id" value="<?php echo $comment['id']; ?>">
                    <button type="submit" name="delete-comment" class="btn btn-success">Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                  </form>
                  </div>
                </div><!-- modal-content -->
              </div><!-- modal-dialog -->
          </div><!-- modal -->
          
          <?php if(checkEditHistory($connection, $comment['id']) > 0) : ?>
            <a href="" data-toggle="modal" data-target="#editHistoryModal" class="pull-right">Edited</a>
            <div class="modal" id="editHistoryModal" role="dialog" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                      <h4>Edit History</h4>
                  </div>    
                  <div class="modal-body">
                    <?php $editedCommentsHistory = displayEditHistory($connection, $comment['id'], $post_id); ?>
                    <?php foreach($editedCommentsHistory as $history) : ?>
                      <p><?php echo $history['updated_comment_date']; ?></p>
                      <p><?php echo $history['updated_comment']; ?></p>
                    <?php endforeach; ?>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Back</button>
                  </div>
                </div><!-- modal-content -->
              </div><!-- modal-dialog -->
          </div><!-- modal -->
          <?php endif; ?>
        <?php else : ?>
            <p><?php echo $comment['comment']; ?></p>        
        <?php endif; ?>
      <hr>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<?php include('includes/footer.php'); ?>