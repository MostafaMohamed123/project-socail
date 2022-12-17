

<!-- Like.php^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <link rel="stylesheet" href="../../assets/fontawesome-free-5.15.1-web/css/all.css">
    <style type="text/css">
    body{
        background: #fff;
    }

    </style>
</head>
<body>

    <?php
        
        include 'session-file.php';
        include 'classes/User.php';
        include 'classes/Post.php'; 

        if(isset($_SESSION['username'])){
            $userLoggedIn = $_SESSION['username'];
            $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
            $user = mysqli_fetch_array($user_details_query);
        }
        else{
            header("Location: register.php");
        }

        if (isset($_GET['post_id'])){
            $post_id = $_GET['post_id'];
        }

        $get_like = mysqli_query($con, "select dislikes, likes, added_by from posts where id='$post_id'");
        $row = mysqli_fetch_array($get_like);
        $total_likes = $row['likes'];
        $total_dislikes = $row['dislikes'];
        $user_liked = $row['added_by'];

        $get_user_like = mysqli_query($con, "select * from likes where post_id='$post_id'");

        $user_details_query = mysqli_query($con, "select * from users where username='$user_liked'");
        $row = mysqli_fetch_array($user_details_query);
        $total_user_dislikes = $row['num_dislikes'];

        //dislike button
        if(isset($_POST['dislike_btn'])){
            if($_POST['dislike_btn'] == 0)
            {
                $total_dislikes++;
                $query = mysqli_query($con, "update posts set dislikes='$total_dislikes' where id='$post_id'")or die(mysqli_error($con));
                $total_user_dislikes++;
                $user_likes = mysqli_query($con, "update users set num_dislikes='$total_user_dislikes' where username='$user_liked'");
                $insert_query = mysqli_query($con, "insert into dislikes (username, post_id) values('$userLoggedIn','$post_id')");
                
            }
            if($_POST['dislike_btn'] == 1)
            {
                $total_dislikes--;
                $query = mysqli_query($con, "update posts set dislikes='$total_dislikes' where id='$post_id'")or die(mysqli_error($con));
                $total_user_dislikes--;
                $user_likes = mysqli_query($con, "update users set num_dislikes='$total_user_dislikes' where username='$user_liked'");
                $deleye_user_dislike = mysqli_query($con, "delete from dislikes where username='$userLoggedIn' AND post_id='$post_id'");
                
            }
            header("Refresh:0");
        }

        //chech previus likes
        $check_query = mysqli_query($con, "select * from dislikes where username='$userLoggedIn' AND post_id='$post_id'")or die(": ( ".mysqli_error($con));
        $num_rows = mysqli_num_rows($check_query);
        $check_query_likes = mysqli_query($con, "select * from likes where username='$userLoggedIn' AND post_id='$post_id'")or die(": ( ".mysqli_error($con));
        $num_rows_likes = mysqli_num_rows($check_query_likes);
            ?>
             <div style=""class="maincl">
            <?php

if($num_rows > 0)
{
    echo '<div><form action="dislike.php?post_id='. $post_id . '" method="POST" style="position: absolute; top: 0;">
    <label><input onchange="this.form.submit();" type="checkbox" class="comment_like" name="dislike_btn" value="1" style="background: #3875C5; border: none; border-radius: 3px; padding: 3px 10px 3px 10px; color: white;">Dislike</label>
           <div class="like_value" style="display: inline;">
               ('. $total_dislikes . ')
           </div>
      </form></div>
   ';
}
else
{
    if($num_rows_likes == 0)
    {
             echo '<div><form action="dislike.php?post_id='. $post_id . '" method="POST" style="position: absolute; top: 0;">
             <label><input onchange="this.form.submit();" type="checkbox" class="comment_like" name="dislike_btn" value="0" style="background: #3875C5; border: none; border-radius: 3px; padding: 3px 10px 3px 10px; color: white;">Dislike</label>
                    <div class="like_value" style="display: inline;">
                        ('. $total_dislikes . ')
                    </div>
               </form></div>
            ';
    }
}


    ?>
           </div>
</body>
</html>