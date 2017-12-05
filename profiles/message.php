<?php ob_start(); ?>
<?php session_start(); ?>
<?php include "../includes/database.php" ?>
<?php include "includes/functions.php" ?>
<?php
  if (isset($_SESSION['user_role'])) {
      if($_SESSION['user_role'] !== "subscriber"){
       header("Location: ../");
  }
}else{
     header("Location: ../");

}
$session_user_id = $_SESSION['user_id'];
$session_username = $_SESSION['username'];
if(isset($_GET['receiver_id'])){
  $receiver_id = $_GET['receiver_id'];
  ?>
  <script>
  const sessionId = <?php echo json_encode($session_user_id);?>;
  const receiverId = <?php echo json_encode($receiver_id);?>;</script>
  <?php
}else{
  ?>
  <script>const receiverId = 0;</script>
  <?php
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - programming spot</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">
<link rel="stylesheet" href="css/message.css">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body >

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
            <script type="text/javascript">
              const userImage = <?php echo json_encode($row_image['profileimage']); ?>;
            </script>
          </h1>


     </div>
     <div class="col-md-12">
     	<div class="col-md-6">
     <div class="messagedUser"><?php show_messaged_user(); ?></div>


       </div>
<div class="col-md-6 col-xs-12" >

    <div id="message">
 <?php show_message(); ?>
    </div>

     <form  class="form-message">
     <div class="form-group">
       <?php
if (isset($receiver_id)) {
$query_receiver_name = "SELECT username FROM users WHERE user_id = $receiver_id";
$querying_receiver_name = mysqli_query($connection,$query_receiver_name);
$receiver_name = mysqli_fetch_assoc($querying_receiver_name);
echo '<label for="comment">message: To '.$receiver_name['username'].' </label>';
}
 ?>
       <textarea class="form-control" rows="2" id="messageArea" placeholder="Type something....." ></textarea>
     </div>
     <div class="form-group">
     <button class="btn btn-success" id="sendMessage">send <i class="fa fa-paper-plane" aria-hidden="true"></i>
</button>
     </div>
   </form>
   </div>

 <div class="col-md-6">

 </div>
</div>


   </div>
   <!-- /.row -->

 </div>
 <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<!-- jQuery -->
<script src="js/jquery.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script>const receiverId = <?php echo json_encode($receiver_id);?>;</script>
        <script src="js/bootstrap.min.js"></script>
    <script  src="script.js"></script>


    </body>

    </html>
