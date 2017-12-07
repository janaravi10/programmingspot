 <?php if (isset($_GET['del_user'])) {
    $delete_user_id  = $_GET['del_user'];
    $delete_user_query = "DELETE FROM users WHERE user_id = {$delete_user_id}";
    $delete_user_querying = mysqli_query($connection,$delete_user_query);
    confirm_query($delete_user_querying);
 } 

 ?>
 <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                /* showing all user */
                                $query = "SELECT * FROM users";
                    $querying = mysqli_query($connection,$query);
                    while ($row = mysqli_fetch_assoc($querying)) {
                        $user_id = $row['user_id'];
                        $username = $row['username'];
                        $user_password = $row['password'];
                        $user_firstname = $row['user_firstname'];
                        $user_lastname = $row['user_lastname'];
                        $user_email = $row['user_email'];
                        $user_role = $row['user_role'];
                        echo "<tr>";
                        echo "<td>{$user_id}</td>";
                        echo "<td>{$username}</td>";
                        echo "<td>{$user_firstname}</td>";
                        echo "<td>{$user_lastname}</td>";
                        echo "<td>{$user_email}</td>";
                        echo "<td>{$user_role}</td>";
                         // echo "<td><img style ='width:100px; height:50px;' src='../img/$post_image'></td>";
                        echo "<td><a href='users.php?source=edit_users&user_id={$user_id}' class='btn btn-info'>Edit</a></td>";
                        echo "<td><a href='users.php?del_user={$user_id}' class='btn btn-danger'>Delete</a></td>";  
                        echo "</tr>";
                    }
                                 ?>
                            </tbody>
                        </table>
