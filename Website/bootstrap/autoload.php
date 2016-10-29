<?php

require_once(__DIR__ . '/../utils/database.php');
require_once __DIR__ . '/../Logger/Log.php';

spl_autoload_register("autoloadController");
spl_autoload_register("autoloadRouter");
spl_autoload_register("autoloadHelpers");

function autoloadController($className) {
    $filename = __DIR__ . "/../controller/" . $className . ".php";
    if (is_readable($filename)) {
        require_once $filename;
    }
}

function autoloadRouter($className) {
    $filename = __DIR__ . "/../Router/" . $className . ".php";
    if (is_readable($filename)) {
        require_once $filename;
    }
}

function autoloadHelpers($className) {
    $filename = __DIR__ . "/../Helpers/" . $className . ".php";
    if (is_readable($filename)) {
        require_once $filename;
    }
}
