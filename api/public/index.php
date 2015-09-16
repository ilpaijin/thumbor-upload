<?php

require_once __DIR__."/../vendor/autoload.php";

$app = new Favoroute\Application();

$app->post('/images', 'ImageController:post');

$app->run();
