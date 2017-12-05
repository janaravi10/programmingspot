<?php  include "includes/database.php"; ?>
 <?php  include "includes/header.php"; ?>
 <?php include 'includes/functions.php'; ?>
    <!-- Navigation -->
    <?php  include "includes/navigation.php"; ?>
    <!-- Page Content -->
    <div class="container">
        <?php if (isset($_POST['submit'])) {
        $to = "janaravi962@gmail.com";
        $email = "From: ".$_POST['email'];
        $subject = $_POST['subject'];
        $email_body = $_POST['emailBody'];
          mail($to,$subject,$email_body,$email);
        } ?>

<section id="login">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-md-offset-3">
                <div class="form-wrap">
                <h1>Contact me</h1>
                <h6 class="text-center"></h6>
                    <form role="form" action="contact.php" method="post" id="contactF" autocomplete="off">
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                        </div>
                         <div class="form-group">
                            <label for="subject" class="sr-only">subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="your subject">
                        </div>
                        <div class="form-group">
                            <textarea name="emailBody" id="" cols="30" rows="10" class="form-control"></textarea>
                        </div>

                        <input type="submit" name="submit"  class="btn btn-custom btn-lg btn-block" value="send email">
                    </form>
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
