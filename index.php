
<!-- Index.php^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<style>
    .main_column{
        width: 500px;
        background: white;

    }
    #accept{
        background: #0090ff;
        border: none;
        border-radius: 3px;
        padding: 5px 10px;
        margin-top: 5px;
        color: white;
    }

    #reject{
        background: darkorange;
        border: none;
        border-radius: 3px;
        padding: 5px 10px;
        margin-top: 5px;
        color: white;
    }

    #pro_pic{
        height: 55px;
        width: 55px;
        border-radius: 50%;
    }

    .name{
        margin-left: 65px;
        margin-top: -52px;
        margin-bottom: auto;
    }

    hr{
        margin-top: 13px;
        width: 350px;
       
    }


</style>
<?php
    include 'header.php';
    // include 'classes/User.php';
    // include 'classes/Post.php';
    // include 'classes/Message.php';

    if(isset($_POST['post'])){
        $uploadOk = 1;
        $imageName = $_FILES['fileToUpload']['name'];
        $errorMessage = "";
        
        if($imageName != ""){
            $targetDir = "assets/images/posts/";
            $imageName = $targetDir . uniqid() . basename($imageName);
            $imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);
            
            if($uploadOk){
                if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageName)){
                    //image Upload Okey
                    $errorMessage = "uploaded";
                }
                else{
                    $uploadOk = 0;
                    $errorMessage = "fail to upload";
                }
            }
        }
        
        if($uploadOk){
            $post = new Post($con, $userLoggedIn);
            $post->submitPost($_POST['post_text'], $imageName);
        }
        else{
            echo "<div style='text-align: center;' class='alert alert-danger'> $errorMessage </div>";
        }
    }

    $user_detail_query = mysqli_query($con,"select * from users where username='$userLoggedIn'");
    $user_array = mysqli_fetch_array($user_detail_query);
    $num_friends = (substr_count($user_array['friend_array'],","))-1;

$comments_query = mysqli_query($con, "select * from comments where posted_to='$userLoggedIn'");
$comments_num = mysqli_num_rows($comments_query);

$posts_query = mysqli_query($con, "select * from posts where added_by='$userLoggedIn'");
$posts_num = mysqli_num_rows($posts_query);
$likes_count = [];
$dislikes_count = [];
if ($posts_num > 0)
{
while($row = mysqli_fetch_array($posts_query)) {
    $post_id = $row['id'];

    $likes_query = mysqli_query($con, "select * from likes where post_id='$post_id'");
    $likes_num = mysqli_num_rows($likes_query);
    $likes_count []= $likes_num;

    $dislikes_query = mysqli_query($con, "select * from dislikes where post_id='$post_id'");
    $dislikes_num = mysqli_num_rows($dislikes_query);
    $dislikes_count []= $dislikes_num;
}
}


?>

<div class="index-wrapper">
    <div class="info-box">
        <div class="info-inner">
            <div class="info-in-head">
                <a href="<?php echo $userLoggedIn; ?>"><img src="<?php echo $user['cover_pic']; ?>"></a>
            </div>
            <div class="info-in-body">
                <div class="in-b-box">
                    <div class="in-b-img">
                        <a href="<?php echo $userLoggedIn; ?>"><img src="<?php echo $user['profile_pic']; ?>"></a>
                    </div>
                </div>
                <div class="info-body-name">
                    <div class="in-b-name">
                        <div><a href="<?php echo $userLoggedIn; ?>"><?php echo $user['first_name'] . " " . $user['last_name']; ?></a>
                        </div>
                        <span><small><a href="<?php echo $userLoggedIn; ?>"><?php echo "@" . $user['username'] ?></a></small></span>
                    </div>
                </div>
            </div>
            <div class="info-in-footer">
                <div class="number-wrapper">
                    <div class="num-box">
                        <div class="num-head">
                            POSTS
                        </div>
                        <div class="num-body">
                            <?php echo $user['num_posts']; ?>
                        </div>
                    </div>
                    <div class="num-box">
                        <div class="num-head">
                            COMMENTS
                        </div>
                        <div class="num-body">
                            <?php echo $comments_num; ?>
                        </div>
                    </div>
                    <div class="num-box">
                        <div class="num-head">
                            LIKES
                        </div>
                        <div class="num-body">
                            <span class="count-likes">
                                <?php echo array_sum($likes_count); ?>
                            </span>
                        </div>
                    </div>
                    <div class="num-box">
                        <div class="num-head">
                            DISLIKES
                        </div>
                        <div class="num-body">
                            <span class="count-likes">
                                <?php echo array_sum($dislikes_count); ?>
                            </span>
                        </div>
                    </div>
                    <div class="num-box">
                        <div class="num-head">
                            Friends
                        </div>
                        <div class="num-body">
                        <a href="lists.php"> <?php echo $num_friends ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- <div class="info-box">
    <div class="main_column">
    
        <h4> Friend Lists </h4>

        <div class="request_inner">
            <?php
            // $query = mysqli_query($con, "select * from friend_lists where user='$userLoggedIn'");
            //     while($row = mysqli_fetch_array($query)){
            //         $user_from = $row['friend'];
            //         $get_pic_query = mysqli_query($con, "select * from users where username='$user_from'");
            //         $get_pic = mysqli_fetch_array($get_pic_query);
            //         $request_pic = $get_pic['profile_pic'];
            //         $user_from_obj = new User($con, $user_from);
            //         echo "<br><a href='".$user_from_obj->getUsername()."'><img id='pro_pic' src='".$request_pic."'><br><div class='name'>" . $user_from_obj->getFnameAndLname();
            //         $user_from_friend_array = $user_from_obj->getFriendArray();

            //         ?>
                
            //         </div>
            //         <?php
            //     }
                ?>
                </div>
                </div>
            </div> -->
    
            

    <div class="post-wrap">
        <div class="post-inner">
            <div class="post-h-left">
                <div class="post-h-img">
                    <a href="<?php echo $userLoggedIn; ?>"><img src="<?php echo $user['profile_pic'] ?>"></a>
                 </div>
            </div>
            
            <div class="post-body">
                <form class="post_form" action="index.php" method="POST" enctype="multipart/form-data">
                    <textarea class="status" name="post_text" id="post_text" placeholder="Type Something here!" rows="4" cols="50"></textarea>
                    <div class="hash-box">
                        <ul>
                        </ul>
                    </div>
            </div>
                <div class="post-footer">
                    <div class="p-fo-left">
                        <ul>
                            <input type="file" name="fileToUpload" id="fileToUpload"/>
                            <label for="fileToUpload"> <img src="assets/images/camera.png" alt="" height="30px"></i> </label>
                            <span class="tweet-error"></span>
                            <input id="sub-btn" type="submit" name="post" value="SHARE">
                        </ul>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="show_post">
        <?php 
            $post = new Post($con, $userLoggedIn) ;
            $post->indexPosts();
        ?>
    </div>
</div>
</body>
</html>