<?php

require_once __DIR__."/../vendor/autoload.php";

$app = new Favoroute\Application();

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
|
*/
$app->post('/images', 'ImageController:post');

/*
|--------------------------------------------------------------------------
| Services
|--------------------------------------------------------------------------
|
*/
$app->container('db', function () {
    $dbh = new \PDO('mysql:host=localhost;dbname=favoroute', 'root', '1234');
    $dbh->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    return $dbh;
});

$app->container('imageUploader', function () {
    return new Favoroute\Service\ImageUploader\ThumborUploader();
});

$app->container('imageBuilder', function () {
    return new Favoroute\Service\Builder\ImageBuilder();
});

/*
|--------------------------------------------------------------------------
| Let's dance
|--------------------------------------------------------------------------
|
*/
$app->run();
