<?php
/**
 * ControllerInterface implemented by Abstract Parent Controller class that must
 * be extended by all controller classes.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ControllerInterface
 */

namespace Scandiweb\App\Http\Controllers\Contracts;

use Scandiweb\App\Http\Request\Contracts\HttpRequestInterface;
use Scandiweb\App\Http\Response\Contracts\ResponseInterface;

/**
 * ControllerInterface implemented by Abstract Parent Controller class that must
 * be extended by all controller classes.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ControllerInterface
 */
interface ControllerInterface
{

    /**
     * Dectates the declaration of how every controller should be instantiated.
     *
     * @param HttpRequestInterface $request  Reference to Client Request
     * @param ResponseInterface    $response Reference to Server Response
     *
     * @return void
     */
    public function __construct(
        HttpRequestInterface $request, 
        ResponseInterface $response
    );
}
