<?php

// Require init.php for core config and class auto load
require_once 'core/init.php';

$user = db::getInstance()->query("select * from ims_iommiunderwood.users");

if (!$user->count()) {
    echo 'No user';
} else {
    foreach ($user->results() as $user) {
        echo $user->user_username, '<br>';
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <title>IMS Login</title>
    <link rel='stylesheet prefetch'
          href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

</body>
</html>