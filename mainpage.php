<?php
	include('includes/header.php');

	$camp_posts = showCamps($connection);
	$sign_in = isset($_SESSION['logged_in']) ? 'addcampground.php' : 'login.php?sign-in';

	if(isset($_POST['delete-user'])) {
		deleteUser($connection);
	}

	if(isset($_GET['user_deleted'])) {
		echo '<div class="alert alert-danger"><p>User Account deleted!</p></div>';
	}

	if(isset($_POST['add-camp'])) {
		echo addCamp($connection);
		$camp_posts = showCamps($connection);
	}

	if(isset($_SESSION['post-deleted'])) {
		echo '<div class="alert alert-danger"><p>Camp post deleted!</p></div>';
      	unset($_SESSION['post-deleted']);
	}
?>

<div id="main-heading-div" class="container-fluid">
    <div id="main-heading" class="jumbotron flex-container">
    	<h1 class="text-center">Welcome to YelpCamp</h1>
    	<h2 class="text-center">Explore some of the best campgrounds all over the world</h2><br>
    	<a href="<?php echo $sign_in; ?>" id="add-new-camp-btn" class="btn btn-primary btn-lg">Suggest a Campground</a>
    </div>

    <div class="row">
    	<?php foreach($camp_posts as $camp) : ?>

    	<div class="col-lg-3 col-sm-6">
    		<div class="thumbnail camp-thumbnails">
    			<img src="<?php echo $camp['img_link']; ?>" alt="<?php echo $camp['title']; ?>">
    			<?php if(strlen($camp['title']) > 25) : ?>
    				<h4 id="camp-title" class="text-center"><?php echo substr($camp['title'], 0, 22) . "..."; ?> </h4>
    			<?php else: ?>
    				<h4 id="camp-title" class="text-center"><?php echo $camp['title']; ?> </h4>
    			<?php endif; ?>
    			<a href="campinfo.php?post-id=<?php echo $camp['id']; ?>"><p class="text-center">More Info...</p></a>		
    		</div>
    	</div>

    	<?php endforeach; ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>