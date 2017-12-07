<?php include 'includes/admin_header.php'; ?>

<div id="wrapper">
    <!-- Navigation -->

    <?php 
        $count_rows =  users_online();
    include 'includes/admin_navigation.php' ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome 
                        <small>Jana Ravi </small>
                    </h1>

                    <div class="col-md-6">
                        <?php 
                           //  SUBMIT CATEGORY   
                        submit_cat();
                        ?>
                               <?php // UPDATING CATEGORY
                               update_cat();  
                               ?>
                               
                               <form action="" method="post">
                                <div class="form-group">
                                    <label class="h4">Category name...</label>
                                    <input type="text" class="form-control" name="cat_title">
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="add_cat" value="Add category">
                                </div>
                            </form>
                            <?php  
                              //UPDATE FORM START
                            if (isset($_GET['edit'])) {
                                $cat_edit_id = $_GET['edit'];
                                $query_edit = "SELECT * FROM categories WHERE cat_id = {$cat_edit_id}";
                                $querying_edit = mysqli_query($connection,$query_edit);
                                ?>
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label class="h4">Category name...</label>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($querying_edit)) {
                                            $cat_id = $row['cat_id'];
                                            $cat_title = $row['cat_title'];
                                            ?>
                                            <input type="text" value="<?php echo $cat_title; ?>" class="form-control" name="update_cat_title">


                                        </div>
                                        <div class="form-group">

                                            <input type="submit" class="btn btn-primary" name="update_cat" value="Update category">
                                            <?php 
                                        }
                                    }
                                //UPDATE FORM ENDS
                                    ?>

                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody> <?php 
                              //TABLE TO SHOW DATA STARTS
                                $query = "SELECT * FROM categories";
                                $querying = mysqli_query($connection,$query);
                                // LOOPING THROUGH THE DATA
                                while ($row = mysqli_fetch_assoc($querying)) {
                                    $cat_id = $row['cat_id'];
                                    $cat_title = $row['cat_title'];
                                    echo "<tr>";
                                    echo "<td>{$cat_id}</td>";
                                    echo "<td>{$cat_title}</td>";
                                    echo "<td> <a href='categories.php?edit={$cat_id}' class='btn btn-info'>Edit</a><a href ='categories.php?delete={$cat_id}' style='margin-left:10px' class='btn btn-danger'>Delete</a></td>";
                                    echo "</tr>";
                                }
                            //TABLE TO SHOW DATA ENDS
                                ?>
                                <?php delete_cat(); ?>
                            </tbody>
                        </table>
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
<?php include 'includes/admin_footer.php'; ?>
