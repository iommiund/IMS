<?php

// Require init.php for core config and class auto load
require_once 'core/init.php';

/** get message from redirect
 *
if (session::exists('home')){
    echo session::flash('home');
}
 *
 */
redirect::to('login.php');

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