<?php 
  include("functions.php");

  if(isset($_GET['logout'])) {
    logOut();
    header("Location: index.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Yelp Camp</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom1.css" rel="stylesheet">
  </head>
  <body>
    <div id="container" class="container-fluid">
      <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse-navbar" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <?php if(isset($_SESSION['logged_in'])) : ?>
              <a class="navbar-brand" href="mainpage.php">Yelp Camp</a>
            <?php else : ?>
              <a class="navbar-brand" href="index.php">Yelp Camp</a>
            <?php endif; ?>
          </div>

          
          <div class="collapse navbar-collapse" id="collapse-navbar">
            <ul class="nav navbar-nav navbar-right">
              <?php if(isset($_SESSION['logged_in'])) : ?>
                <li><a href="user.php">Welcome, <?php echo $_SESSION['camper_data']['name']; ?></a></li>
                <li><a id="logout-btn" href="?logout">Log Out</a></li>
                <!-- <li><form method="post"><button id="logout-btn" name="log-out">Log Out</button></form></li> -->
              <?php else : ?>
                <li><a href="login.php">Log In</a></li>
                <li><a href="register.php">Sign Up</a></li>
              <?php endif; ?>  
            </ul>
          </div>
        </div>
      </nav>