<?php
/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 18/01/2017
 * Time: 20:44
 */
require_once 'core/init.php';

$user = new user();

if(!$user->isLoggedIn()){
    redirect::to('index.php');
}

if (input::exists()){
    if (token::check(input::get('token'))){

        $validate = new validate();
        $validation = $validate->check($_POST, array(
            'current_password' => array(
                'required' => true,
                'min' => 4
            ),
            'new_password' => array(
                'required' => true,
                'min' => 4
            )
        ));

        if($validation->passed()){

            if (hash::make(input::get('current_password'), $user->data()->salt) !== $user->data()->password){
                echo 'Your current password is incorrect';
            } else {
                $salt = hash::salt(32);
                $user->update(array(
                    'password' => hash::make(input::get('new_password'), $salt),
                    'salt' => $salt
                ));

                session::flash('home', 'Your password has been changed');
                redirect::to('index.php');

            }

        } else {
            foreach($validation->errors() as $error){
                echo '- ' . $error . '!!!<br>';
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

<div class="content">
    <div class="container">
        <div class="form-style">
            <h1>Change Password</h1>

            <form action="" method="post" name="changePassword">
                <input type="password" name="current_password" placeholder="Current Password" />
                <input type="password" name="new_password" placeholder="New Password" />
                <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                <input type="submit" value="CHANGE"/>
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