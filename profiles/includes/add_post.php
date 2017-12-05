<?php if(isset($_POST['add_post'])){
	$post_author_id = $_SESSION['user_id'];
	$post_title = $_POST['post_title'];
	$post_author = $_SESSION['username'];
    $post_cat_id = $_POST['post_cat_id'];
	$post_status = $_POST['post_status']; 
	$post_tags = $_POST['post_tags'];
	$post_content = $_POST['post_content'];
	$post_title =  mysqli_real_escape_string($connection,$post_title);
	$post_tags = mysqli_real_escape_string($connection,$post_tags);
	$post_content = mysqli_real_escape_string($connection,$post_content);
	$post_comment_count = 0;
	$post_image = $_FILES['post_image'];
	$image_type = $post_image['type'];
	$image_size = $post_image['size'];
	$image_tmp_name = $post_image['tmp_name'];
	$image_type = explode("/",$image_type);
	$actual_extension = strtolower(end($image_type));
	$allowed_extension = array("jpg","jpeg","png");
	if(in_array($actual_extension,$allowed_extension)){
		if($image_size < 2048000){
			$stmt = "INSERT INTO posts(post_cat_id,post_title,post_author,post_date,post_image,post_content,post_tags,post_comment_count,post_status,post_author_id)";
			$stmt .= "VALUES(?,?,?,now(),?,?,?,?,?,?)";
			$add_post_stmt= mysqli_prepare($connection,$stmt);
			mysqli_stmt_bind_param($add_post_stmt,"isssssisi",$post_cat_id,$post_title,$post_author,$image_tmp_name,$post_content,$post_tags,$post_comment_count,$post_status,$post_author_id);
			if (mysqli_stmt_execute($add_post_stmt)) {
				$post_id = mysqli_insert_id($connection);
				echo "<h4 class='alert alert-success text-center'>post added " . " <a href ='../post.php?post_id={$post_id}'> view post</a></h4>";
			}else{
				echo "<h4 class='alert alert-success text-center'>SERVER FAILED</h4>";
			}
			mysqli_stmt_close($add_post_stmt);
			$image_name_to_db = "post".$post_id.".".$actual_extension;
			$query_update = "UPDATE posts SET post_image ='$image_name_to_db' WHERE post_id = $post_id ";
			$querying_update = mysqli_query($connection,$query_update);
			confirm_query($query_update);
						move_uploaded_file($image_tmp_name,"../img/post".$post_id.".".$actual_extension);
					}else{
						echo "<h4 class='alert alert-danger text-center'>image size is too big</h4>";
					}
	}else{
		echo "<h4 class='alert alert-danger text-center'>file is note allowed </h4>";
	}	
}
?>
<form method="post" action="" enctype="multipart/form-data" class="col-md-6">
	<div class="form-group">
		<label for="title">Post title</label>
		<input name="post_title" class="form-control" type="text">
	</div>
	<div class="form-group">
		<select name="post_cat_id" id="">
					<?php 
					$query = "SELECT * FROM categories";
					$querying = mysqli_query($connection,$query);
                                // LOOPING THROUGH THE DATA
					while ($row = mysqli_fetch_assoc($querying)) {
						$cat_id = $row['cat_id'];
						$cat_title = $row['cat_title'];
						echo "<option value='{$cat_id}'>{$cat_title}</option>";

					}
					?>

				</select>
	</div>
	<div class="form-group">
		<label for="post_author">Post author</label>
		<p><?php echo $_SESSION['username']; ?></p>
	</div>
	<div class="form-group">
	<select name="post_status" id="">
		<option value="published">published</option>
	   <option value="draft">draft</option>
	</select>
	</div>
	<div class="form-group">
		<label for="post_image">Post image</label>
		<input name="post_image"  type="file">
	</div>
	<div class="form-group">
		<label for="post_tags">Post tags</label>
		<input name="post_tags" class="form-control" type="text">
	</div>
	<div class="form-group">
		<label for="post_content">Post content</label>
		<textarea class="form-control" name="post_content" rows="5" cols="30"></textarea>
	</div>
	<div class="form-group">
		<input name="add_post" class="btn btn-primary" type="submit" value="Add post">
	</div>
</form>