<?php session_start(); ?>
<?php include "includes/database.php" ?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/functions.php'; ?>
<!-- Navigation -->
<?php include 'includes/navigation.php'; ?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">     
          
            <?php 
            if (isset($_GET['cat_id'])) {
                $cat_id = $_GET['cat_id'];
                $cat_title = $_GET['cat_title'];
                $query = "SELECT * FROM posts WHERE post_cat_id={$cat_id}";
                $querying = mysqli_query($connection,$query);
              echo "<h1 class='page-header'>
                    Post in category
                    <small>{$cat_title}</small>
                </h1>";
                while ($row = mysqli_fetch_assoc($querying)) {
                    $post_id = $row['post_id'];
                    $post_title =  $row['post_title'];
                    $post_author =  $row['post_author'];
                    $post_content =  substr($row['post_content'],0,100)."...";
                    $post_image =  $row['post_image'];
                    $post_date =  $row['post_date'];
                    $post_author_id = $row['post_author_id'];
                    $views_count = $row['views_count'];
                    ?> 
                    <!-- First Blog Post -->
                    <h2>
                        <a href="post.php?post_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="author_post.php?author=<?php echo $post_author; ?>&post_author_id=<?php echo $post_author_id; ?>"><?php echo $post_author; ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p><h4><?php echo $views_count; ?></h4>
                    <hr>
                    <img class="img-responsive" src="img/<?php echo $post_image;?>" alt="">
                    <hr>
                    <p><?php echo $post_content; ?></p>
                    <a class="btn btn-primary" href="post.php?post_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>
                    <?php
                }
            }else{
                $query = "SELECT * FROM posts WHERE post_status='published'";
                $querying = mysqli_query($connection,$query);
                if (mysqli_num_rows(mysqli_query($connection,$query))) { 
                    while ($row = mysqli_fetch_assoc($querying)) {
                        $post_id = $row['post_id'];
                        $post_title =  $row['post_title'];
                        $post_author =  $row['post_author'];
                        $post_content =  substr($row['post_content'],0,200)."...";
                        $post_image =  $row['post_image'];
                        $post_date =  $row['post_date'];
                        $post_author_id = $row['post_author_id'];
                        $views_count = $row['views_count'];
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
                        <a href="post.php?post_id=<?php echo $post_id; ?>">
                        <img class="img-responsive" src="img/<?php echo $post_image;?>" alt="">
                        </a>
                        <hr>
                        <p><?php echo $post_content; ?></p>
                        <a class="btn btn-primary" href="post.php?post_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                        <hr>
                        <?php
                    } }else{
                        echo "<h1 class='text-center'>SORRY THEIR IS NO POST</h1>";
                    }
                }

                ?>


            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">


                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <div class="input-group">
                        <form action="search.php" method="post">
                            <input name="input" type="text" class="form-control">
                            <span class="input-group-btn">
                                <button  name="submit" class="btn btn-default" type="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </form>
                    </div>
                    <!-- /.input-group -->
                </div>

                <!-- login form -->
                <?php if (!isset($_SESSION['user_role'])) {
                  
                 ?>
                <div class="well">
                    <h4>Login</h4>
                    <div class="input-group">
                        <form action="includes/login.php" method="post" class="form-group">
                            <label for="username">Username  <input name="username" placeholder="Username" type="text" class="form-control"></label>
                          
                           
                           <label for="password">Password <input name="password" placeholder="Password" type="password" class="form-control"></label>
                            

                            <button  name="login" class="btn btn-default" type="submit" id="login">Login
                            </button>
                            <div id="span"></div>
                        </form>
                    </div>
                </div>
                <?php } ?>
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
    <?php  
    include 'includes/footer.php';
    ?>

