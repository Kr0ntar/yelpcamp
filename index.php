<?php include('includes/header.php'); ?>

<?php if(isset($_SESSION['logged_in'])) : ?>
	<?php header("Location: mainpage.php"); ?>
	<?php exit(); ?>
<?php else : ?>
    <section id="landing-page" class="container-fluid flex-container text-center">
      <div id="landing-div" class="container">
        <h1 class="text-center">YelpCamp</h1>
        <h2 class="text-center">Find your next camping adventure</h2>
        <a href="mainpage.php" id="landing-btn" class="btn btn-primary btn-lg">Explore!</a>
      </div>
    </section>
<?php endif; ?>

<?php include('includes/footer.php'); ?>