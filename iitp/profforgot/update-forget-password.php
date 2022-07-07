<?php
if(isset($_POST['password']) && $_POST['reset_link_token'] && $_POST['email'])
{
include "../profconfig.php";
$emailId = $_POST['email'];
$token = $_POST['reset_link_token'];
$password = $_POST['password'];
$query = mysqli_query($link,"SELECT * FROM `proftable` WHERE `reset_link_token`='".$token."' and `email`='".$emailId."'");
$row = mysqli_num_rows($query);
if($row){
    if(mysqli_query($link,"UPDATE proftable SET  password='" . password_hash($password, PASSWORD_DEFAULT) . "', reset_link_token='" . NULL . "' ,exp_date='" . NULL . "' WHERE email='" . $emailId . "'"))
    {
        echo '<p>Congratulations! Your password has been updated successfully.</p>';
    }
    else{
        echo 'Error: ';
    }
}else{
echo "<p>Something goes wrong. Please try again</p>";
}
}
?>