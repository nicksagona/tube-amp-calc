<?php

$autoloader = include __DIR__ . '/../vendor/autoload.php';

try {
    $app = new Pop\Application($autoloader, include __DIR__ . '/../app/config/app.http.php');
    $app->register(new Calc\Module());
    $app->run();
} catch (\Exception $exception) {
    $app = new Calc\Module(include __DIR__ . '/../app/config/app.http.php');
    $app->httpError($exception);
}