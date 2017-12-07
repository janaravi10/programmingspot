<?php session_start(); ?>
<?php include 'includes/database.php';
include 'includes/functions.php';
include 'admin/includes/functions.php';
?>
<!DOCTYPE html>  
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>author related post</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/blog-post.css" rel="stylesheet">

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
            <?php $post_author = $_GET['author']; ?>
                <h1 class="page-header">
                    Post made by
                    <small><?php echo $post_author; ?></small>
                </h1>
                <?php if (isset($_GET['author'])) {
     /* this will show author post if author is set*/
                    $post_author_id = $_GET['post_author_id'];
                    $query = "SELECT * FROM posts WHERE post_author_id={$post_author_id}";
                    $querying = mysqli_query($connection,$query);
                    while ($row = mysqli_fetch_assoc($querying)) {
                        $post_id = $row['post_id'];
                       $post_title =  $row['post_title'];
                       $post_author =  $row['post_author'];
                       $post_content =  $row['post_content'];
                       $post_image =  $row['post_image'];
                       $post_date =  $row['post_date'];
                       ?>
                       <!-- First Blog Post -->
                       <h2>
                        <a href="post.php?post_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                         <h4>by  <?php echo $post_author; ?></h4>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                    <hr>
                     <a href="post.php?post_id=<?php echo $post_id; ?>" style='display: inline-block;'>
                        <img class="img-responsive" src="img/<?php echo $post_image;?>" alt="" style='width: 40vw;'>
                        </a>
                    <hr>
                    <p><?php echo $post_content; ?></p>
                    <a class="btn btn-primary" href="post.php?post_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>
                    <?php
                }}

                ?>



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
                <!-- /.row -->


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

            <!-- jQuery -->
            <script src="js/jquery.js"></script>

            <!-- Bootstrap Core JavaScript -->
            <script src="js/bootstrap.min.js"></script>
            <script src="script.js"></script>

        </body>

        </html>
