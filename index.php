<?php
session_start();
define("APP_PATH",  __DIR__);
$app = new Yaf_Application(APP_PATH . "/conf/app.ini");
$app->run();