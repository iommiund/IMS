<?php
include_once("Classes/user.php");
$user = new user();

/** Verify that user is logged in */
if (isset($_REQUEST['submit'])) {
    extract($_REQUEST);
    $addUser = $user->addUser($name, $surname, $email, $username, $password);
    if ($addUser) {
        /** Add User Successful */
        echo "User Added";
    } else {
        /** Add User Failed */
        echo "Add User Failed - Username or Email already exists";
    }
}
?>
<?php /**
 * //IF THE SESSION USERNAME IS EMPTY, REDIRECT TO LOGIN SCREEN
 * if (empty($_SESSION['username'])) {
 *
 * header ('location: index.php?nologin');
 * die();
 * exit();
 *
 * }
 *
 * //SUPER USER VALIDATION - STANDARD USERS ARE REDIRECTED TO MAIN.PHP
 * $username=$_SESSION['username'];
 *
 * include_once ("dbc.php");
 *
 * $get=mysql_query ("SELECT user_type_id FROM users WHERE USERNAME = \"$username\"");
 *
 * $result=mysql_result($get,0);
 *
 * if ($result != 1) {
 *
 * header ('location: main.php');
 * die();
 * exit();
 *
 * } */
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
    function submitAddUser() {
        var form = document.addUser;
        if (form.name.value == "") {
            alert("Name is mandatory");
            return false;
        } else if (form.surname.value == "") {
            alert("Surname is mandatory");
            return false;
        } else if (form.email.value == "") {
            alert("Email is mandatory");
            return false;
        } else if (form.username.value == "") {
            alert("Username is mandatory");
            return false
        } else if (form.password.value == "") {
            alert("Password is mandatory");
            return false
        }
    }
</script>

<div class="content">
    <div class="container">
        <div class="form-style">
            <h1>Add a New User</h1>

            <form action="" method="post" name="addUser">
                <input type="text" name="name" placeholder="Name" required="required"/>
                <input type="text" name="surname" placeholder="Surname" required="required"/>
                <input type="email" name="email" placeholder="Email" required="required"/>
                <input type="text" name="username" placeholder="Username" required="required"/>
                <input type="password" name="password" placeholder="Password" required="required" min="4"/>
                <input type="submit" value="REGISTER"/>
            </form>
            <br>
            <div class="form-link">
                <?php
                if (isset($_GET['emptyfield'])) {
                    echo "<div id='error'>One or more fields were empty, try again!</div>";
                } else if (isset($_GET['uExists'])) {
                    echo "<div id='error'>A user with this username already exists</div>";
                } else if (isset($_GET['eExists'])) {
                    echo "<div id='error'>A user with this email already exists</div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
