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

https://www.youtube.com/watch?v=rWon2iC-cQ0&list=PLfdtiltiRHWF5Rhuk7k4UAU1_yLAZzhWc&index=2#t=361.438216

Part 11/23