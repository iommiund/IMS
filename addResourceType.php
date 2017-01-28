<?php
require_once 'core/init.php';
include_once ("header.php");

//$user = new user();

if ($user->isLoggedIn()){

    //check if user has permission
    if ($user->hasPermission('addResourceType') || $user->hasPermission('allAccess')){
        //Validate user input
        if(input::exists()){

            // validate whether token exists before performing any action
            if(token::check(input::get('token'))){

                // if token validation passed continue
                $validate = new validate();
                $validation = $validate->check($_POST,array(
                    'resource_type' => array(
                        'required' => true,
                        'min' => 2,
                        'max' => 50,
                        'unique' => 'resource_types'
                    )
                ));

                // display error or success messages
                if ($validation->passed()){

                    $inventory = new inventory();

                    $type = escape(input::get('resource_type'));

                    try {

                        $inventory->createResourceType(array('resource_type' => $type));

                        //create message to display on user creation
                        ?>
                        <div id="dialogOk" title="Success">
                            <p>
                                <?php
                                echo '<b>' . $type . '</b> added successfully.';
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
                    <h1>Add a New Resource Type</h1>

                    <form action="" method="post" name="addResourceType">
                        <input type="text" name="resource_type" placeholder="New Type Name" autocomplete="off" value="<?php echo escape(input::get('resource_type')); ?>" />
                        <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                        <input type="submit" value="ADD RESOURCE TYPE"/>
                    </form>
                    <br>
                    <div class="form-link">
                        <a href="addResourceType.php">Clear Form</a>
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