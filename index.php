<?php

session_start();

include_once $_SERVER['DOCUMENT_ROOT']."/core/Core.php";

$core = App\Core::getInstance();
$core->router->parseUrl();
