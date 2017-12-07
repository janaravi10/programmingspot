<?php if(isset($_POST['edit_users'])){
	/* editing other user */
	$user_id =$_GET['user_id'];
	$username = $_POST['username'];
	$password = $_POST['password'];
     $user_firstname = $_POST['user_firstname'];
	$user_lastname = $_POST['user_lastname'];
	$user_role = $_POST['user_role'];
	$user_email = $_POST['user_email'];

	$password = password_hash($password,PASSWORD_DEFAULT,['cost'=>9]);
	$password = mysqli_real_escape_string($connection,$password);

	$query_update_user = "UPDATE users SET username='{$username}',password='{$password}',user_firstname='{$user_firstname}',user_lastname='{$user_lastname}'";
	$query_update_user .= ",user_role='{$user_role}',user_email='{$user_email}' WHERE user_id = {$user_id}" ;
 	$querying_update_user = mysqli_query($connection,$query_update_user);
	if (!$querying_update_user) {
	die("error".mysqli_error($connection));
	}
  }
?>
<?php if(isset($_GET['user_id'])){
	$user_id = $_GET['user_id'];
	$query = "SELECT * FROM users WHERE user_id={$user_id} ";
 	$querying = mysqli_query($connection,$query);
	if (!$querying) {
	die("error".mysqli_error($connection));
	}
	while ($row = mysqli_fetch_assoc($querying)) {
		$username = $row['username'];
		$user_firstname = $row['user_firstname'];
		$user_lastname = $row['user_lastname'];
	$user_role = $row['user_role'];
	$user_email = $row['user_email'];
?>
<form method="post" action="" enctype="multipart/form-data" class="col-md-6">
	<div class="form-group">
		<label for="firstname">Firstname</label>
		<input name="user_firstname" class="form-control" type="text" value="<?php echo $user_firstname;?>">
	</div>
	<div class="form-group">
		<label for="lastname">Lastname</label>
		<input name="user_lastname" class="form-control" type="text" value="<?php echo $user_lastname;?>">
	</div>
	<div class="form-group">
		<label for="username">Username</label>
		<input name="username" class="form-control" type="text" value="<?php echo $username;?>">
	</div>
	<div class="form-group">
		<label for="password">Password</label>
		<input name="password" class="form-control" type="password" value="">
	</div>
	<div class="form-group">
		<label for="email">Email</label>
		<input name="user_email" class="form-control" type="email" value="<?php echo $user_email; ?>">
	</div>
	<div class="form-group">
	<select name="user_role" id="">
		<option value="<?php echo $user_role;?>"><?php echo $user_role;?></option>
		<?php if ($user_role =='admin') {
			echo "<option value='subscriber'>subscriber</option>";
		}else{
			echo "<option value='admin'>admin</option>";
		} ?>
	</select>
	</div>
	<div class="form-group">
		<input name="edit_users" class="btn btn-primary" type="submit" value="update user">
	</div>
</form>
<?php }} ?>
