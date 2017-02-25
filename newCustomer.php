<?php
require_once 'core/init.php';
include_once ("header.php");

//$user = new user();

if ($user->isLoggedIn()){

    //check if user has permission
    if ($user->hasPermission('newCustomer') || $user->hasPermission('allAccess')){
        //Validate user input
        if(input::exists()){

            // validate whether token exists before performing any action
            if(token::check(input::get('token'))){

                // if token validation passed continue
                $validate = new validate();
                $validation = $validate->check($_POST,array(
                    'customer_name' => array(
                        'required' => true,
                        'min' => 2,
                        'max' => 50
                    ),
                    'customer_surname' => array(
                        'required' => true,
                        'min' => 2,
                        'max' => 50
                    ),
                    'customer_email' => array(
                        'required' => true,
                        'max' => 50,
                        'unique' => 'customer_accounts'
                    ),
                    'customer_dob' => array(
                        'required' => true,
                        'adult' => true
                    ),
                    'nationality_id' => array('required' => true),
                    'town' => array('required' => true),
                    'street' => array('required' => true)
                ));

                // display error or success messages
                if ($validation->passed()){
                    $customer = new customer();

                    $name = escape(input::get('customer_name'));
                    $surname = escape(input::get('customer_surname'));
                    $email = escape(input::get('customer_email'));
                    $dob = escape(input::get('customer_dob'));
                    $nationality = escape(input::get('nationality_id'));
                    $town = escape(input::get('town'));
                    $street = escape(input::get('street'));

                    try {

                        $customer->createCustomer(array(
                            'customer_name' => $name,
                            'customer_surname' => $surname,
                            'customer_email' => $email,
                            'customer_dob' => $dob,
                            'nationality_id' => $nationality,
                            'town_id' => $town,
                            'street_id' => $street,
                            'customer_account_status_id' => 1
                        ));

                        //create message to display on user creation
                        ?>
                        <div id="dialogOk" title="Success">
                            <p>
                                <?php
                                echo '<b>' . $name . ' ' . $surname . '</b> was added as a new customer.';
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
                    <h1>Add a New Customer</h1>

                    <form action="" method="post" name="newCustomer">
                        <input type="text" name="customer_name" placeholder="Name" autocomplete="off" value="<?php echo escape(input::get('customer_name')); ?>" />
                        <input type="text" name="customer_surname" placeholder="Surname" autocomplete="off" value="<?php echo escape(input::get('customer_surname')); ?>" />
                        <input type="email" name="customer_email" placeholder="Email" autocomplete="off" value="<?php echo escape(input::get('customer_email')); ?>" />
                        <input type="date" name="customer_dob" autocomplete="off" value="<?php echo escape(input::get('customer_dob')); ?>"/>
                        <select name="nationality_id">
                            <option value="106">Malta</option>
                            <?php

                            $get = db::getInstance()->query("select nationality_id, nationality from nationalities where nationality_id <> 106 order by nationality_id");

                            if (!$get->count()) {
                                echo 'Empty List';
                            } else {

                                foreach ($get->results() as $n): ?>
                                    <option value="<?php echo escape($n->nationality_id); ?>">
                                        <?php echo escape($n->nationality); ?>
                                    </option>
                                <?php endforeach;

                            }
                            ?>
                        </select>
                        <select onchange="change_town()" id="towndd" name="town">
                            <option value="">------------------ Choose Town Of Residence ------------------</option>
                            <?php

                            $get = db::getInstance()->query("select town_id, town_name from towns order by 2");

                            if (!$get->count()) {
                                echo 'Empty List';
                            } else {

                                foreach ($get->results() as $t): ?>
                                    <option value="<?php echo escape($t->town_id); ?>">
                                        <?php echo escape($t->town_name); ?>
                                    </option>
                                <?php endforeach;

                            }
                            ?>
                        </select>
                        <div id="street">
                            <select id="streetdd" name="street" disabled>
                                <option value=""></option>
                            </select>
                        </div>
                        <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                        <input type="submit" value="ADD CUSTOMER"/>
                    </form>
                    <br>
                    <div class="form-link">
                        <a href="newCustomer.php">Clear Form</a>
                    </div>
                    <script type="text/javascript">
                        function change_town() {
                            var xmlhttp=new XMLHttpRequest();
                            xmlhttp.open("GET","streetdd.php?townId="+document.getElementById("towndd").value,false);
                            xmlhttp.send(null);
                            document.getElementById("street").innerHTML=xmlhttp.responseText;
                        }
                    </script>
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