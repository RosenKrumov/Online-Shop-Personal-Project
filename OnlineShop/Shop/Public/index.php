<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
ini_set('display_errors', 1);

use Framework\App;

include '../../Framework/App.php';

$app = App::getInstance();
$app->run();
