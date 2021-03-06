<?php
require_once 'core/init.php';

$user = new user();

if ($user->isLoggedIn()) {
    redirect::to('main.php');
}

if (input::exists()){

    if (token::check(input::get('token'))) {

        $validate = new validate();
        $validation = $validate->check($_POST, array(
            'username' => array('required' => true),
            'password' => array('required' => true)
        ));

        if ($validation->passed()){
            $user = new user();

            $remember = (input::get('remember') === 'on') ? true : false;
            $login = $user->login(input::get('username'), input::get('password'), $remember);

            if($login){
                redirect::to('main.php');
            } else {
                $hash = new hash();
                redirect::to('index.php?' . hash::sha256('error' . $hash->getSalt()));
            }

        } else {
            $hash = new hash();
            redirect::to('index.php?' . hash::sha256('v' . $hash->getSalt()));
        }

    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <title>IMS Login</title>
    <link rel='stylesheet prefetch' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
<div class="outer">
    <div class="middle">
        <div class="inner">
            <div class="login-card">
                <h1><strong>IMS</strong>login</h1><br>
                <form action="" method="post" name="login">
                    <input type="text" name="username" value="<?php echo escape(input::get('username')); ?>" placeholder="Username" autocomplete="off">
                    <input type="password" name="password" placeholder="Password" autocomplete="off">
                    <label for="remember">
                        <input type="checkbox" name="remember" id="remember"> Remember Me
                    </label>
                    <br>
                    <br>
                    <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                    <input type="submit" name="login" class="login login-submit" value="login">
                </form>
                <!--ERROR MESSAGES-->
                <div class="reset-password">
                    <div id='error'>
                        <b>
                            <?php
                            $hash = new hash();
                            if (isset($_GET[hash::sha256('error' . $hash->getSalt())])) {
                                echo "Incorrect Username or Password!!!!";
                            } else if (isset($_GET[hash::sha256('disabled' . $hash->getSalt())])) {
                                echo "This user is disabled!!!!";
                            } else if (isset($_GET[hash::sha256('nologin' . $hash->getSalt())])) {
                                echo "You must be logged in!!!!";
                            } else if (isset($_GET[hash::sha256('changePassword' . $hash->getSalt())])) {
                                echo "Login using your new Password";
                            } else if (isset($_GET[hash::sha256('v' . $hash->getSalt())])) {
                                echo "All fields are required!!!!";
                            }
                            ?>
                        </b>
                    </div>
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