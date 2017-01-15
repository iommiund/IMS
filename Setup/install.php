<?php

include_once('/Config/config.php');

echo "starting install...<br><br>";

//insert dbdump in the same folder as install.php
if (empty($dbpass)) {
    $command = "C:\\xampp\\mysql\\bin\\mysql -u" . $dbuser . " < ims_iommiunderwood.sql";

    exec($command, $output, $return_var);

    $output = shell_exec($command);

    echo "database created<br><br>";

} else {

    $command = "C:\\xampp\\mysql\\bin\\mysql -u" . $dbuser . " -p" . $dbpass . " < ims_iommiunderwood.sql";

    exec($command, $output, $return_var);

    $output = shell_exec($command);

    echo "database created<br><br>";

}

?>