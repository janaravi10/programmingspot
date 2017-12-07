
<?php if(isset($_POST['update_post'])){
	/*codes to edit the post and update */
	$post_title = $_POST['post_title'];
	$post_author = $_SESSION['username'];
	$post_cat_id = $_POST['post_cat_id'];
	$post_status = $_POST['post_status'];	
	$post_tags = $_POST['post_tags'];
	$post_content = $_POST['post_content'];
	$post_comment_count = 4;
	$post_title =  mysqli_real_escape_string($connection,$post_title);
	$post_tags = mysqli_real_escape_string($connection,$post_tags);
	$post_content = mysqli_real_escape_string($connection,$post_content);


	$post_image = $_FILES['post_image'];
	$image_type = $post_image['type'];
	$image_size = $post_image['size'];
	$image_tmp_name = $post_image['tmp_name'];
	$image_type = explode("/",$image_type);
	$actual_extension = strtolower(end($image_type));
	$allowed_extension = array("jpg","jpeg","png");
	if(!empty($post_image['name'])){
	if(in_array($actual_extension,$allowed_extension)){
		if($image_size < 2048000){
			$image_name_to_db = "post".$_GET['post_id'].".".$actual_extension;
			$query_update_stmt = "UPDATE posts SET post_title = ?,post_author= ?,post_image=?,post_content=?";
			$query_update_stmt .=",post_tags=? ,post_comment_count=? ,post_status=? ,post_cat_id=? WHERE post_id=?";
			$query_prepare_stmt = mysqli_prepare($connection,$query_update_stmt);
			mysqli_stmt_bind_param($query_prepare_stmt,"sssssisii",$post_title,$post_author,$image_name_to_db,$post_content,$post_tags,$post_comment_count,$post_status,$post_cat_id,$_GET['post_id']);
			mysqli_stmt_execute($query_prepare_stmt);
			mysqli_stmt_error($query_prepare_stmt);
			mysqli_stmt_close($query_prepare_stmt);

			move_uploaded_file($image_tmp_name,"../img/post".$_GET['post_id'].".".$actual_extension);
			
	         header("Location: ./posts.php?source=all_post");
		}else{
			echo "<h4 class='alert alert-danger text-center'>image size is too big</h4>";
		}
}else{
echo "<h4 class='alert alert-danger text-center'>file is note allowed </h4>";
}
	}else{
		echo "<h4 class='alert alert-danger text-center'>No file selected...</h4>";
		
	}

}
?>
<?php if (isset($_GET['post_id'])) {
	/*codes to  show the post which we want to update */
	$post_id = $_GET['post_id'];
	$query = "SELECT * FROM posts WHERE post_id = {$post_id}";
	$querying = mysqli_query($connection,$query);
	confirm_query($querying);
	while ($rows = mysqli_fetch_assoc($querying)) {
		$post_title = $rows['post_title'];
		$post_cat_id = $rows['post_cat_id'];
		$post_author = $rows['post_author'];
		$post_status = $rows['post_status'];
		$post_tags = $rows['post_tags'];
		$post_content = $rows['post_content'];
		$post_image = $rows['post_image'];

		?>

		<form method="post" action="" enctype="multipart/form-data" class="col-md-6">
			<div class="form-group">
				<label for="title">Post title</label>
				<input name="post_title" class="form-control" type="text" value="<?php echo $post_title; ?>">
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
				 <p><?php echo $post_author; ?></p>
			</div>

			<div class="form-group">
				<select name="post_status" id="">
					<option value="<?php echo $post_status;?>"><?php echo $post_status;?></option>
					<?php if ($post_status =='draft') {
						echo "<option value='published'>published</option>";
					}else{
						echo "<option value='draft'>draft</option>";
					} ?>
				</select>
			</div>

			<div class="form-group">
				<label for="post_image">Post image</label>
				<img width="100" height="50" class="img-thumbnail" src="../img/<?php echo $post_image; ?>" alt="">
				<input name="post_image"  type="file" style="background-color: 'green';">
			</div>
			<div class="form-group">
				<label for="post_tags">Post tags</label>
				<input name="post_tags" class="form-control" type="text" value="<?php echo $post_tags; ?>">
			</div>
			<div class="form-group">
				<label for="post_content">Post content</label>
				<textarea class="form-control" name="post_content" rows="5" cols="30"><?php echo $post_content; ?></textarea>
			</div>
			<div class="form-group">
				<input name="update_post" class="btn btn-primary" type="submit" value="update post">
			</div>
		</form>

		<?php
	}
} ?>
