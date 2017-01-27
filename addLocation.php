<?php
require_once 'core/init.php';
include_once ("header.php");

//$user = new user();

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
                        'unique' => true,
                        'min' => 5,
                        'max' => 50
                    ),
                    'description' => array(
                        'required' => true,
                        'min' => 5,
                        'max' => 200
                    ),
                    'type' => array('required' => true)
                ));

                // display error or success messages
                if ($validation->passed()){
                    $location = new location();

                    $name = escape(input::get('name'));
                    $description = escape(input::get('description'));
                    $type = escape(input::get('type'));

                    try {

                        $location->createLocation(array(
                            'name' => $name,
                            'description' => $description,
                            'type' => $type
                        ));

                        //create message to display on user creation
                        ?>
                        <div id="dialogOk" title="Success">
                            <p>
                                <?php
                                echo '<b>' . $name . '</b> added successfully.';
                                ?>
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
                    <h1>Add a New Location</h1>

                    <form action="" method="post" name="addLocation">
                        <input type="text" name="name" placeholder="New Location Name" autocomplete="off" value="<?php echo escape(input::get('name')); ?>" />
                        <textarea name="description" placeholder="Type Location Description" autocomplete="off" value="<?php echo escape(input::get('description')); ?> maxlength="200"></textarea>
                        <select name="type">
                            <option value="">------------------------- Choose a Type -------------------------</option>
                            <?php
                            $get = db::getInstance()->query('select * from ims.resource_location_types order by 1');

                            if (!$get->count()) {
                                echo 'Empty List';
                            } else {

                                foreach ($get->results() as $t): ?>
                                    <option value="<?php echo escape($t->resource_location_type_id); ?>">
                                        <?php echo escape($t->resource_location_type); ?>
                                    </option>
                                <?php endforeach;

                            }
                            ?>
                        </select>
                        <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                        <input type="submit" value="ADD LOCATION"/>
                    </form>
                    <br>
                    <div class="form-link">
                        <a href="addLocation.php">Clear Form</a>
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