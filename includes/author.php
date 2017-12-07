<?php session_start();
include 'includes/functions.php';
include 'includes/database.php';
 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>profile of author</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/blog-post.css" rel="stylesheet">
    <link href="admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
   <!-- Navigation -->
   <?php include 'includes/navigation.php'; ?>
 <!-- Navigation end -->
 <!-- content -->
 <div class="container">
 <div class="row">
<div class="col-md-6">
                    <?php
                    /* fetching user info with the help of user id*/
                    if(isset($_GET['post_author_id'])){
                        $post_author_id = $_GET['post_author_id'];
                    $query_author = "SELECT * FROM users WHERE user_id={$post_author_id}";
                    $querying_author = mysqli_query($connection,$query_author);
                    $row = mysqli_fetch_array($querying_author);
                    if($row['user_firstname'] == ''){
                        $row['user_firstname'] = "Not provided.";
                    }
                    if($row['user_lastname'] == ''){
                        $row['user_lastname'] = "Not provided.";
                    }
                    }
                     /* get the followers information*/
                $query_followers = "SELECT user_id FROM friends WHERE friend_id={$post_author_id}";
                $querying_followers = mysqli_query($connection,$query_followers);
                $count_followers  = mysqli_num_rows($querying_followers);
                /* get the following information*/
                $query_following = "SELECT user_id FROM friends WHERE user_id = {$post_author_id}";
                $querying_following = mysqli_query($connection,$query_following);
                $count_following = mysqli_num_rows($querying_following);
                //getting profile image of user
                $query_profile_image = "SELECT * FROM profileimage WHERE userid =$post_author_id";
                $querying_profile_image = mysqli_query($connection,$query_profile_image);
                    ?>
                <?php
                if(mysqli_num_rows($querying_profile_image) === 1){
                    $row_profile_image = mysqli_fetch_assoc($querying_profile_image);
                    echo '<img src="img/'.$row_profile_image['profileimage'].'" alt="" style="width:200px; height:180px; float: none;" class="col-sm-12 center-block">';
                }else{
                    echo '<img src="img/profile.png" alt="" style="width:200px; height:180px; float: none;" class="col-sm-12 center-block">';
                }
                ?>
                <h3 class="text-center"><?php echo $row['username'];
                if(isset($_SESSION['user_role'])){
                   if($_SESSION['user_role'] == "subscriber"){
                  echo  '<a href="profiles/message.php?receiver_id='.$_GET['post_author_id'].'" class="btn-default"><i class="fa fa-comments" aria-hidden="true"></i></a>';
                   }else{
                    echo  '<a href="admin/message.php?receiver_id='.$_GET['post_author_id'].'" class="btn-default"><i class="fa fa-comments" aria-hidden="true"></i></a>';
                   }
                }else{
                    echo  '<a href="" class="btn-default"><i class="fa fa-comments" aria-hidden="true"></i></a>';
                }
                
                ?>  </h3>

                <ul class="list-group">
                <li class="list-group-item">
                <h4 style="display: inline"><?php echo $row['user_firstname']; ?>
</h4>
                  <span class="badge">Firstname</span>
                </li>
                <li class="list-group-item">
                <span class="badge">lastname</span>
                <h4 style="display: inline"><?php echo $row['user_lastname']; ?></h4>

                </li>
                <li class="list-group-item">
                <h4 style="display: inline"><?php echo $row['user_email']; ?></h4>
                  <span class="badge">email id</span>
                </li>
                <li class="list-group-item">
                <h4 style="display: inline">followers<span class="badge"><?php echo $count_followers; ?></span></h4>
                </li>
                <li class="list-group-item">
                <h4 style="display: inline">following<span class="badge"><?php echo $count_following; ?></span></h4>
                </li>
              </ul>

</div>
<div class="col-md-4" style="float: right;">

                        <!-- Blog Search Well -->
                   <div class="well">
                    <h4>Blog Search</h4>
                    <form action="search.php" method="post">
                    <div class="input-group">
                            <input name="input" type="text" class="form-control">
                            <span class="input-group-btn">
                                <button  name="submit" class="btn btn-default" type="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                    </div>
                     </form>
                    <!-- /.input-group -->
                </div>
           <!-- login form -->
           <?php show_login_form(); ?>
                <!-- login form end -->

                        <!-- Blog Categories Well -->
                        <div class="well">
                            <h4>Blog Categories</h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <ul class="list-unstyled">
                                        <?php show_categories(); ?>
                                    </ul>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>

                        <!-- Side Widget Well -->
                        <div class="well">
                            <h4>Side Widget Well</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                        </div>

                    </div>


                </div>

                <!-- Footer -->
                <footer>
                    <div class="row">
                        <div class="col-lg-12">
                            <p>Copyright &copy; Janaravi.com 2017-2018</p>
                            <a href="contact.php">contact me</a>
                        </div>
                    </div>
                    <!-- /.row -->
                </footer>
</div>
<!-- content -->
<script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
   </body>
   </html>
