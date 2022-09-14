<?php
/**
 * Response Factory Interface
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ResponseFactoryInterface
 */

namespace Scandiweb\App\Http\Response\Contracts;

use Scandiweb\App\Http\Request\Contracts\HttpRequestInterface;

/**
 * Response Factory Interface
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ResponseFactoryInterface
 */
interface ResponseFactoryInterface
{
    /**
     * Mandates constructor args
     *
     * @param HttpRequestInterface $request Client Req
     */
    function __construct(HttpRequestInterface $request);

    /**
     * Creates A Response Instance Accordingly
     *
     * @param string  $content Response Body, Defaults to empty string.
     * @param integer $status  Response Status Code, Defaults to 200.
     * @param array   $headers Response Headers for the client info.
     * 
     * @return ResponseInterface
     */
    function createResponse(
        $content = '',
        int $status = 200,
        array $headers = []
    ): ResponseInterface;
}
