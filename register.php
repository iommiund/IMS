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
    <script>
        $( function() {
            $( "#dialogOk" ).dialog({
                modal: true,
                buttons: {
                    Ok: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        } );
    </script>
</head>
<body>
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
                ?>
                <div id="dialogOk" title="Success">
                    <p>
                        <?php
                            echo '<b>' . $name . ' ' . $surname . '</b> was added with:<br><br>';
                            echo 'Username: ' . input::get('username') . '<br>';
                            echo 'Email: ' . input::get('email') . '<br>';
                        ?>
                        Current Status: <b>Disabled</b><br><br>
                        <b>Enable</b> from your admin page.</p>
                    </p>
                </div>
                <?php
            } catch (Exception $e){
                die($e->getMessage());
            }
        } else {
            ?>
            <div id="dialogOk" title="Error">
            <?php
            foreach ($validation->errors() as $error){
                echo "- " . $error . "", '<br>';
            }
            ?>
            </div>
                <?php
        }
    }
}

?>
<div class="content">
    <div class="container">
        <div class="form-style">
            <h1>Add a New User</h1>

            <form action="" method="post" name="addUser">
                <input type="text" name="name" placeholder="Name" autocomplete="off" value="<?php echo escape(input::get('name')); ?>" />
                <input type="text" name="surname" placeholder="Surname" autocomplete="off" value="<?php echo escape(input::get('surname')); ?>" />
                <input type="email" name="email" placeholder="Email" autocomplete="off" value="<?php echo escape(input::get('email')); ?>" />
                <input type="text" name="username" placeholder="Username" autocomplete="off" value="<?php echo escape(input::get('username')); ?>" />
                <input type="password" name="password" placeholder="Password" autocomplete="off" />
                <input type="password" name="retype_password" placeholder="Retype Password" autocomplete="off" />
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