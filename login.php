<?php
require_once 'core/init.php';

if (input::exists()){
    if (token::check(input::get('token'))) {

        $validate = new validation();
        $validation = $validate->check($_POST, array(
            'username' => array('required' => true),
            'password' => array('required' => true)
        ));

        if ($validation->passed()){
            $user = new user();

            $login = $user->login(input::get('username'), input::get('password'));

            if($login){
                echo 'success';
            } else {
                echo $user;
                //redirect::to('login.php?error');
            }

        } else {
            foreach ($validation->errors() as $error){
                echo "- " . $error . "!!!", '<br>';
            }
        }

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
<div class="outer">
    <div class="middle">
        <div class="inner">
            <div class="login-card">
                <h1><strong>IMS</strong>login</h1><br>
                <form action="" method="post" name="login">
                    <input type="text" name="username" value="<?php echo escape(input::get('username')); ?>" placeholder="Username">
                    <input type="password" name="password" placeholder="Password">
                    <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                    <input type="submit" name="login" class="login login-submit" value="login">
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