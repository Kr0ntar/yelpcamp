<?php
	include('includes/functions.php');  
	include('includes/header.php');

	$camp_posts = showCamps($connection);

	// echo "<pre>";
	// print_r($camp_posts);
	// echo "</pre>";
?>

	<div id="main-heading-div" class="container-fluid">
	    <div id="main-heading" class="jumbotron">
	    	<h1 class="text-center">Welcome to YelpCamp</h1>
	    	<h2 class="text-center">Explore some of the best campgrounds all over the world</h2><br>
	    	<a href="addcampground.php" id="add-new-camp-btn" class="btn btn-primary btn-lg">Suggest a Campground</a>
	    </div>

	    <div class="row">
	    	<?php foreach($camp_posts as $camp) : ?>

	    	<div class="col-md-3 col-sm-6">
	    		<div class="thumbnail camp-thumbnails">
	    			<img src="<?php echo $camp['img_link']; ?>" alt="campground">
	    			<h4 class="text-center"><?php echo $camp['title']; ?> </h4>
	    			<a href="campinfo.php?id=<?php echo $camp['id']; ?>"><p class="text-center">More Info...</p></a>		
	    		</div>
	    	</div>

	    	<?php endforeach; ?>
	    	<!-- <div class="col-md-3 col-sm-6">
	    		<div class="thumbnail camp-thumbnails">
	    			<img src="https://static.pexels.com/photos/20974/pexels-photo.jpg" alt="campground">
	    			<h4 class="text-center">Test Image 2</h4>
	    			<a href="#"><p class="text-center">More Info...</p></a>		
	    		</div>
	    	</div>
	    	<div class="col-md-3 col-sm-6">
	    		<div class="thumbnail camp-thumbnails">
	    			<img src="https://upload.wikimedia.org/wikipedia/commons/3/36/Hopetoun_falls.jpg" alt="campground">
	    			<h4 class="text-center">Test Image 3</h4>
	    			<a href="#"><p class="text-center">More Info...</p></a>		
	    		</div>
	    	</div>
	    	<div class="col-md-3 col-sm-6">
	    		<div class="thumbnail camp-thumbnails">
	    			<img src="http://www.sensiblehealth.com/Blog/wp-content/uploads/2017/04/Nature-View.jpg" alt="campground">
	    			<h4 class="text-center">Test Image 4</h4>
	    			<a href="#"><p class="text-center">More Info...</p></a>		
	    		</div>
	    	</div>
	    	<div class="col-md-3 col-sm-6">
	    		<div class="thumbnail camp-thumbnails">
	    			<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgU9msiG0l7SEpSu4alHf43KadepuS2s2_sY9DPhhF_NtSTfXb" alt="campground">
	    			<h4 class="text-center">Test Image 5</h4>
	    			<a href="#"><p class="text-center">More Info...</p></a>		
	    		</div>
	    	</div> -->
	    </div>
    </div>

<?php include('includes/footer.php'); ?>