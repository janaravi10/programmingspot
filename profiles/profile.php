<?php include 'includes/admin_header.php'; ?>
<div id="wrapper">
  <!-- Navigation -->
  <?php  $count_rows = users_online(); ?>
  <?php include 'includes/admin_navigation.php' ?>

  <div id="page-wrapper">

    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">
            Welcome
            <small><?php echo $_SESSION['username']; ?> </small>
						<?php 
						$query_profile_image = "SELECT * FROM profileimage WHERE userid={$_SESSION['user_id']}";
						$querying_profile_image = mysqli_query($connection,$query_profile_image);
						if(mysqli_num_rows($querying_profile_image) === 1){
							$row_image = mysqli_fetch_assoc($querying_profile_image);
							echo '<img src="../img/'.$row_image['profileimage'].'" alt="" style="width: 60px; height: 60px; border-radius: 100%;">';
						}else{
							echo '<img src="../img/profile.png" alt="" style="width: 50px; height: 50px; border-radius: 100%;">';
						}
						?>
						 
          </h1>
<?php
if(isset($_SESSION['username'])){
	$username = $session_username;
	$query = "SELECT * FROM users WHERE username='{$username}' ";
 	$querying = mysqli_query($connection,$query);
	if (!$querying) {
	die("error".mysqli_error($connection));
	}
	while ($row = mysqli_fetch_assoc($querying)) {
		$username = $row['username'];
		$user_firstname = $row['user_firstname'];
		$user_lastname = $row['user_lastname'];
	$user_email = $row['user_email'];
?>
<form method="post" action="" enctype="multipart/form-data" class="col-md-6" id="updateProfileForm">
  <label for="" id="updateFormIndicate"></label>
	<div class="form-group">
		<label for="firstname" >Firstname</label>
		<input name="user_firstname" id="firstname" class="form-control" type="text" value="<?php echo $user_firstname;?>">
	</div>
	<div class="form-group">
		<label for="lastname">Lastname</label>
		<input name="user_lastname" id="lastname" class="form-control" type="text" value="<?php echo $user_lastname;?>">
	</div>
	<div class="form-group">
		<label for="username">username</label>
		<input name="username" class="form-control" id="username"  type="text" value="<?php echo $username;?>"><span></span>
	</div>
	<div class="form-group">
		<label for="email">Email</label>
		<input name="user_email" class="form-control" type="email" id="email" value="<?php echo $user_email; ?>">
	</div>
	<div class="form-group">
		<input name="update_profile" class="btn btn-primary" type="submit" value="update profile">
	</div>
</form>
<?php }} ?>

<form class="col-md-6" id='passwordForm' method="POST" action="">
  <div class="form-group">
    <label for="password">Old password</label>
    <input type="password" name="old_password" value="" class="form-control" id="oldPassword">
  </div>
  <div class="form-group">
    <label for="password">New password</label>
    <input type="password" name="new_password" value="" class="form-control" id="newPassword">
  </div>
  <div class="form-group">
    <input type="submit" name="change_password" value="change password" class="btn btn-success" >
  </div>
</form>
<div id="passwordBox"></div>
<?php 
    upload_profile_img();
?>
<form action="profile.php" class="col-md-6" method="POST" enctype="multipart/form-data">
<div class="form-group">
	<label for="image">profile image</label>
	<input type="file" id="profileimg" class="form-control-file" name="profileimg">
	</div>
	<button type="submit" class="btn btn-info" name="upload">upload</button>
</form>

     </div>
   </div>
   <!-- /.row -->

 </div>
 <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php include 'includes/admin_footer.php'; ?>
