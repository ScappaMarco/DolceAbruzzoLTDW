<?php
require_once __DIR__ .'/config/bootstrap.php';
require_once __DIR__ . "/config/StartSmarty.php";

$fc = new CFrontController();
$fc->run();

/**
 * To verify that smarty works out, you can run the 
 * following method:
 * $smarty->testInstall();
 */
?>