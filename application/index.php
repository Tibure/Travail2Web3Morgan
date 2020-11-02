<?php

    define('PATH_ROOT', str_replace("application/index.php", "", $_SERVER["SCRIPT_FILENAME"]));
    define('PATH_APPLICATION_ROOT', str_replace("index.php", "", $_SERVER["SCRIPT_FILENAME"]));
    define('PATH_VIEWS', PATH_APPLICATION_ROOT."Views");
    define('PATH_CONTROLLERS', PATH_APPLICATION_ROOT."Controllers");
    define('PATH_MODELS', PATH_APPLICATION_ROOT."Models");
    define('PATH_DTO', PATH_APPLICATION_ROOT."DTO");
    define('PATH_CORE', PATH_APPLICATION_ROOT."Core");
    define('PATH_PARSER', PATH_APPLICATION_ROOT."Parser");
    define('PATH_EXCEPTION', PATH_APPLICATION_ROOT."Exception");
    define('PATH_PUBLIC', "Public");
    require(PATH_APPLICATION_ROOT . 'dispatcher.php');

    $Dispatcher = new Dispatcher();
    $Dispatcher->dispatch();
?>