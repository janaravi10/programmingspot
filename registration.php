<?php  include "includes/database.php"; ?>
 <?php  include "includes/header.php"; ?>
 <?php include 'includes/functions.php'; ?>
    <!-- Navigation -->
    <?php  include "includes/navigation.php"; ?>
    <!-- Page Content -->
    <div class="container">
        <?php if (isset($_POST['register'])) {
          
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        if (!empty($username) && !empty($email) && !empty($password)) {
            
        $username = mysqli_real_escape_string($connection,$username);
        $email = mysqli_real_escape_string($connection,$email);
        $password = mysqli_real_escape_string($connection,$password);
        
        if(strlen($username) < 5 || strlen($email) < 5 || strlen($password) < 5){
            if(strlen($username) < 5 && strlen($email) < 5 && strlen($password) < 5){
                $alert_message = "<h4 class = 'alert alert-warning'>Fields cannot be lesser than 5 characters </h4>";  
            }elseif(strlen($email) < 5){
                $alert_message = "<h4 class = 'alert alert-warning'>email cannot be lesser than 5 characters </h4>";  
            }elseif(strlen($password) < 5){
                $alert_message = "<h4 class = 'alert alert-warning'>password cannot be lesser than 5 characters </h4>";  
            }elseif(strlen($username) < 5){
                $alert_message = "<h4 class = 'alert alert-warning'>username cannot be lesser than 5 characters </h4>";  
            }else{
                echo "not working";
            }
     
        }else{
            $token = uniqid("",true);
           
        $hash = password_hash($password,PASSWORD_DEFAULT ,["cost"=>9]);
        $check_username = "SELECT * FROM users WHERE username= '$username' OR user_email = '$email'";
        $check_username_querying = mysqli_query($connection,$check_username);
        if(!mysqli_num_rows($check_username_querying)){
            $query_register_user = "INSERT INTO  verfication(username,email,password,verification_status,token)";
            $query_register_user .= "VALUES('{$username}','{$email}','{$hash}',0,'$token')";
            $querying_register_user = mysqli_query($connection,$query_register_user);
            $alert_message = "<h4 class='alert alert-success'>Registration succesful verify email id</h4>";
            if (!$querying_register_user) {
                die("qurey failed".mysqli_error($connection));
            }else{
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                 
                // Create email headers
                $headers .= "From: janaravi1000@gmail.com \r\n".
                    'Reply-To: '.$to."\r\n" ;
                $to = $email;
                $subject = "Verify your email address";
                $email_message = "<html>
                <style>
                .header{
                    color: #7c10e9;
                }
                .header .name{
                    color: yellow;
                }
                .footer{
                    color: rgb(238, 119, 119);
                }
                </style>
                <body>
                    <h4 class='header'>hello <span class='name'>".$username."</span> </h4>
                    <p>This email is from janaravi.com/cms(programmingspot) </p>
                    <p> Please verify your account by clicking the link below</p>
                    <a href='http://www.janaravi.com/cms/verification.php?token=".$token."&email=".$email."' target='_blank'>click here to verify </a>
                    <h5 class='footer'>if you didn't signed up for account ,ignore this message</h5>
                </body></html>";

                mail($to,$subject,$email_message,$headers);
            }
        }else{
            $row_fetch_user = mysqli_fetch_assoc($check_username_querying);
            if($username === $row_fetch_user['username']){
                $alert_message = "<h5 class='alert alert-danger'>username is not available choose different username </h5>";
            }else{
                $alert_message = "<h5 class='alert alert-danger'>Entered email address already exist with other account</h5>";
            }
            
        }
    }
     }else{
       $alert_message = "<h4 class='alert alert-warning'>Fields cannot be empty</h4>";
     }
        }else{
            $alert_message = '';
           
        } ?>

<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-3 col-sm-6">
                <div class="form-wrap">
                <h1>Register</h1>
                <h6 class="text-center"><?php echo $alert_message; ?></h6>
                    <form role="form" action="registration.php" method="post" id="loginform" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" value="<?php echo isset($username)? $username :''; ?>"
                            >
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" >
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password" id="password">
                        </div>

                        <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>

                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

        <hr>




<?php include "includes/footer.php";?>
