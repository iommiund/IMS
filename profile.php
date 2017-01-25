<?php
/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 18/01/2017
 * Time: 20:43
 */
include_once ("header.php");

$user = new user();

$name = escape($user->data()->name);
$surname = escape($user->data()->surname);
$username = escape($user->data()->username);
$email = escape($user->data()->email);
$profile = escape($user->profile());

if ($user->isLoggedIn()){
    ?>
    <div class="content">
        <div class="container">
            <!-- User Information -->
            <?php
            //full name
            echo '<h1>' . $name . ' ' . $surname . '</h1>';

            //Profile type
            echo '<b>Profile:</b> ' . $profile . '<br>';

            //username
            echo '<b>Username:</b> ' . $username . '<br>';

            //email
            echo '<b>Email:</b> ' . $email . '<br><br>';

            ?>
            <!-- User Information End -->
              <!-- Change Password -->
            <?php
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
                            ),
                            'retype_new_password' => array(
                                'required' => true,
                                'matches' => 'new_password'
                            )
                        ));

                        if($validation->passed()){

                            if (hash::make(input::get('current_password'), $user->data()->salt) !== $user->data()->password){
                                ?>
                                    <div id="dialogOk" title="Error">
                                        <?php
                                            echo 'Your current password is incorrect';
                                        ?>
                                    </div>
                                <?php
                            } else {
                                $salt = hash::salt(32);
                                $user->update(array(
                                    'password' => hash::make(input::get('new_password'), $salt),
                                    'salt' => $salt
                                ));

                                $user->logout();
                                $hash = new hash();
                                redirect::to('index.php?' . hash::sha256('changePassword' . $hash->getSalt()));

                            }

                        } else {
                            ?>
                            <div id="dialogOk" title="Error">
                                <?php
                                foreach ($validation->errors() as $error){
                                    echo "&#x26a0; " . $error . "", '<br>';
                                }
                                ?>
                            </div>
                            <?php
                        }
                    }
                }
            ?>
            <div class="form-style">
                <h1>Change Password</h1>

                <form action="" method="post" name="changePassword">
                    <input type="password" name="current_password" placeholder="Current Password" />
                    <input type="password" name="new_password" placeholder="New Password" />
                    <input type="password" name="retype_new_password" placeholder="Retype New Password" />
                    <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                    <input type="submit" value="CHANGE"/>
                </form>
            </div>
        </div>
    </div>
    <?php
} else {
    $hash = new hash();
    redirect::to('index.php?' . hash::sha256('nologin' . $hash->getSalt()));
}



