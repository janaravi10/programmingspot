<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Admin - programming spot</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>     <?php echo $_SESSION['username']; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="../verification.php?delete_account=<?php echo $session_user_id; ?>" id="deleteAccount" onclick="return deleteAccountFun()"><i class="fa fa-fw fa fa-trash"></i> Delete account</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li id="posts">
                        <a href="javascript:;" data-toggle="collapse" data-target="#post_dropdown"><i class="fa fa-fw fa-desktop"></i>  Posts<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="post_dropdown" class="collapse">
                            <li>
                                <a href="./posts.php?source=all_post">view all posts</a>
                            </li>
                            <li>
                                <a href="./posts.php?source=add_post">Add posts</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="./categories.php"><i class="fa fa-fw fa-wrench"></i> Categories</a>
                    </li>

                    <li  id="comments">
                        <a href="posts.php?source=post_comment"><i class="fa fa-fw fa-file"></i> Comments</a>
                    </li>
                     <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> users <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="users.php?source=add_users">add users</a>
                            </li>
                            <li>
                                <a href="users.php?source=all_users">all users</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="profile.php"><i class="fa fa-fw fa-dashboard"></i>profile</a>
                    </li>
                    <li>
                        <a href="message.php"><i class="fa fa-fw fa-envelope"></i>message  <span class="badge">0</span></a>
                    </li>
                    <li><a  href="../index.php">Home page</a></li>
                    <li> <a>User Online: <?php echo $count_rows; ?></a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
        <?php
        //code for making li active when clicking apecifi

        if (isset($_GET['source'])) {
            $source = $_GET['source'];
            switch ($source) {
                case 'post_comment':
                ?>
                    <script>
                        document.getElementById('comments').classList.add('active');
                    </script>
                    <?php
                    break;

                case 'all_post'|| 'add_post':
                    ?> <script type="text/javascript">document.getElementById('posts').classList.add('active');</script><?php
                    break;
                default:
                ?>
                <script type="text/javascript">document.getElementById('posts').classList.remove('active');</script><?php
                break;
            }
         } ?>
