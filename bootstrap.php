<?php

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/
require_once __DIR__ . '/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Load App Secret Data
|--------------------------------------------------------------------------
|
| Use Dotenv package to load all the environment variables that are application
| specific and contains some sensitive data that can't be shared through the source code.
|
*/
use Dotenv\Dotenv;

$dotenv = DotEnv::createUnsafeImmutable(__DIR__);
$dotenv->load();
