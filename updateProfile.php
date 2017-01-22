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
    if (token::check(input::get('token'))) {
        $validate = new validate();
        $validation = $validate->check($_POST, array(
            'name'=> array(
                'required' => true,
                'min' => 2,
                'max' => 50
            ),
            'surname' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            )
        ));

        if ($validation->passed()){

            try{
                $user->update(array(
                    'name' => input::get('name'),
                    'surname' => input::get('surname')
                ));

                session::flash('home', 'Your name has been changed.');
                redirect::to('index.php');

            } catch (Exception $e){
                die($e->getMessage());
            }

        } else {
            foreach($validation->errors() as $error) {
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
            <h1>Change Name or Surname</h1>

            <form action="" method="post" name="addUser">
                <input type="text" name="name" placeholder="Name" value="<?php echo escape($user->data()->name); ?>" />
                <input type="text" name="surname" placeholder="Surname" value="<?php echo escape($user->data()->surname); ?>" />
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
