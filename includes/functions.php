<?php
if (session_status() == PHP_SESSION_NONE) {
	/*starting session and including database when the server comes to the page directly by ajax*/
			session_start();
			include "database.php";
	}

function show_categories(){
	global $connection;
//function for selecting categories
	$query = "SELECT * FROM categories";
	$querying = mysqli_query($connection,$query);
	while ($row = mysqli_fetch_assoc($querying)) {
		$cat_title = $row['cat_title'];
		$cat_id = $row['cat_id'];
		echo "<li><a href='index.php?cat_id={$cat_id}&cat_title={$cat_title}'>{$cat_title}</a>
		</li>";
	}
}


function confirm_query_cms($result){
	global $connection;
	if(!$result){
		die(mysqli_error($connection));
	}
}

function add_comment(){
 /*function which add comments to post by ajax*/
	if (isset($_POST['add_comment'])) {
		if (isset($_SESSION['username'])) {
			global $connection;
			$post_id = $_POST['post_id'];
			$comment_author = $_SESSION['username'];
			$comment_email = $_SESSION['user_email'];
			$comment_content = $_POST['comment_content'];
			$comment_author_id = $_SESSION['user_id'];
			$comment_status = "approved";
			$comment_content = mysqli_real_escape_string($connection,$comment_content);
			if(!empty($comment_content)){
				$stmt = "INSERT INTO comments(comment_post_id,comment_author,comment_email,comment_content,comment_status,comment_date,comment_author_id)";
				$stmt .= "VALUES (?,?,?,?,?,now(),?)";
				$query_add_comment_stmt = mysqli_prepare($connection,$stmt);
				mysqli_stmt_bind_param($query_add_comment_stmt,"issssi",$post_id,$comment_author,$comment_email,$comment_content,$comment_status,$comment_author_id);
				mysqli_stmt_execute($query_add_comment_stmt);
				mysqli_stmt_error($query_add_comment_stmt);
				if($query_add_comment_stmt){
					echo "<h4 class='alertliking text-center green'>successfully comment added</h4>";
				}
				mysqli_stmt_close($query_add_comment_stmt);
			}else{
			 	echo "<h3 class ='alertliking text-center'>comment something...</h3>";
			}
		}else{
			echo "<h3 class ='alertliking text-center red'>You should login first</h3>";
		}
		

	}
}
add_comment();


function show_comments(){
	 /*function which show comments to post by ajax*/
	if(isset($_POST['p_id'])){
		global $connection;
	$p_id=$_POST['p_id'];
	$comment_stmt = "SELECT comments.comment_author,comments.comment_date,comments.comment_content,profileimage.profileimage, ";
	$comment_stmt .= "comments.comment_author_id FROM comments LEFT JOIN profileimage ON comments.comment_author_id = profileimage.userid ";
	$comment_stmt .= "WHERE comment_post_id= ?  AND comment_status='approved' ORDER BY comment_id DESC";
	
	$show_comment_query_stmt = mysqli_prepare($connection,$comment_stmt);
	mysqli_stmt_bind_param($show_comment_query_stmt,"i",$p_id);
	mysqli_stmt_execute($show_comment_query_stmt);
	mysqli_stmt_bind_result($show_comment_query_stmt,$comment_author,$comment_date,$comment_content,$profileimage,$comment_author_id);
	mysqli_stmt_store_result($show_comment_query_stmt);

	$count = mysqli_stmt_num_rows($show_comment_query_stmt);
	if ($count) {
		while (mysqli_stmt_fetch($show_comment_query_stmt)) {
			?>
<div class="media">
				<a class="pull-left" href="author.php?post_author_id=<?php echo $comment_author_id; ?>">
				<?php 
				if(!$profileimage){
					echo '<img class="media-object" style="width: 50px; height: 50px;" src="img/profile.png" alt="">';
				}else{
                     echo '<img class="media-object" style="width: 50px; height: 50px;" src="img/'.$profileimage.'" alt="">';
				}
				?>	
				</a>
				<div class="media-body">
					<h4 class="media-heading">
						<?php echo $comment_author;
						?>
						<small><?php echo $comment_date; ?></small>
					</h4>
					<?php echo $comment_content; ?>
				</div>


</div>

			<?php }
			
		}else{
				echo "<h3 style='color: orange;'>no comments</h3>";
			}
			mysqli_stmt_close($show_comment_query_stmt);
		}
}
show_comments();


function show_post(){
	//function to show post on home page
	global $connection;
	if (isset($_POST['page_real'])) {
		//for making the pager 
		$page_real = $_POST['page_real'];
	}
			if (isset($_POST['cat_id'])) {
				//checking if the user has clicked in categories and getting post related to categories
		$cat_id = $_POST['cat_id'];
		$cat_title = $_POST['cat_title'];

		$query_post_stmt = mysqli_prepare($connection,"SELECT * FROM posts WHERE post_cat_id= ? AND post_status='published' LIMIT ? , 5");
		mysqli_stmt_bind_param($query_post_stmt,"ii",$cat_id,$page_real);
		mysqli_stmt_execute($query_post_stmt);
		mysqli_stmt_bind_result($query_post_stmt,$post_id,$post_cat_id,$post_title,$post_author,$post_date,$post_image,$post_content,$post_tags,$post_comment_count,$post_status,$post_author_id,$views_count);
		mysqli_stmt_store_result($query_post_stmt);

		if (mysqli_stmt_num_rows($query_post_stmt)) {
			while (mysqli_stmt_fetch($query_post_stmt)) {
				$post_content = strip_tags($post_content,"&nbsp");
				$post_content = substr($post_content, 0, 50). "...";
				?>
				<!-- First Blog Post -->
				<h2>
						<a href="post.php?post_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
				</h2>
				<p class="lead">
						by <a href="author_post.php?author=<?php echo $post_author; ?>&post_author_id=<?php echo $post_author_id; ?>"><?php echo $post_author; ?></a>

				</p>
				<p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p><h4><?php echo $views_count."views"; ?></h4>
				<hr>
				<a href="post.php?post_id=<?php echo $post_id; ?>">
				<img class="img-responsive" src="img/<?php echo $post_image;?>"  alt="">
				</a>
				<hr>
				<p><?php echo $post_content; ?></p>
				<a class="btn btn-primary" href="post.php?post_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
				<hr>
				<?php
		}
	}else{
		 echo "empty";
	}
	mysqli_stmt_close($query_post_stmt);
}else if(isset($_POST['by'])){
	//actual loading without any categorie
	   $query_post_stmt = mysqli_prepare($connection,"SELECT * FROM posts WHERE post_status='published' LIMIT ? , 5");
	   mysqli_stmt_bind_param($query_post_stmt,"i",$page_real);
	   mysqli_stmt_execute($query_post_stmt);
	   mysqli_stmt_bind_result($query_post_stmt,$post_id,$post_cat_id,$post_title,$post_author,$post_date,$post_image,$post_content,$post_tags,$post_comment_count,$post_status,$post_author_id,$views_count);
	   mysqli_stmt_store_result($query_post_stmt);

		if (mysqli_stmt_num_rows($query_post_stmt)) {
				while (mysqli_stmt_fetch($query_post_stmt)) {
					$post_content = strip_tags($post_content,"&nbsp");
					$post_content = substr($post_content, 0, 50). "...";
						?>
						<!-- First Blog Post -->
						<h2>
								<a href="post.php?post_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
						</h2>
						<p class="lead">
								by <a href="author_post.php?author=<?php echo $post_author; ?>&post_author_id=<?php echo $post_author_id; ?>"><?php echo $post_author; ?></a>
						<p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
						<h4><?php echo $views_count; ?> views</h4>
						<hr>
						<a href="post.php?post_id=<?php echo $post_id; ?>" style='display: inline-block;'>
						<img  class="img-responsive" src="img/<?php echo $post_image;?>"  alt="">
						</a>
						<hr>
						<p><?php echo $post_content; ?></p>

						<a class="btn btn-primary" href="post.php?post_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
						<hr>
						<?php
				} }else{
                        echo "empty";
				}
				mysqli_stmt_close($query_post_stmt);
		}
}
show_post();
 
function liking()
{    if(isset($_POST['p_id_liking']) && !isset($_SESSION['username'])){
	//checking whether user has logged in
	echo "login";
}
	global $connection;
	if (isset($_SESSION['username']) && isset($_POST['p_id_liking'])) {
		//responding to user by liking or unliking
	    $username = $_SESSION['username'];
		$post_id= $_POST['p_id_liking'];
		$query_user_stmt = mysqli_prepare($connection,"SELECT voting_case FROM vote_table WHERE post_id= ? AND username = ? ");
		mysqli_stmt_bind_param($query_user_stmt,"is",$post_id,$username);
		mysqli_stmt_execute($query_user_stmt);
		mysqli_stmt_store_result($query_user_stmt);

		$vote = $_POST["like"];
		if (mysqli_stmt_num_rows($query_user_stmt) == 1) {			
			if (isset($vote)) {	
				//updating to corresponding vote
				$query_vote_stmt = mysqli_prepare($connection,"UPDATE vote_table SET voting_case = ? WHERE post_id= ? AND username = ?");
				mysqli_stmt_bind_param($query_vote_stmt,"sis",$vote,$post_id,$username);
				mysqli_stmt_execute($query_vote_stmt);
				mysqli_stmt_close($query_vote_stmt);


		}
		echo $vote;
		}else if (mysqli_stmt_num_rows($query_user_stmt) == 0) {
			//creating new info in database with insert
		    if(isset($vote)){ 	
		$query_vote_stmt = mysqli_prepare($connection,"INSERT INTO vote_table(`post_id`,`username`,`voting_case`) VALUES(?,?,?)");
		mysqli_stmt_bind_param($query_vote_stmt,"iss",$post_id,$username,$vote);
		mysqli_stmt_execute($query_vote_stmt);
		mysqli_stmt_close($query_vote_stmt);
	
		echo $vote;
		
		}
		}
		mysqli_stmt_close($query_user_stmt);

		

}
}
liking();
function count_likes() 
{
	/*this function count how many like a post has*/
	global $connection;
	
	
	if(isset($_POST["p_id_likes_count"])){
		$post_id = $_POST["p_id_likes_count"];
		$query_likes_stmt = mysqli_prepare($connection,"SELECT id FROM vote_table WHERE post_id= ? AND voting_case=?");
	}

	if(isset($_POST["count_likes"])){		
		//counting the number of like a post has
		mysqli_stmt_bind_param($query_likes_stmt,"is",$post_id,$_POST["count_likes"]);
		mysqli_stmt_execute($query_likes_stmt);
		mysqli_stmt_store_result($query_likes_stmt);
	    echo mysqli_stmt_num_rows($query_likes_stmt);
	    mysqli_stmt_close($query_likes_stmt);
}
if(isset($_POST["count_dislikes"])){
	//counting the number of dislike a post has
     	mysqli_stmt_bind_param($query_likes_stmt,"is",$post_id,$_POST["count_dislikes"]);
		mysqli_stmt_execute($query_likes_stmt);
		mysqli_stmt_store_result($query_likes_stmt);
    	echo mysqli_stmt_num_rows($query_likes_stmt);
	    mysqli_stmt_close($query_likes_stmt);
}
}
count_likes();
function like_info()
{
	global $connection;
	//checking the database whether the user like the post or not
	if(isset($_POST['p_id_like_info']) && isset($_SESSION['username'])){
	$username = $_SESSION['username'];
	$post_id = $_POST['p_id_like_info'];
$query_likes_info = "SELECT voting_case FROM vote_table WHERE post_id={$post_id} AND username='{$username}'";
$querying_like_info= mysqli_query($connection,$query_likes_info);
	 $row = mysqli_fetch_array($querying_like_info);
	 echo $row['voting_case'];
}
}
like_info();

function follow(){
	global $connection;
	if(isset($_POST['user_id']) && isset($_POST['friend_id'])){
		$user_id = $_POST['user_id'];
		$friend_id = $_POST['friend_id'];
		$query_check_friend = "SELECT friend_id FROM friends WHERE user_id={$user_id}";
		$querying_check_friend = mysqli_query($connection,$query_check_friend);
		$follow = false;
		//fetching the database to see if user already given friend request
		while($row=mysqli_fetch_array($querying_check_friend)){
			if($row['friend_id'] == $friend_id){
				$follow = true;
				break;
			  }else{
				$follow = false;
			  }
		}
		//following friend by adding to database
		if(!$follow == true && !isset($_POST['following_check']) && isset($_POST['follow'])){
			$query_request ="INSERT INTO friends(user_id,friend_id,request_state) VALUES('{$user_id}','{$friend_id}',0)";
			$querying_request = mysqli_query($connection,$query_request);
			echo "You following";
			if(!$querying_request){
				die(mysqli_error($connection));
			}
		}
		//unfollowing by deleting records
		if(isset($_POST['unfollow'])){
	$query_unfollow = "DELETE FROM friends WHERE friend_id={$friend_id} && user_id={$user_id}";
	$querying_unfollow = mysqli_query($connection,$query_unfollow);
	echo "unfollowed";
		}
	}
}
follow();
function follow_check(){

	global $connection;
	if(isset($_POST['following_check']) && $_POST['following_check'] == true){
		$user_id = $_POST['user_id'];
		$friend_id = $_POST['friend_id'];
		$query_check_friend = "SELECT friend_id FROM friends WHERE user_id={$user_id}";
		$querying_check_friend = mysqli_query($connection,$query_check_friend);
		$follow = false;
		//fetching the database to see if user already given friend request
		while($row=mysqli_fetch_array($querying_check_friend)){
			if($row['friend_id'] == $friend_id){
				echo "You following";
				$follow = true;
				break;
			  }else{
				$follow = false;
			  }
		}
	}
}
follow_check();
function show_login_form(){
	/*this for showing login for when user not logged in */
	 if (!isset($_SESSION['user_role'])) {
						 ?>
						<div class="well">
							<div class="input-group" id="loginGroup">
							  <h4 >Login</h4>
								<form action="includes/login.php" method="post" class="form-group" id="loginform">
									<label for="username">Username  <input name="username" id="username" placeholder="Username" type="text" class="form-control"></label>
		
		
								   <label for="password">Password <input name="password" id="password" placeholder="Password" type="password" class="form-control"></label>
		
		
									<button  name="login" class="btn btn-default" type="submit" id="login">Login
									</button>
									<b>or</b>
									<a href="registration.php">create new account</a>
									<div id="validateBox"></div>
								</form>
							</div>
							
						</div>
						<?php } 
}
?>
