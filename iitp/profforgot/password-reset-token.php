<?php
if(isset($_POST['password-reset-token']) && $_POST['email'])
{
    include "../profconfig.php";
     
    $emailId = $_POST['email'];
 
    $result = mysqli_query($link,"SELECT * FROM proftable WHERE email='" . $emailId . "'");
 
    $row= mysqli_fetch_array($result);
 
  if($row)
  {
     
     $token = md5($emailId).rand(10,9999);
 
     $expFormat = mktime(
     date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
     );
 
    $expDate = date("Y-m-d H:i:s",$expFormat);
    $password = "";
    $update = mysqli_query($link,"UPDATE proftable set password ='" . $password . "', reset_link_token='" . $token . "' ,exp_date='" . $expDate . "' WHERE email='" . $emailId . "'");
 
    $link = "http://localhost/iitp/profforgot/reset-password.php?key=".$emailId."&token=".$token."";
 
    
    $to_email = $emailId;
    $subject = "Reset password link";
    $body = 'Click On This Link to Reset Password '.$link.'';
    $headers = "From: jharajib.iitp.ac.in@gmail.com";

    if (mail($to_email, $subject, $body, $headers)) {
        echo "Email successfully sent to $to_email...";
    } else {
        echo "Email sending failed...";
    }
  }else{
    echo "Invalid Email Address. Go back";
  }
}
?>