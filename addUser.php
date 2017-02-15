<?php
require_once 'core/init.php';
include_once ("header.php");

if ($user->isLoggedIn()){

    //check if user has permission
    if ($user->hasPermission('addUser') || $user->hasPermission('allAccess')){
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
                        'max' => 30,
                        'unique' => 'users'
                    ),
                    'password' => array(
                        'required' => true,
                        'min' => 4
                    ),
                    'retype_password' => array(
                        'required' => true,
                        'matches' => 'password'
                    ),
                    'location' => array('required' => true)
                ));

                // display error or success messages
                if ($validation->passed()){
                    $user = new user();

                    $salt = hash::salt(32); // generate salt to insert into create array
                    $name = escape(input::get('name'));
                    $surname = escape(input::get('surname'));

                    try {

                        $user->create(array(
                            'name' => $name,
                            'surname' => $surname,
                            'email' => escape(input::get('email')),
                            'username' => escape(input::get('username')),
                            'password' => escape(hash::make(input::get('password'), $salt)),
                            'salt' => $salt,
                            'user_type_id' => 9,
                            'user_status_id' => 2,
                            'resource_location_id' => escape(input::get('location'))
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
                            echo '&#x26a0; ' . $error . "", '<br>';
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
                        <input type="text" name="name" placeholder="Name" autocomplete="off" value="<?php echo escape(input::get('name')); ?>" required="required"/>
                        <input type="text" name="surname" placeholder="Surname" autocomplete="off" value="<?php echo escape(input::get('surname')); ?>" required="required"/>
                        <input type="text" name="username" placeholder="Username" autocomplete="off" value="<?php echo escape(input::get('username')); ?>" required="required"/>
                        <input type="email" name="email" placeholder="Email" autocomplete="off" value="<?php echo escape(input::get('email')); ?>" required="required"/>
                        <select name="location">
                            <option value="">---------------------- Choose a Location ----------------------</option>
                            <?php
                            $get = db::getInstance()->query('SELECT resource_location_id, resource_location_name FROM ims.resource_locations where resource_location_id <> 7 order by 1');

                            if (!$get->count()) {
                                echo 'Empty List';
                            } else {

                                foreach ($get->results() as $l): ?>
                                    <option value="<?php echo escape($l->resource_location_id); ?>">
                                        <?php echo escape($l->resource_location_name); ?>
                                    </option>
                                <?php endforeach;

                            }
                            ?>
                        </select>
                        <input type="password" name="password" placeholder="Password" autocomplete="off" required="required"/>
                        <input type="password" name="retype_password" placeholder="Retype Password" autocomplete="off" required="required"/>
                        <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                        <input type="submit" value="ADD USER"/>
                    </form>
                    <br>
                    <div class="form-link">
                        <a href="addUser.php">Clear Form</a>
                    </div>
                </div>
            </div>
        </div>
<?php
    } else {
        redirect::to('main.php');
    }

} else {
    $hash = new hash();
    redirect::to('index.php?' . hash::sha256('nologin' . $hash->getSalt()));
}