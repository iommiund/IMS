<?php
require_once 'core/init.php';
include_once ("header.php");

//$user = new user();

if ($user->isLoggedIn()){

    //check if user has permission
    if ($user->hasPermission('newInventory') || $user->hasPermission('allAccess')){
        //Validate user input
        if(input::exists()){

            // validate whether token exists before performing any action
            if(token::check(input::get('token'))){

                // if token validation passed continue
                $validate = new validate();
                $validation = $validate->check($_POST,array(
                    'resource_location_name' => array(
                        'required' => true,
                        'min' => 5,
                        'max' => 50,
                        'unique' => 'resource_locations'
                    ),
                    'resource_location_description' => array(
                        'required' => true,
                        'min' => 5,
                        'max' => 200
                    ),
                    'resource_location_type_id' => array('required' => true)
                ));

                // display error or success messages
                if ($validation->passed()){

                    $location = new location();

                    $name = escape(input::get('resource_location_name'));
                    $description = escape(input::get('resource_location_description'));
                    $type = escape(input::get('resource_location_type_id'));

                    try {

                        $location->createLocation(array(
                            'resource_location_name' => $name,
                            'resource_location_description' => $description,
                            'resource_location_type_id' => $type
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
                    <?php
                        if(!input::exists()) {
                            echo '<h1>Load From File</h1>';
                            echo '<form action="" method="post" name="loadTemp" enctype="multipart/form-data">';
                            echo '<input type="file" name="file"/><br><br>';
                            echo '<input type="hidden" name="token" value="<?php echo token::generate(); ?>">';
                            echo '<input type="submit" value="LOAD"/>';
                            echo '</form>';
                        }
                    ?>
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