<?php if (session_status() == PHP_SESSION_NONE) {
			session_start();
			include "../../includes/database.php";
      $session_username = $_SESSION['username'];
	}

  ?>
<div id="tableWrapper">
   <form action="" method="post" id="bulkOptionForm">
 	<table class="table table-bordered table-hover">
 		<div class="row">
      <div class="col-xs-4" >
 			<select class="form-control" id="selectField">
 				<option value="">select option</option>
 				<option value="published">publish</option>
 				<option value="draft">draft</option>
 				<option value="delete">delete</option>
 				<option value="clone">clone</option>
 			</select>
 		</div>
 		<div class="col-xs-4">
 			<input type="submit" class="btn btn-success" name="apply" value="apply" id="submitbtn">
 			<a href="posts.php?source=add_post" class="btn btn-info">add new</a>
 		</div>
 	</div>
 	<hr>
 	<thead>
 		<tr>
 			<th><input type="checkbox" name="" id="cbx"></th>
 			<th>Id</th>
 			<th>Author</th>
 			<th>Title</th>
 			<th>Category</th>
 			<th>Image</th>
 			<th>Tags</th>
 			<th>Comments</th>
 			<th>Status</th>
 			<th>Date</th>
 			<th>view post</th>
 			<th>Edit</th>
 			<th>Delete</th>
 		</tr>
 	</thead>
 	<tbody>
    <?php
 		$query = "SELECT * FROM posts WHERE post_author_id={$_SESSION['user_id']} ORDER BY post_id DESC";
 		$querying = mysqli_query($connection,$query);
 		while ($row = mysqli_fetch_assoc($querying)) {
 			$post_id = $row['post_id'];
 			$post_title = $row['post_title'];
 			$post_author = $row['post_author'];
 			$post_status = $row['post_status'];
 			$post_tags = $row['post_tags'];
 			$post_image = $row['post_image'];
 			$post_cat_id = $row['post_cat_id'];
 			$post_date = $row['post_date'];
 			echo "<tr>";
 			?>
 			<td>
 				<input type="checkbox" class="cbxs checkboxes" value="<?php echo $post_id; ?>"
 				name ="checkboxes[]" ></td>
 				<?php
 				echo "<td>{$post_id}</td>";
 				echo "<td>{$post_author}</td>";
 				echo "<td>{$post_title}</td>";
 				$query_cat = "SELECT * FROM categories WHERE cat_id = '{$post_cat_id}'";
 				$querying_cat= mysqli_query($connection,$query_cat);
        // LOOPING THROUGH THE DATA
 				while ($row = mysqli_fetch_assoc($querying_cat)) {
 					$cat_id = $row['cat_id'];
 					$cat_title = $row['cat_title'];
 					echo "<td>{$cat_title}</td>";
 				}
 				echo "<td><img style ='width:100px; height:50px;' src='../img/$post_image'></td>";
 				echo "<td>{$post_tags}</td>";
        $query_comment_count = "SELECT comment_post_id FROM comments WHERE comment_post_id = {$post_id}";
        $querying_comment_count = mysqli_query($connection,$query_comment_count);
        $comment_count = mysqli_num_rows($querying_comment_count);
 				echo "<td>{$comment_count}</td>";
 				echo "<td>{$post_status}</td>";
 				echo "<td>{$post_date}</td>";
 				echo "<td><a href='../post.php?post_id={$post_id}' class='btn btn-success'>view</a>";
 				echo "<td><a href='posts.php?source=edit_post&post_id={$post_id}' class='btn btn-info'>Edit</a></td>";
 				echo "<td><a  href='posts.php?del_post={$post_id}' class='btn btn-danger delPost'>Delete</a></td>";
 				echo "</tr>";
 			}
 			?>
 		</tbody>
 	</table>
 </form>
</div>
