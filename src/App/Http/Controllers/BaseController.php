<?php
/**
 * Base Controller to include coomon derived Controllers functionalities
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/Base Controller-class
 * @abstract
 */

namespace Scandiweb\App\Http\Controllers;

use Scandiweb\App\Http\Controllers\Contracts\ControllerInterface;
use Scandiweb\App\Http\Request\Contracts\HttpRequestInterface;
use Scandiweb\App\Http\Response\Contracts\ResponseInterface;

/**
 * Base Controller to include coomon derived Controllers functionalities
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/Base Controller-class
 * @abstract
 */
abstract class BaseController implements ControllerInterface
{

    public HttpRequestInterface $request;

    /**
     * Create a new controller instance.
     *
     * @param HttpRequestInterface $request  Reference to Client Request
     * @param ResponseInterface    $response Reference to Server Response
     *
     * @return void
     */
    public function __construct(
        HttpRequestInterface $request, 
        ResponseInterface $response
    ) {
        $this->request = $request;
        $this->response = $response;
    }
}
