


<!-- Request.php^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->

<?php  include 'header.php'; 
    //   include 'classes/User.php';
    //   include 'classes/Post.php';
?>
<style>
    .main_column{
        width: 700px;
        background: white;
        margin-top: 95px;
        margin-bottom: 150px;
        margin-left: auto;
        margin-right: auto;
        border-radius: 5px;
        padding-top: 1px;
        padding-bottom: 30px;
        padding-left: 20px;
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

    <div class="main_column">
    
        <h4> Friend Lists </h4>

        <div class="request_inner">

            <?php 
            
            $user_query = mysqli_query($con, "select * from friend_lists where user='$userLoggedIn'");
            $friend_query = mysqli_query($con, "select * from friend_lists where friend='$userLoggedIn'");
//            var_dump(mysqli_num_rows($friend_query));
            if(mysqli_num_rows($user_query)==0 && mysqli_num_rows($friend_query)==0){
                echo "No friend lists";
            }
            else{
//
                if (mysqli_num_rows($user_query) > 0)
                {
            while($row = mysqli_fetch_array($user_query)){
            $user_from = $row['friend'];
            $get_pic_query = mysqli_query($con, "select * from users where username='$user_from'");
            $get_pic = mysqli_fetch_array($get_pic_query);
            $request_pic = $get_pic['profile_pic'];
            $user_from_obj = new User($con, $user_from);
            echo "<br><a href='".$user_from_obj->getUsername()."'><img id='pro_pic' src='".$request_pic."'><br><div class='name'>" . $user_from_obj->getFnameAndLname();
            $user_from_friend_array = $user_from_obj->getFriendArray();

            ?>

        </div>
        <?php
        }
                }

        if (mysqli_num_rows($friend_query) > 0)
        {
        while($row = mysqli_fetch_array($friend_query)){
        $user_from = $row['user'];
        $get_pic_query = mysqli_query($con, "select * from users where username='$user_from'");
        $get_pic = mysqli_fetch_array($get_pic_query);
        $request_pic = $get_pic['profile_pic'];
        $user_from_obj = new User($con, $user_from);
        echo "<br><a href='".$user_from_obj->getUsername()."'><img id='pro_pic' src='".$request_pic."'><br><div class='name'>" . $user_from_obj->getFnameAndLname();
        $user_from_friend_array = $user_from_obj->getFriendArray();

        ?>

    </div>
<?php
}
}
            }
            ?>

        </div>


    </div>