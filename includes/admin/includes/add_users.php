<?php if(isset($_POST['add_users'])){
	/* addinguser */
	$username = $_POST['username'];
	$password = $_POST['password'];

	$user_firstname = $_POST['user_firstname'];
	$user_lastname = $_POST['user_lastname'];
	$user_role = $_POST['user_role'];
	$user_email = $_POST['user_email'];

	$username = mysqli_real_escape_string($connection,$username);
	$user_email = mysqli_real_escape_string($connection,$user_email);
	$password = mysqli_real_escape_string($connection,$password);
	$password = password_hash($password,PASSWORD_DEFAULT,['cost'=>9]);

	$query = "INSERT INTO users(user_firstname,user_lastname,username,password,user_email,user_role) ";
	$query .= "VALUES('{$user_firstname}','{$user_lastname}','{$username}','{$password}','{$user_email}','{$user_role}')";
	$querying = mysqli_query($connection,$query);
	if (!$querying) {
		die("error".mysqli_error($connection));
	}
	if ($querying) {
		echo "<h2>user created successfully!</h2>";
	}
}

?>
<form method="post" action="" enctype="multipart/form-data" class="col-md-6">
	<div class="form-group">
		<label for="firstname">Firstname</label>
		<input name="user_firstname" class="form-control" type="text">
	</div>
	<div class="form-group">
		<label for="lastname">Lastname</label>
		<input name="user_lastname" class="form-control" type="text">
	</div>
	<div class="form-group">
		<label for="username">Username</label>
		<input name="username" class="form-control" type="text">
	</div>
	<div class="form-group">
		<label for="password">Password</label>
		<input name="password" class="form-control" type="password">
	</div>
	<div class="form-group">
		<label for="email">Email</label>
		<input name="user_email" class="form-control" type="email">
	</div>
	<div class="form-group">
		<select name="user_role" id="">
			<option value="subscriber">select option</option>
			<option value="admin">admin</option>
			<option value="subscriber">subscriber</option>
		</select>
	</div>
	<div class="form-group">
		<input name="add_users" class="btn btn-primary" type="submit" value="Add user">
	</div>
</form>
