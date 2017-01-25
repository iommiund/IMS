<?php
/**
 * Created by PhpStorm.
 * User: lommi
 * Date: 23/01/2017
 * Time: 08:16 PM
 */
include_once ("header.php");
?>
    <div class="content">
        <div class="container">
            <div class="form-style">
                <form action="" method="post" name="searchCustomer">
                    <input type="text" name="customer" placeholder="Customer ID" autocomplete="off"/>
                    <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                    <input type="submit" value="Search"/>
                </form>
                <br><br><hr><br><br>
                <form action="" method="post" name="searchResource">
                    <input type="text" name="customer" placeholder="Resource ID" autocomplete="off"/>
                    <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                    <input type="submit" value="Search"/>
                </form>
            </div>
        </div>
    </div>