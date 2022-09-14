<?php
/**
 * Application Definition
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/App-Abstract-class
 */

namespace Scandiweb\App;

use Scandiweb\App\Contracts\AppInterface;
use Scandiweb\App\Http\Request\Contracts\HttpRequestInterface;
use Scandiweb\App\Http\Response\Contracts\ResponseInterface;
use FastRoute\Dispatcher;

/**
 * Abstract App Class
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/App-Abstract-class
 * @abstract
 */
abstract class App implements AppInterface
{
    protected HttpRequestInterface $request;
    protected ResponseInterface $response;
    protected Dispatcher $dispatcher;

    /**
     * Runs & Executes every step/procedure needed to 
     * generate the final result for the end user/client.
     *
     * @return void
     */
    abstract public function make();

    /**
     * Shuts the Process Down
     *
     * @return void
     */
    abstract public function terminate();
}
