<?php
include_once('configs/global.php');

if(isset($_SESSION['username'])){
    header('Location: index.php');
exit;
}

if(isset($_REQUEST['username']) && isset($_REQUEST['password'])){
    authenticate($con, $_REQUEST['username'], $_REQUEST['password']);
}

function authenticate($con,$username,$password){

        $show_all_bands = "SELECT * FROM `user` WHERE `userName` = '" . $username . "' AND `passWord` = '" . $password . "'";
    
        $result = mysqli_query($con,$show_all_bands);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                $user[] = $row;
            }
            //$show_all_bands = "UPDATE `user` SET `lastLogin` = " . time() . " WHERE ";
    
            //$result = mysqli_query($con,$show_all_bands);
            $_SESSION['user']['username'] = $username;
            $_SESSION['user']['valid'] = $user[0]['userId'];
            
            $update_user = "UPDATE `user` SET `lastLogin` = '" . date("Y-m-d H:i:s") . "', `lastIp` = '". $_SERVER['REMOTE_ADDR'] . "' WHERE `userId` = " . $user[0]['userId'] . "";
            $result = mysqli_query($con,$update_user);
            
            header('Location: index.php');
            exit;
        }else{
            echo "<span class='login-error'><h4>Incorrect Username or Password.</h4>If you have forgotten your password please click <a href='forgot.php'>here</a>";
        }

        return $band;
    }
    
    ?>
    <br>
        <hr>
    <form action="" method="POST">
        
        <input type="text" name="username" value="Username" />&nbsp;<input type="password" name="password" value="Password" />&nbsp;<input type="submit" name="submit" value="login" />
    </form>