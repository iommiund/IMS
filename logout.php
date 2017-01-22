<?php
/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 18/01/2017
 * Time: 20:43
 */
require_once 'core/init.php';

$user = new user();
$user->logout();

redirect::to('index.php');