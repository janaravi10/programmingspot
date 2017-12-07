<?php 
session_start();
 include 'database.php'; 
 include 'functions.php'; 
 if (isset($_POST['login'])) {
   /* function to login the user */
    $username = $_POST['username'];
    $password = $_POST['password'];
    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);
    $query_user_stmt = mysqli_prepare($connection,"SELECT * FROM users WHERE username= ?");
    /* using prepared statment*/
    mysqli_stmt_bind_param($query_user_stmt,"s",$username);
    mysqli_stmt_execute($query_user_stmt);
    mysqli_stmt_bind_result($query_user_stmt,$db_user_id,$db_username,$db_password,$db_user_firstname,$db_user_lastname,$db_user_email,$db_user_role);
    while(mysqli_stmt_fetch($query_user_stmt)){
   
    }
    $password_verify = password_verify($password,$db_password);
    if ($username === $db_username && $password_verify == true) {
      $_SESSION['username'] = $db_username;
      $_SESSION['lastname'] = $db_user_lastname;
      $_SESSION['firstname'] = $db_user_firstname;
      $_SESSION['user_role'] = $db_user_role;
     $_SESSION['user_id'] = $db_user_id;
     $_SESSION['user_email'] = $db_user_email;
       if ($db_user_role == "admin") {
         header("Location: ../admin");
       }else {
         header("Location: ../profiles");
       }
    }else{
      header("Location: ../");
    }

}elseif(isset($_POST['signUp'])){
  header("Location: ../registration.php");
}


?>
