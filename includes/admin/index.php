<?php include 'includes/admin_header.php'; ?>
    <div id="wrapper">
        <!-- Navigation -->
    <?php $count_rows = users_online(); ?>


        <?php include 'includes/admin_navigation.php' ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome 
                            <small><?php echo $_SESSION['username']; ?></small>
                            <?php 
                            /* getting user information and image */
						$query_profile_image = "SELECT * FROM profileimage WHERE userid={$_SESSION['user_id']}";
						$querying_profile_image = mysqli_query($connection,$query_profile_image);
						if(mysqli_num_rows($querying_profile_image) === 1){
							$row_image = mysqli_fetch_assoc($querying_profile_image);
							echo '<img src="../img/'.$row_image['profileimage'].'" alt="" style="width: 60px; height: 60px; border-radius: 100%;">';
						}else{
							echo '<img src="../img/profile.png" alt="" style="width: 50px; height: 50px; border-radius: 100%;">';
						}
						?>
                        </h1> 
                <!-- /.row -->
                    </div>
                </div>
                <!-- /.row -->


<!-- /.row -->
                
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php 
                        $post_count = query_repeated("posts");
                        echo "<div class='huge'>{$post_count}</div>";
                         ?>

                  
                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                         <?php 
                         //comment counts 
                        $comments_count = query_repeated("comments");
                        echo "<div class='huge'>{$comments_count}</div>";
                         ?>
                      <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="posts.php?source=post_comment">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                          <?php 
                           //users counts 
                       $users_count = query_repeated("users");
                        echo "<div class='huge'>{$users_count}</div>";
                         ?>
                        <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="users.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php 
                         //category counts 
                        $categories_count = query_repeated("categories");
                        echo "<div class='huge'>{$categories_count}</div>";
                         ?>
                         <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<?php 

$published_post_count = query_post_status("published");
$draft_post_count = query_post_status("draft");
$approved_comment_count = query_comment_status("approved");
$unapproved_comment_count = query_comment_status("unapproved");

 ?>
<div class="row"> 
    <div id="columnchart_material" style="width: auto; height: 500px;"></div><script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'count']
          <?php 
          $column_name = ['published post','draft posts','comments','approved comments','unapproved comments','users','categories'];
          $column_count = [$published_post_count,$draft_post_count,$comments_count,$approved_comment_count,$unapproved_comment_count,$users_count,$categories_count];
        for($i = 0; $i<7; $i++){
                echo ",['{$column_name[$i]}'".","."{$column_count[$i]}]";
        }

           ?>
        ]);

        var options = {
          chart: {
            title: '',
            subtitle: '',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script></div>


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php include 'includes/admin_footer.php'; ?>