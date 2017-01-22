<?php
require_once 'core/init.php';

//Validate user input
if(input::exists()){

    // validate whether token exists before performing any action
    if(token::check(input::get('token'))){

        // if token validation passed continue
        $validate = new validate();
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
            ),
            'retype_password' => array(
                'required' => true,
                'matches' => 'password'
            )
        ));

        // display error or success messages
        if ($validation->passed()){
            $user = new user();

            $salt = hash::salt(32); // generate salt to insert into create array
            $name = input::get('name');
            $surname = input::get('surname');

            try {

                $user->create(array(
                    'name' => $name,
                    'surname' => $surname,
                    'email' => input::get('email'),
                    'username' => input::get('username'),
                    'password' => hash::make(input::get('password'), $salt),
                    'salt' => $salt,
                    'user_type_id' => 9,
                    'user_status_id' => 2
                ));

                //create message to display on user creation
                session::flash('addUserSuccess','<b>' . $name . ' ' . $surname . '</b> has been added as a new user!');
                redirect::to('index.php'); //redirect with session home to display message

            } catch (Exception $e){
                die($e->getMessage());
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
                <input type="password" name="retype_password" placeholder="Retype Password" /> <!-- required="required"/> -->
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