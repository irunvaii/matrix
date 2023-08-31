<?php

include_once('common/init.db.php');
if (!defined('OK_LOADME')) {
    die("<title>Error!</title><body>Please read documentation!.</body>");
}

$iswebbaseurl = 1;
$websrcbasepath = "assets/";
$websrcpagepath = "webpage/evolve/";

include("{$websrcpagepath}home.php");

