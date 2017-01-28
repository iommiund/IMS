<?php
require_once 'core/init.php';
include_once ("header.php");

//$user = new user();

if ($user->isLoggedIn()){

    //check if user has permission
    if ($user->hasPermission('addResourceStatus') || $user->hasPermission('allAccess')){
        //Validate user input
        if(input::exists()){

            // validate whether token exists before performing any action
            if(token::check(input::get('token'))){

                // if token validation passed continue
                $validate = new validate();
                $validation = $validate->check($_POST,array(
                    'resource_status' => array(
                        'required' => true,
                        'min' => 2,
                        'max' => 50,
                        'unique' => 'resource_statuses'
                    )
                ));

                // display error or success messages
                if ($validation->passed()){

                    $inventory = new inventory();

                    $status = escape(input::get('resource_status'));

                    try {

                        $inventory->createResourceStatus(array('resource_status' => $status));

                        //create message to display on user creation
                        ?>
                        <div id="dialogOk" title="Success">
                            <p>
                                <?php
                                echo '<b>' . $status . '</b> added successfully.';
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
                    <h1>Add a New Resource Status</h1>

                    <form action="" method="post" name="addResourceStatus">
                        <input type="text" name="resource_status" placeholder="New Status Name" autocomplete="off" value="<?php echo escape(input::get('resource_status')); ?>" />
                        <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                        <input type="submit" value="ADD RESOURCE STATUS"/>
                    </form>
                    <br>
                    <div class="form-link">
                        <a href="addResourceStatus.php">Clear Form</a>
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