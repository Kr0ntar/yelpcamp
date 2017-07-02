<?php 
	include('includes/header.php'); 

	$msg = "";

	if(isset($_SESSION['edited'])) {
		$msg = '<div class="alert alert-success"><p>Changes saved!</p></div>';
      	unset($_SESSION['edited']);
	}

	if($msg) {
		echo '<style>#user-info-table { margin-top: 50px; }</style>';
	}
?>

<?php echo $msg; ?>

<div id="user-info-div" class="container flex-container">
	<?php if(isset($_SESSION['logged_in'])) : ?>
		<table id="user-info-table" class="table table-striped table-bordered">
			<thead>
				<tr>
					<td colspan="3"><h3 class="text-center">User Account Settings</h3></td>
				</tr>
			</thead>
			<tbody>		
				<tr>
					<td class="vert-aligned">Username</td>
					<td class="vert-aligned"><?php echo $_SESSION['camper_data']['name']; ?></td>
					<td class="centered">
						<a href="editaccount.php?username" class="btn btn-warning change-lg-btn">Change</a>
						<a href="editaccount.php?username" class="btn btn-sm btn-warning change-sm-btn">Change</a>
					</td>
				</tr>
				<tr>
					<td class="vert-aligned">Email Address</td>
					<td class="vert-aligned"><?php echo $_SESSION['camper_data']['email']; ?></td>
					<td class="centered">
						<a href="editaccount.php?email" class="btn btn-warning change-lg-btn">Change</a>
						<a href="editaccount.php?email" class="btn btn-sm btn-warning change-sm-btn">Change</a>
					</td>
				</tr>
				<tr>
					<td class="vert-aligned">Password</td>
					<td class="vert-aligned"><input type="password" id="user-password" class="" value="<?php echo $_SESSION['camper_data']['password']; ?>" size="7" disabled></td>
					<td class="centered">
						<a href="editaccount.php?password" class="btn btn-warning change-lg-btn">Change</a>
						<a href="editaccount.php?password" class="btn btn-sm btn-warning change-sm-btn">Change</a>
					</td>
				</tr>
			</tbody>
		</table>
		<button id="delete-user-btn" class="btn btn-danger" data-toggle="modal" data-target="#delete-user-modal">Delete Account</button>

        <div class="modal" id="delete-user-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                    <h4>Delete User Account</h4>
                </div>    
                <div class="modal-body">
                  <p>Are you sure you want to delete your account?</p>
                </div>
                <div class="modal-footer">
                <form action="mainpage.php" method="post" role="form">
                  <input type="hidden" name="comment-id" value="<?php echo $comment['id']; ?>">
                  <button type="submit" name="delete-user" class="btn btn-success">Yes</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                </form>
                </div>
              </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- modal -->
	<?php else : ?>
		<?php header("Location: index.php"); ?>
		<?php exit(); ?>
	<?php endif; ?>
</div>

<?php include('includes/footer.php'); ?>