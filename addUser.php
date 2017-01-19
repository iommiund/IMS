<?php
require_once 'core/init.php';

//Validate user input
if(input::exists()){

    // validate whether token exists before performing any action
    if(token::check(input::get('token'))){

        // if token validation passed continue
        $validate = new validation();
        $validation = $validate->check($_POST,array(
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            ),
            'surname' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            ),
            'email' => array(
                'required' => true,
                'max' => 50,
                'unique' => 'users'
            ),
            'username' => array(
                'required' => true,
                'min' => 4,
                'max' => 10,
                'unique' => 'users'
            ),
            'password' => array(
                'required' => true,
                'min' => 4
            )
        ));

        // display error or success messages
        if ($validation->passed()){
            echo 'New user added!!';
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

<div class="content">
    <div class="container">
        <div class="form-style">
            <h1>Add a New User</h1>

            <form action="" method="post" name="addUser">
                <input type="text" name="name" placeholder="Name" value="<?php echo escape(input::get('name')); ?>" /> <!-- required="required"/> -->
                <input type="text" name="surname" placeholder="Surname" value="<?php echo escape(input::get('surname')); ?>" /> <!-- required="required"/> -->
                <input type="email" name="email" placeholder="Email" value="<?php echo escape(input::get('email')); ?>" /> <!-- required="required"/> -->
                <input type="text" name="username" placeholder="Username" value="<?php echo escape(input::get('username')); ?>" /> <!-- required="required"/> -->
                <input type="password" name="password" placeholder="Password" /> <!-- required="required"/> -->
                <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
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