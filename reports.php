<?php
require_once 'core/init.php';
include_once ("header.php");

if ($user->isLoggedIn()){

    //check if user has permission
    if ($user->hasPermission('reports') || $user->hasPermission('allAccess')){

        $inventory = new inventory();

        if(isset($_POST['exportSalesCsv'])){

            $inventory->exportSalesCsv();

        } else if(isset($_POST['exportReplaceCsv'])){

            $inventory->exportReplaceCsv();

        } else if(isset($_POST['exportCollectCsv'])){

            $inventory->exportCollectCsv();

        }

        ?>
        <div class="content">
            <div class="container">
            <?php
            $inventory->salesInYearChart();
            ?>
                <div class="form-style">
                    <form action="" method="post" name="exportSalesInYear">
                        <input type="submit" name="exportSalesCsv" value="Export to csv">
                    </form>
                </div>
            <?php
            $inventory->replaceInYearChart();
            ?>
                <div class="form-style">
                    <form action="" method="post" name="exportReplaceInYear">
                        <input type="submit" name="exportReplaceCsv" value="Export to csv">
                    </form>
                </div>
                <?php
            $inventory->collectInYearChart();
            ?>
                <div class="form-style">
                    <form action="" method="post" name="exportCollectInYear">
                        <input type="submit" name="exportCollectCsv" value="Export to csv">
                    </form>
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