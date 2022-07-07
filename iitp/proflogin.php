<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: profwelcome.php");
    exit;
}

// Include config file
require_once "profconfig.php";

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if email is empty
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($email_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, email, password FROM proftable WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if email exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;

                            // Redirect user to welcome page
                            header("location: profwelcome.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid email or password.";
                        }
                    }
                } else {
                    // email doesn't exist, display a generic error message
                    $login_err = "Invalid email or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>
<HTML>

<HEAD>
<TITLE>---::: Student Information System:::---   </TITLE>
<STYLE  TYPE="text/css">

A {font-family: Verdana, Arial, Helvetica, sans-serif, "MS sans serif";font-size: 14px;line-height: 13px;text-decoration: none;font-weight: bold;}
A:hover
{color:#6666CC;text-decoration:none;}
h1 {font-family: Georgia,Verdana, Arial, Helvetica, sans-serif, "MS sans serif";font-size: 24px;line-height: 140%;text-decoration: none;color: #000000;font-weight: bold;}
h2 {font-family: Georgia,Verdana, Arial, Helvetica, sans-serif, "MS sans serif";font-size: 18px;line-height: 130%;text-decoration: none;color: #000000;font-weight: bold;}
.dark {font-family: Verdana, Arial, Helvetica, sans-serif, "MS sans serif";font-size: 11px;line-height: 13px;text-decoration: none;color: #000099;font-weight: bold;}
.para {font-family: Verdana, Arial, Helvetica, sans-serif, "MS sans serif";font-size: 11px;line-height: 13px;text-decoration: none;color: #787878;font-weight: bold;}
.big {font-family: Georgia,Verdana, Arial, Helvetica, sans-serif, "MS sans serif";font-size: 20px;line-height: 100%;text-decoration: none;color: Crimson�;font-weight: bold;}

</STYLE>
<script type='text/javascript' src='script/var.js'></script>
<script type='text/javascript' src='script/status.js'></script>
<script type='text/javascript' src='script/load.js'></script>
<script type='text/javascript' src='script/verify_gen_only.js'></script>


</HEAD>


<BODY onLoad="load();">

<!--<script type='text/javascript' src='script/checkcaps.js'></script>-->

<table height = "100%" width="100%" cellspacing="0" cellpadding="0">
<tr height = "15%"><td>
<table  width="100%" cellspacing="0" cellpadding="0" >
	<tr ><td><tr> <td align="center"><h1><font color = DarkBlue>Indian Institute of Technology Patna</h1></td> </tr>
<tr> <td align="center"><h2><font color = DarkBlue>Student Stipend System</h2></td> </tr>

 </td></tr>
</table>
</td></tr>
<tr height = "5%"><td>
<table align = "center" border=0 cellspacing=0 cellpadding=0>
<tr><td> &nbsp;</td></tr>
</table>
</td></tr>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<tr height = "30%"><td>
<table align="center" width="30%" cellspacing="0" cellpadding="0" border = "0"><tr><td>
<table align="center">
<tr bgcolor=lightblue><td align="center" class=text1 colspan=2><b><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif" size="+1">Professor Login</font></b></td></tr>
<tr><td align=center colspan=2> &nbsp; </td></tr>
<tr><td align="left" valign="top" class=text1 ><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Email Id</b></font></td>
<td class="dark"><font face=verdana,sans-serif size=1><input type="Email" name="email" value="" size=15 style="width:150px; font-family:Verdana,Sans-serif; font-size:10px;" alt ="Id" title = "Type your email_id" required> </font>
<br></td></tr>
<tr><td align="left" class=text1 height=25><font face="Verdana, Arial, Helvetica, sans-serif" size="-1" ><b>Password </b></font></td>
<td> <font face=verdana,sans-serif size=1><input type="password" name="password" size=15  onKeyPress="checkCapsLock( event )" style="width:150px; font-family:Verdana,Sans-serif; font-size:10px;" alt ="Id" title = "Type your password" required></font> </td></tr>
<tr>
    <td align=center class=text1>
        <font color="red">
        <?php
                if (!empty($login_err)) 
                {
                    echo '<div class="alert alert-danger">' . $login_err . '</div>';
                }
        ?>
        </font>
    </td>
</tr>
<tr><td align=center colspan=2> &nbsp; </td></tr>
<tr><td align=center colspan=2><input type=submit value="Log in" alt ="Id" title = "Login"></td></tr>
</table>
</td></tr>
</table>
</td></tr>
</form>
<tr height = "20%"><td>
<table align = "center" border=0 cellspacing=0 cellpadding=0>
<tr>
<td  align=center><font face="Verdana" size="+1"><a href="profregister.php" alt ="Id" title = "Sign Up">Sign Up </a></font></td>
<td width=30>&nbsp; &nbsp;| &nbsp;</td>
<td align=center><font face="Verdana" size="+1"><a href="profforgot/forgot.php" alt ="Id" title = "Retrieve your Password">Forgot Password</a></td>
</tr>
<tr><td> &nbsp;</td></tr>
</table>
</td></tr>
<tr height = "5%"><td>
<table align = "center" border=0 cellspacing=0 cellpadding=0>
<tr><td align=center><a href="home.html" alt ="Id" title = "Back to Home"><font size=5 color =seagreen  face="garmond"><b><p align="center"><i>Home</i></b></font></a>
</table>
</td></tr>
<tr height = "20%"><td>
<table align = "center" border=0 cellspacing=0 cellpadding=0>
<tr><td> &nbsp;</td></tr>
</table>
</td></tr>
<tr height = "5%"><td><TABLE WIDTH="100%" cellspacing="0" cellpadding="0">
<TR>
<TD bgcolor=lightgrey class="dark" align="center" height="45" valign="center">

<b>Academic Services<br>Indian Institute of Technology Patna  <BR>
  <br> Email - feedback@iitp.ac.in</b>

</TD>
</TR>
</TABLE>
 </td></tr>
</table>

</BODY>
</HTML>