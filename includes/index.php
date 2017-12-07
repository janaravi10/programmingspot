<?php session_start(); ?>
<?php include "includes/database.php" ?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/functions.php'; ?>
<!-- Navigation -->
<?php include 'includes/navigation.php'; ?>
<!-- Page Content -->
<div class="container">
    <div class="row">
      <?php 

      /* this code will be used for making pager  start */
      if (isset($_GET['cat_id'])) {
        $cat_id = $_GET['cat_id'];
        $query_post_count = "SELECT * FROM posts WHERE post_cat_id={$cat_id}";
    		$querying_post_count = mysqli_query($connection,$query_post_count);
      }else{
        $query_post_count = "SELECT * FROM posts";
        $querying_post_count = mysqli_query($connection,$query_post_count);
      }
      $count = mysqli_num_rows($querying_post_count);
      $count = ceil($count /10);
      if (isset($_GET['page'])) {
          $page = $_GET['page'];
      }else{
          $page = "";
      }
      if ($page == ""|| 0) {
          $page_real = 0;
      }else{
          $page_real = ($page * 10)-10;
      }

      /* this code will be used for making pager  start */
         ?>
         <script type="text/javascript">
         /* echoing the $page_real variable for use in ajax request*/
           var page_real = <?php echo $page_real; ?>;
         </script>

        <!-- Blog Entries Column -->
        <div class="col-md-8" id="postBox">
          <?php 
if (isset($_GET['cat_title'])) {

  echo "<h1 class='page-header'> Post in category <small>".$_GET['cat_title']."</small> </h1>";
}

           ?>
          <div class="spinner" id="spinner"><div class="backspinner"><div class="innerspinner"></div></div></div>

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
             <?php 
                 show_login_form();
             ?>
         
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
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, 
                perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
            </div>

        </div>


    </div>
    <!-- /.row -->

    <hr>
    <ul class="pager">
        <?php
        /* codes to make the pager */
        for ($i=1; $i <=$count ; $i++) {
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            }else{
                $page = '';
            }
            if (isset($_GET['cat_id'])) {
              $cat_id = $_GET['cat_id'];
              $cat_title = $_GET['cat_title'];
              if ($i == $page) {
                  echo "<li><a class='pag'>{$i}</a></li>";
              }else{
              echo "<li><a href='?page={$i}&cat_id={$cat_id}&cat_title={$cat_title}'>{$i}</a></li>";
          }
        }else {
            if ($i == $page) {
                echo "<li><a class='pag'>{$i}</a></li>";
            }else{
            echo "<li><a href='?page={$i}'>{$i}</a></li>";
        }

            }

      }
         ?>

    </ul>
<script type="text/javascript" src="post.js">

</script>
    <!-- Footer -->
    <?php
    include 'includes/footer.php';
    ?>
