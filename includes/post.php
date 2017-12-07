<?php session_start(); ?>
<?php include 'includes/database.php';
include 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>programming spot - post</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/blog-post.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
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

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <!-- Blog Post Content Column -->
            <div class="col-md-8">
                <?php if (isset($_GET['post_id'])) {
                 $query_views = "UPDATE posts SET views_count = views_count+1 WHERE post_id={$_GET['post_id']}";
                 $querying_views = mysqli_query($connection,$query_views);

                    $query = "SELECT * FROM posts WHERE post_id='{$_GET['post_id']}'";
                    $querying = mysqli_query($connection,$query);
                    while ($row = mysqli_fetch_assoc($querying)) {
                       $post_id = $row['post_id'];
                       $post_title =  $row['post_title'];
                       $post_author =  $row['post_author'];
                       $post_content =  $row['post_content'];
                       $post_image =  $row['post_image'];
                       $post_date =  $row['post_date'];
                       $post_author_id = $row['post_author_id'];
                       $views_count = $row['views_count'];
                       /* getting the profile image of this post author start */
                       $query_profile_image = "SELECT * FROM profileimage WHERE userid = $post_author_id";
                       $querying_profile_image = mysqli_query($connection,$query_profile_image);
                        /* getting the profile image of this post author start */
                       ?>
                       <!-- First Blog Post -->
                        <h2>
                        <p>
                            <?php echo $post_title; ?></p>
                    </h2> 
                    <p class="lead" style="display: inline-block;" >
                     by <a href="author_post.php?author=<?php echo $post_author; ?>&post_author_id=<?php echo $post_author_id; ?>"><?php echo $post_author; ?></a>
                    </p>
                    <a href="author.php?post_author_id=<?php echo $post_author_id; ?>">
                    <?php 
                    if(mysqli_num_rows($querying_profile_image) === 1){
                        $row_profile_image = mysqli_fetch_assoc($querying_profile_image);
                        echo '<img src="img/'.$row_profile_image['profileimage'].'" alt="" style="width: 60px; height: 60px; border-radius: 100%;">';
                    }else{
                        echo '<img src="img/profile.png" alt="" style="width: 50px; height: 50px; border-radius: 100%;">';
                    }
                    ?>
                    </a>
                    <?php 
                    if(isset($_SESSION['username'])){
                        /* showing the follow button based on the user accessing */
                        if($post_author_id == $_SESSION['user_id']){
                      echo   '<a class="btn btn-default" disabled type="button" style="margin-left: 30px;">Follow</a>';
                        }else{
echo  '<a class="btn btn-default" style="margin-left: 30px;" id="followBtn" href="vote.php?user_id='.$_SESSION['user_id'].'&friend_id='.$post_author_id.'">Follow</a>';
                        }
                    }
                    ?>
                    
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                    <h4 class='row'>
                    <span  class="col-md-3"><?php 
                    $query_followers = "SELECT user_id FROM friends WHERE friend_id={$post_author_id}";
                    $querying_followers = mysqli_query($connection,$query_followers);
                    echo mysqli_num_rows($querying_followers);
                    ?> Followers</span>
                        <span class="col-md-3"><?php echo $views_count; ?> views  </span>
                    <?php 
                    /* fetching the counts of likes and dislikes a post has*/
                   $query_likes = "SELECT * FROM vote_table WHERE post_id={$post_id} AND voting_case='like'";
                   $querying_likes = mysqli_query($connection,$query_likes);
                   $query_dislikes = "SELECT * FROM vote_table WHERE post_id={$post_id} AND voting_case='dislike'";
                   $querying_dislikes = mysqli_query($connection,$query_dislikes);
                   /* fetching the counts of likes and dislikes a post has*/
                     ?>
                    <span class='col-md-1 '  >
                        <a href="vote.php?like=like&post_id=<?php echo $post_id; ?>" id='likeBtn' >
                        <i class="fa fa-thumbs-up" aria-hidden="true"></i></a>
                       <span id="showLikes"> <?php echo mysqli_num_rows($querying_likes); ?></span>
                    </span > 
                     <span class='col-md-1 '><a href="vote.php?post_id=<?php echo $post_id; ?>&like=dislike" id='dislikeBtn'>
                     <i class="fa fa-thumbs-down" aria-hidden="true"></i></a> 
                     <span id="showDislikes"> <?php echo mysqli_num_rows($querying_dislikes); ?></span>
                    </span>
                    <?php
                        if(isset($_SESSION['username']) && $post_author == $_SESSION['username']){
                            if($_SESSION['user_role'] == 'admin'){
                                echo '<span class="col-xs-1 col-sm-1"><a href="admin/posts.php?source=edit_post&post_id='.$post_id.'"><i class="fa fa-sliders" aria-hidden="true"></i></a></span>';
                            }elseif($_SESSION['user_role'] == 'subscriber'){
                                echo '<span class="col-xs-1 col-sm-1"><a href="profiles/posts.php?source=edit_post&post_id='.$post_id.'"><i class="fa fa-sliders" aria-hidden="true"></i></a></span>';
                            }       
                        }
                    ?>
                    <span id= "alertliking" class='col-md-3'></span>
                
                </h4>
                    <hr>
                    <img class="img-responsive" src="img/<?php echo $post_image;?>" alt="POST IMAGE" style="max-width: 90%;">
                    <hr>
                    <p><?php echo $post_content; ?></p>
                    <hr>
                    <?php
                }}else{
                    header("Location: index.php");
                }

                ?>
                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <span id="alert"></span>
                    <form role="form" id="formComment"  method="POST">
                        <div class="form-group">
                            <label for="content">Your comment</label>
                            <textarea class="form-control" rows="3" name="comment_content" id="comment"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="add_comment" id="submit">submitt</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                <div  id="commentBox" >

                  </div>
                        <!-- Comment -->



                    </div>

                    <!-- Blog Sidebar Widgets Column -->
                    <div class="col-md-4">

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
             <?php show_login_form();  ?>
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
                <!-- /.row -->

                <hr>

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
            <!-- /.container -->
            <script type="text/javascript" src="comments.js"></script>
            <!-- jQuery -->
            <script src="js/jquery.js"></script>


            <!-- Bootstrap Core JavaScript -->
            <script src="js/bootstrap.min.js"></script>

        </body>

        </html> 
