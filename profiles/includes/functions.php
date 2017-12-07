<?php
if (session_status() == PHP_SESSION_NONE) {
			session_start();
			include "../../includes/database.php";
	}
function confirm_query($result){
  global $connection;
  if(!$result){
    die(mysqli_error($connection));
  }
}
function delete_comment(){
  global $connection;
  if (isset($_POST['del_comment'])) {
    $delete_comment_id  = $_POST['del_comment'];
    $comment_post_id = $_POST['com_post_id'];
    $delete_comment_query = "DELETE FROM comments WHERE comment_id = {$delete_comment_id}";
    $delete_comment_querying = mysqli_query($connection,$delete_comment_query);
 }
 if (isset($_POST['a'])) {
    $approve_comment_id  = $_POST['a'];
    $approve_comment_query = "UPDATE comments SET comment_status='approved' WHERE comment_id = {$approve_comment_id}";
    $approve_comment_querying = mysqli_query($connection,$approve_comment_query);
}
 if (isset($_POST['ua'])) {
    $unapprove_comment_id  = $_POST['ua'];
    $unapprove_comment_query = "UPDATE comments SET comment_status='unapproved' WHERE comment_id = {$unapprove_comment_id}";
    $unapprove_comment_querying = mysqli_query($connection,$unapprove_comment_query);
 }
}
delete_comment();
function users_online(){
global $connection;
$session = session_id();
$time = time();
$time_out_seconds = 60;
$time_out = $time - $time_out_seconds;
$query_users_online = "SELECT * FROM users_online WHERE session = '{$session}'";
$querying_users_online = mysqli_query($connection, $query_users_online);
$count = mysqli_fetch_assoc($querying_users_online);
if ($count == NULL) {
    $insert_users_online = "INSERT INTO users_online(session,time) VALUES('{$session}','{$time}')";
    $querying_insert_users = mysqli_query($connection,$insert_users_online);
}else{
    $query_users_update_online = "UPDATE users_online SET time = '{$time}' WHERE session = '{$session}'";
    $querying_users_update_online = mysqli_query($connection,$query_users_update_online);
}
$useronline_query = "SELECT * FROM users_online WHERE time > {$time_out} ";
$useronline_querying = mysqli_query($connection,$useronline_query);
 return $count_rows = mysqli_num_rows($useronline_querying);
}
function change_password(){
  global $connection;
  if (isset($_POST['change_password'])) {
      $old_password = $_POST['old_password'];
      $new_password = $_POST['new_password'];
      if (!empty($old_password) && !empty($new_password)) {
      $old_password = mysqli_real_escape_string($connection,$old_password);
      $new_password = mysqli_real_escape_string($connection,$new_password);
      $query_old_password = "SELECT password FROM users WHERE user_id = {$_SESSION['user_id']}";
      $querying_old_password = mysqli_query($connection,$query_old_password);
      $row = mysqli_fetch_assoc($querying_old_password);
      $db_password = $row['password'];
      $password_verify = password_verify($old_password,$db_password);
      if ($password_verify) {
        $hash = password_hash($new_password,PASSWORD_DEFAULT,['cost'=>9]);
        $query_new_password ="UPDATE users SET password = '{$hash}' WHERE user_id={$_SESSION['user_id']}";
        $querying_new_password = mysqli_query($connection,$query_new_password);
        echo "<h4> Password has been changed successfully!</h4>";
      }else{
        echo "<h4> Enter correct password </h4> ";
      }
    }else{
        echo "<h4> Enter Your password </h4> ";
    }
  }
}
change_password();
function update_profile(){
	global $connection;

	if(isset($_POST['update_profile'])){
		$username = $_POST['username'];
	  $username = mysqli_real_escape_string($connection,$username);
	  $user_firstname = $_POST['user_firstname'];
		$user_lastname = $_POST['user_lastname'];
		$user_email = $_POST['user_email'];
		$query_update_user = "UPDATE users SET username='{$username}',user_firstname='{$user_firstname}',user_lastname='{$user_lastname}'";
		$query_update_user .= ",user_email='{$user_email}' WHERE user_id = '{$_SESSION['user_id']}'" ;
	 	$querying_update_user = mysqli_query($connection,$query_update_user);
		if (!$querying_update_user) {
		die("error".mysqli_error($connection));
		}
	  }
}
update_profile();
function comment_status(){
	global $connection;
	if (isset($_POST['status'])) {
		$query_comments = "SELECT comment_status FROM comments WHERE comment_author='{$_SESSION['username']}'";
    $querying_comments = mysqli_query($connection,$query_comments);
		?>
		<script type="text/javascript" class="script">
		var statusArray = [];
		</script>
		<?php
		$i = 0;
	while ($row = mysqli_fetch_assoc($querying_comments)) {
	     ?><script type="text/javascript" class='script'>
			 	statusArray[<?php echo $i;?>] = '<?php echo $row['comment_status']; ?>';
			 </script>
			 <?php
			$i++;
	}
	}
}
comment_status();
function check_username_availability(){
global $connection;
if (isset($_POST['check_username'])) {
	$username = $_POST['check_username'];
	$username = mysqli_real_escape_string($connection,$username);
	if($_SESSION['username'] != $username){
	$check_username_query = "SELECT username FROM users WHERE username = '{$username}'";
	$check_username_querying = mysqli_query($connection,$check_username_query);
	$count = mysqli_num_rows($check_username_querying);
   if (!$count) {
		echo "username available";
	}else {
		echo "username is already exist";
	}
}else{
	echo "username available";
}

};
};
check_username_availability();
function del_post()
{
global $connection;
if (isset($_POST['del_post'])) {
 $delete_post_id  = $_POST['del_post'];
 $delete_post_query = "DELETE FROM posts WHERE post_id = {$delete_post_id}";
 $delete_post_querying = mysqli_query($connection,$delete_post_query);
 $delete_post_comment_query = "DELETE FROM comments WHERE comment_post_id = {$delete_post_id}";
 $delete_post_comment_querying = mysqli_query($connection,$delete_post_comment_query);
 confirm_query($delete_post_querying);
}
}
del_post();
function add_bulk_option(){
	global $connection;
	if (isset($_POST['checkboxes'])) {
		$checkboxes = json_decode($_POST['checkboxes']);
    $bulk_option = $_POST['bulk_option'];
  	foreach ($checkboxes as $checkboxvalue) {
			if (!$checkboxvalue == null) {
  		if ($bulk_option =="delete") {
  			$delete_post_query = "DELETE FROM posts WHERE post_id = {$checkboxvalue}";
  			$delete_post_querying = mysqli_query($connection,$delete_post_query);
  			$delete_post_comment_query = "DELETE FROM comments WHERE comment_post_id = {$checkboxvalue}";
  			$delete_post_comment_querying = mysqli_query($connection,$delete_post_comment_query);

  		}else if($bulk_option =="clone"){
  			$query = "SELECT * FROM posts WHERE post_id= {$checkboxvalue}";
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
  			$post_content = $row['post_content'];
  			$post_author_id = $row['post_author_id'];
  		}
  		$query = "INSERT INTO posts(post_cat_id,post_title,post_author,post_date,post_image,post_content,post_tags,post_status,post_author_id)";
 	$query .= "VALUES({$post_cat_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}',$post_author_id)";
 	$querying = mysqli_query($connection,$query);
 	confirm_query($querying);
  		}else if($bulk_option ==''){
      }else{
      	$query_update = "UPDATE posts SET post_status = '{$bulk_option}' WHERE post_id={$checkboxvalue}";
  			$querying_update = mysqli_query($connection,$query_update);
  		}

  	}
	}
  }
}
add_bulk_option();
function upload_profile_img(){
	global $connection;
	if(isset($_POST['upload'])){
		$profileimg = $_FILES['profileimg'];
		$image_type = $profileimg['type'];
		$image_size = $profileimg['size'];
		$image_tmp_name = $profileimg['tmp_name'];
		$image_type = explode("/",$image_type);
		$actual_extension = strtolower(end($image_type));
		$allowed_extension = array("jpg","jpeg","png");
		if(in_array($actual_extension,$allowed_extension)){
            if($image_size < 2048000){
							$user_id = $_SESSION['user_id'];
						  $check_profile_image_query = "SELECT * FROM profileimage WHERE userid= {$user_id}";
							$check_profile_image_querying = mysqli_query($connection,$check_profile_image_query);
							$image_name_to_db = "profile".$user_id.".".$actual_extension;
					if(mysqli_num_rows($check_profile_image_querying) === 1){
					$upload_profile_img_query ="UPDATE profileimage SET userid={$user_id}, profileimage='$image_name_to_db', status=1 WHERE userid={$user_id}";
						$upload_profile_img_querying = mysqli_query($connection,$upload_profile_img_query);
					}else{
						$upload_profile_img_query ="INSERT INTO  profileimage(userid,profileimage,status) VALUES($user_id,'$image_name_to_db',1)";
						$upload_profile_img_querying = mysqli_query($connection,$upload_profile_img_query);
					}
							move_uploaded_file($image_tmp_name,"../img/profile".$user_id.".".$actual_extension);
						}else{
							echo "image size is too big";
						}
		}else{
			echo "file is note allowed";
		}
}
}



function send_message()
{
	global $connection;
  if(isset($_POST['receiver_id']) && isset($_SESSION['user_id']) && isset($_POST['message_content'])){
		 $sender_id = $_SESSION['user_id'];
		 $receiver_id = $_POST['receiver_id'];
		 $receiver_id = mysqli_real_escape_string($connection,$receiver_id);
		 $message_content = $_POST['message_content'];
		 $flag = 1;
    if(!empty($message_content)){
			$query_receiver_check = "SELECT user_id FROM users WHERE user_id = $receiver_id";
			$querying_receiver_check = mysqli_query($connection,$query_receiver_check);
			$check_receiver = mysqli_num_rows($querying_receiver_check);
			if($check_receiver !== 0){
			$stmt = "INSERT INTO message(sender_id,receiver_id,message,flag) VALUES(?,?,?,?)";
			$query_message_stmt = mysqli_prepare($connection,$stmt);
			mysqli_stmt_bind_param($query_message_stmt,"iisi",$sender_id,$receiver_id,$message_content,$flag);
			mysqli_stmt_execute($query_message_stmt);
			mysqli_stmt_error($query_message_stmt);
			mysqli_stmt_close($query_message_stmt);
			echo "done";
		}else{
			echo "receiver id is invalid";
		}
		}else{
			echo "No content";
		}


	}
}
send_message();

function show_message()
{
	global $row_image;
	 global $connection;
	 if((isset($_GET['receiver_id']) && isset($_SESSION['user_id']))){
		 $sender_id = $_SESSION['user_id'];
		 $receiver_id = $_GET['receiver_id'];

		
	 $query_show_message = "SELECT * FROM message  WHERE (sender_id = $sender_id AND receiver_id = $receiver_id) ";
	 $query_show_message .= "OR (sender_id = $receiver_id AND receiver_id = $sender_id)";


	 $querying_show_message = mysqli_query($connection,$query_show_message);
if (!$querying_show_message) {
	die(mysqli_error($connection));
}
	 while($row_message = mysqli_fetch_assoc($querying_show_message)){

		if($row_message['sender_id'] == $sender_id){
			echo  '<div class="chat self">
			<img src="../img/'.$row_image['profileimage'].'" class="user-photo" alt=""">
			<div class="chat-message">'.$row_message['message'].'</div>
			</div>';

		}else{
			$query_user_image = "SELECT profileimage FROM profileimage WHERE userid = $receiver_id";
			$querying_user_image = mysqli_query($connection,$query_user_image);
			$row_user_image = mysqli_fetch_assoc($querying_user_image);
			echo  '<div class="chat friend">
			<img src="../img/'.$row_user_image['profileimage'].'" class="user-photo" alt=""">
			<div class="chat-message">'.$row_message['message'].'</div>
			</div>';

		}

	 }

 }else{
	 echo "<h5 class='chat message'>please click some users</h5>";
 }
}


function show_messaged_user()
{
	if(isset($_SESSION['user_id'])){
	global $connection;

	$my_id = $_SESSION['user_id'];

	$select_profile = "SELECT * FROM users WHERE (user_id) IN (SELECT receiver_id FROM message WHERE sender_id = $my_id) ";
	$select_profile .= "OR (user_id) IN (SELECT sender_id FROM message WHERE receiver_id = $my_id) ";

	$select_profile_querying = mysqli_query($connection,$select_profile);
	if(!$select_profile_querying){
		die(mysqli_error($connection));
	}
	while($row = mysqli_fetch_assoc($select_profile_querying)){
		$query_user_image = "SELECT profileimage FROM profileimage WHERE userid = '{$row['user_id']}'";
		$querying_user_image = mysqli_query($connection,$query_user_image);
		$row_user_image = mysqli_fetch_assoc($querying_user_image);
		if(indicate_messages()){
   echo ' <div class="chat messaged">
	 <img src="../img/'.$row_user_image['profileimage'].'" class="user-photo" alt=""">
<a href="message.php?receiver_id='.$row['user_id'].'" class="messagedUserLink">
	 <div class="chat-message ">'.$row['username'] .'<span class="indicate">'.indicate_messages().'</span></div></a>
	 </div>';
	}else{
		echo ' <div class="chat messaged">
		<img src="../img/'.$row_user_image['profileimage'].'" class="user-photo" alt=""">
 <a href="message.php?receiver_id='.$row['user_id'].'" class="messagedUserLink">
		<div class="chat-message ">'.$row['username'].'</div></a>
		</div>';
	}
}

}
}

function indicate_messages()
{
	
	global $connection;
	$user_id = $_SESSION['user_id'];
	$query_indicate_message = "SELECT sender_id FROM message WHERE flag = 1 AND receiver_id = $user_id";
	$querying_indicate_message = mysqli_query($connection,$query_indicate_message);
	$count = mysqli_num_rows($querying_indicate_message);
	if($count){
	return $count;
	}
}
function update_message_indication()
{
	if(isset($_GET['receiver_id'])){
	$sender_id = $_SESSION['user_id'];
	$receiver_id = $_GET['receiver_id'];
global $connection;
$query_indicate_message_null = "UPDATE message SET flag = 0 WHERE receiver_id = $sender_id AND sender_id = $receiver_id";
$querying_indicate_message_null = mysqli_query($connection,$query_indicate_message_null);
if (!$querying_indicate_message_null) {
   die(mysqli_error($connection));
}
	}
}

?>
