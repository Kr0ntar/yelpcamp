<?php 
  include('includes/header.php'); 
  include('includes/functions.php');
  
  $camp_id = $_GET['id'];
  $camp_info = showCampInfo($connection, $camp_id);
  $comments = displayComments($connection, $camp_id);
?>

<div id="camp-info-div">
	<div class="thumbnail camp-img">
 	  <img src="<?php echo $camp_info['img_link']; ?>" alt="camp-info">
    <div class="container-fluid">
      <h2><?php echo $camp_info['title']; ?></h2>
      <p><?php echo $camp_info['description']; ?></p>
      <p><em>Submitted by <?php echo $camp_info['username']; ?> on <?php echo $camp_info['post_date']; ?></em></p>
    </div>
  </div>

  <!-- <div class="thumbnail camp-img">
    <img src="https://static.pexels.com/photos/3247/nature-forest-industry-rails.jpg" alt="camp-info">
    <div class="container-fluid">
      <h2>Test Image 1</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut nec varius urna, ut luctus ex. Maecenas tincidunt feugiat tellus, </p>

      <p><em>Submitted by Tom</em></p>
    </div>
  </div> -->

  <div class="well camp-comments">
    <form id="add-comment-form">
      <div class="form-group">
        <textarea id="comment-box" class="form-control"></textarea>
      </div>
      <button id="add-comment-btn" class="btn btn-primary">Add Comment</button>
    </form>
    <hr>
    
    <?php foreach($comments as $comment) : ?>

    <p><?php echo $comment['username'] ?></p>
    <p><?php echo $comment['comment_date'] ?></p>
    <p><?php echo $comment['comment'] ?></p>
    <hr>
    
    <?php endforeach; ?>
  </div>

  <!-- <div class="well camp-comments">
    <form id="add-comment-form">
      <div class="form-group">
        <textarea id="comment-box" class="form-control"></textarea>
      </div>
      <button id="add-comment-btn" class="btn btn-primary">Add Comment</button>
    </form>
    <hr>
    <p>Scratchy</p>
    <p>2017-06-05</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut nec varius urna, ut luctus ex. Maecenas tincidunt feugiat tellus, </p>
    <hr>
    <p>Scratchy</p>
    <p>2017-06-05</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut nec varius urna, ut luctus ex. Maecenas tincidunt feugiat tellus, </p>
    <hr>
  </div> -->

</div>

<?php include('includes/footer.php'); ?>