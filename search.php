<?php include "includes/database.php" ?>
<?php include 'includes/header.php';
include 'includes/functions.php';
 ?>

    <!-- Navigation -->
   <?php include 'includes/navigation.php'; ?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">   
           
  <?php 
                if(isset($_POST['submit'])){
                    if(!empty($_POST['input'])){
              $search = $_POST['input'];
              $search = mysqli_real_escape_string($connection,$search);
              ?>

                <h1 class="page-header">
                    Post related to
                    <small><?php echo $search; ?></small>
                </h1>
                <?php
                $search = "%".$search. "%";
                $query_stmt = mysqli_prepare($connection,"SELECT post_id,post_title,post_author,post_image,post_date,post_content,post_author_id FROM posts WHERE post_tags LIKE ?");
                mysqli_stmt_bind_param($query_stmt,"s",$search);
                mysqli_stmt_execute($query_stmt);
                mysqli_stmt_bind_result($query_stmt,$post_id,$post_title,$post_author,$post_image,$post_date,$post_content,$post_author_id);
                mysqli_stmt_store_result($query_stmt);
                $count = mysqli_stmt_num_rows($query_stmt);
                
                if($count){
                       while(mysqli_stmt_fetch($query_stmt)){
                     ?> 
                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?post_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
               <p class="lead">
                        by <a href="author_post.php?author=<?php echo $post_author; ?>&post_author_id=<?php echo $post_author_id; ?>"><?php echo $post_author; ?></a>

                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
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
                    echo "<h4 class='alert alert-warning text-center'>No result found</h4>";
                }
            }else{
                echo "<h4 class='alert alert-warning text-center'>Please provide some specific keywords</h4>";
                
            }
          }else{
            header("location: index.php");
          }
              ?>    
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">
                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="search.php" method="post">
                    <div class="input-group">
                        <input name="input" type="text" class="form-control"><span class="input-group-btn">
                            <button  name="submit" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span>     
                        </button>
                        </span>
                    </div>
                    </form>
                    </div>
                    <!-- /.input-group -->
              <!-- login form -->
              <?php show_login_form(); ?>
                <!-- login form end -->
                    <!-- /.input-group -->
               

                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                              <?php show_categories(); ?>
                            </ul>
                        </div>
                        <!-- /.col-lg-6 -->
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