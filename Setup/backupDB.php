<?php

    $command = "C:\\xampp\\mysql\\bin\\mysqldump -B --add-drop-database ims_iommiunderwood -uroot > C:\\xampp\\htdocs\\IMS\\Setup\\ims_iommiunderwood.sql";

    exec($command, $output, $return_var);

?>