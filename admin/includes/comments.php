<?php delete_comment(); ?>
 <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Author</th>
                                    <th>comment</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Response to</th>
                                    <th>Approve</th>
                                    <th>Unapprove</th>
                                    <th>Delete</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $query_comments = "SELECT * FROM comments";
                    $querying_comments = mysqli_query($connection,$query_comments);
                    while ($row = mysqli_fetch_assoc($querying_comments)) {
                        $comment_id = $row['comment_id'];
                        $comment_post_id = $row['comment_post_id'];
                        $comment_author = $row['comment_author'];
                        $comment_email = $row['comment_email'];
                        $comment_content = $row['comment_content'];
                        $comment_status = $row['comment_status'];
                        $comment_date = $row['comment_date'];
                        echo "<tr>";
                        echo "<td>{$comment_id}</td>";
                        echo "<td>{$comment_author}</td>";
                        echo "<td>{$comment_content}</td>";
                        echo "<td>{$comment_email}</td>";
                        echo "<td>{$comment_status}</td>";
                         echo "<td>{$comment_date}</td>";
                         $query_post ="SELECT * FROM posts WHERE post_id={$comment_post_id}";
                         $querying_post = mysqli_query($connection,$query_post);
                         while ($row = mysqli_fetch_assoc($querying_post)) {
                            $post_id = $row['post_id'];
                             $post_title = $row['post_title'];
                              echo "<td><a href='../post.php?post_id={$post_id}' >{$post_title}</a></td>";
                         }
                         
                        echo "<td><a href='posts.php?source=post_comment&a={$comment_id}' class='btn btn-info'>Approve</a></td>";
                        echo "<td><a href='posts.php?source=post_comment&ua={$comment_id}' class='btn btn-danger'>Unapprove</a></td>"; 
                        echo "<td><a href='posts.php?source=post_comment&del_comment={$comment_id}&com_post_id={$comment_post_id}' class='btn btn-danger'>Delete</a></td>";  
                        echo "</tr>";

                    }
                                 ?>
                            </tbody>
                        </table>
