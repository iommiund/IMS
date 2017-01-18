<?php
session_start();
include_once 'Classes/user.php';
$user = new user();

if (isset($_REQUEST['username'], $_REQUEST['password'], $_REQUEST['login']) && !empty($_REQUEST['username'])) {
    extract($_REQUEST);

    $username=$_REQUEST['username'];
    $password=md5($_REQUEST['password']);

    $login = $user->loginUser($username, $password);

    if ($login) {
        /** Login Successful - redirect to main page */
        header("location:home.php");
    } else {
        /** Login Failed - display error message */
        header("location:index.php?error,$username,$password,$login");

    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <title>IMS Login</title>
    <link rel='stylesheet prefetch'
          href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<script type="text/javascript" language="JavaScript">
    function submitLogin() {
        var form = document.login;
        if (form.username.value == "") {
            alert("Username is mandatory");
            return false;
        } else if (form.password.value == "") {
            alert("Password is mandatory");
            return false;
        }
    }
</script>

<div class="outer">
    <div class="middle">
        <div class="inner">
            <div class="login-card">
                <h1><strong>IMS</strong>login</h1><br>
                <form action="" method="post" name="login">
                    <input type="text" name="username" required="required" placeholder="Username">
                    <input type="password" name="password" required="required" placeholder="Password">
                    <input onclick="return(submitLogin());" type="submit" name="login" class="login login-submit"
                           value="login">
                </form>
                <!--ERROR MESSAGES-->
                <div class="reset-password">
                    <?php
                    if (isset($_GET['error'])) {
                        echo "<div id='error'>Incorrect Username or Password!!!!</div>";
                    } else if (isset($_GET['disable'])) {
                        echo "<div id='error'>This user is disabled!!!!</div>";
                    } else if (isset($_GET['nologin'])) {
                        echo "<div id='error'>You must be logged in!!!!</div>";
                    } else if (isset($_GET['resetPassword'])) {
                        echo "<div id='error'>Login using your new Password</div>";
                    }
                    ?>
                </div>
                <!--ERROR MESSAGES END-->
            </div>
        </div>
    </div>
</div>

<script src='jquery.min.js'></script>
<script src='jquery-ui.min.js'></script>


</body>
</html>