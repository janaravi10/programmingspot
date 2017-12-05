<?php include 'includes/admin_header.php'; ?>
<div id="wrapper">
  <!-- Navigation -->
 <?php   $count_rows =  users_online(); ?>
  <?php include 'includes/admin_navigation.php' ?>

  <div id="page-wrapper">

    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">
            Welcome
            <small>Jana Ravi </small>
          </h1> 
          <div id="tableContainer">
          <?php
          if (isset($_GET['source'])) {
           $source = $_GET['source'];
         }else{
          $source = '';
        }
        switch ($source) {
         case "add_post":
         include 'includes/add_post.php';
         break;
         case "post_comment":
         include 'includes/comments.php';
         break;
         case "all_post":
         include "includes/all_post.php";
         break;
         case "edit_post":
         include "includes/edit_post.php";
         break;
         default:
         include "includes/all_post.php";
         break;
       }
       ?>
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
