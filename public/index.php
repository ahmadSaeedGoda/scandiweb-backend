<?php
/**
 * Entry Point
 * Main entry point served by Proxy server "Nginx, Apache, ..."
 * php version 7.4.0
 * 
 * @category Entry_Point
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/index-file
 */

require_once __DIR__."/../bootstrap.php";

use Scandiweb\App\Http\HttpApp;

$app = new HttpApp();

$app->make();

$app->terminate();
