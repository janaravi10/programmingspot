<?php  include "includes/database.php"; 

include "includes/header.php";

 include 'includes/functions.php';

 include "includes/navigation.php"; 

  /* function to change the password of user who request to change in forgot password page start */  
 change_forgot_password();
  /* function to change the password of user who request to change in forgot password page  end*/  


  /* verifing new user who is registerder for account start */
 if(isset($_GET['token']) && isset($_GET['email'])){

     $email = $_GET['email'];

     $token = $_GET['token'];

     $email = mysqli_real_escape_string($connection,$email);

   $verification_status = 0;

     $verify_registration_stmt = mysqli_prepare($connection,"SELECT email,token,username,password FROM verification WHERE email = ? AND verification_status = ?");

     mysqli_stmt_bind_param($verify_registration_stmt,"si",$email,$verification_status);

     mysqli_stmt_execute($verify_registration_stmt);

     mysqli_stmt_bind_result($verify_registration_stmt,$db_email,$db_token,$db_username,$db_password);

    mysqli_stmt_store_result($verify_registration_stmt);

    if(mysqli_stmt_num_rows($verify_registration_stmt)){

        while(mysqli_stmt_fetch($verify_registration_stmt)){

            

        }

        if($email == $db_email && $token == $db_token){
/* checking whether email and token from database is equal with the link email and token */
            $query_insert_user = "INSERT INTO users(username,password,user_email,user_role) VALUES('$db_username','$db_password','$db_email','subscriber')";

             $querying_insert_user = mysqli_query($connection,$query_insert_user);
             if(!$querying_insert_user){
             	die(mysqli_error($connection));
             }
             /* deleting the record in verification tabel after verifiction process is done */

             $update_verification_status = "UPDATE verification SET verification_status = 1";

             $update_verification_status_querying = mysqli_query($connection,$update_verification_status);

             $delete_verification_record = "DELETE FROM verification WHERE verification_status = 1";

             $delete_verification_record_querying = mysqli_query($connection,$delete_verification_record);

           ?>



<div class="container">

<div class="row">

<div class="col-md-12">

<h4 class='alert alert-success'>

Thank you, your account has been verified..

</h4>

<a href="index.php">login here</a>

</div>

</div>

</div>

<?php 

        }else{

            echo "not working";

        }

    }
/* end of the new user verification code */
 }



/* code to  delete the account of user who wish to delete the account start*/

 if(isset($_GET['delete_account']) && isset($_SESSION['username'])){

     $session_user_id = $_SESSION['user_id'];

     $session_username = $_SESSION['username'];


/* selecting userimage from databse */
    $select_user_post_image = "SELECT post_image FROM posts WHERE post_author_id = $session_user_id";

    $select_user_post_image_query = mysqli_query($connection,$select_user_post_image);



    while($row_image = mysqli_fetch_assoc($select_user_post_image_query)){
/* deleteing the user photos */
       $post_image_path ="img/".$row_image['post_image'];

        unlink($post_image_path);

    }

    /* delteing the user post */
    $delete_user_post = "DELETE FROM posts WHERE post_author_id=$session_user_id ";

    $delete_user_post_querying = mysqli_query($connection,$delete_user_post);

    
/* deleting the comments related to this user */
    $delete_user_comments = "DELETE FROM comments WHERE comment_author_id = $session_user_id";

    $delete_user_comments_querying = mysqli_query($connection,$delete_user_comments);


/* deleting the information about like and dislikes */
    $delete_user_votes = "DELETE FROM vote_table WHERE username = '$session_username'";

    $delete_user_votes_querying = mysqli_query($connection,$delete_user_votes);


/* deleting user profile image*/ 
    $delete_user_profile_image = "DELETE FROM profileimage WHERE userid = $session_user_id";

    $delete_user_profile_image_querying = mysqli_query($connection,$delete_user_profile_image);

 

        $profile_img_name = "img/profile".$session_user_id."*";

        $profile_img = glob($profile_img_name);

        foreach ($filename as $key => $value) {

            unlink($value);

        }


/* deleteing any follow and following information */
     $delete_follow_info = "DELETE FROM friends WHERE user_id = $session_user_id OR friend_id = $session_user_id";

     $delete_follow_info_querying = mysqli_query($connection,$delete_follow_info);

    
/* atlast deleting user from users table */
     $delete_user = "DELETE FROM users WHERE user_id = $session_user_id AND username = '$session_username' ";

     $delete_user_querying = mysqli_query($connection,$delete_user);

     if(!$delete_user_querying){

         die(mysqli_error($connection));

     }

    //  echo '<h2 class="alert alert-success">success </h2>';
/* logging him out */
    $_SESSION = array();

    session_destroy();

    header("Location: index.php");

/* code to  delete the account of user who wish to delete the account end*/

 }

 

 

 include "includes/footer.php"



?>