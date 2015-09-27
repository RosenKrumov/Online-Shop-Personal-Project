<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);

use Framework\App;

include '../../Framework/App.php';

$app = App::getInstance();
$db = new \Framework\DB\SimpleDB();
$app->run();
