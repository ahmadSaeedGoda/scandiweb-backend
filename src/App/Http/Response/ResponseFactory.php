<?php
/**
 * Where Response Type is determined as per request needs
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/response-factory-class
 */

namespace Scandiweb\App\Http\Response;

use Scandiweb\App\Http\Request\Contracts\HttpRequestInterface;
use Scandiweb\App\Http\Response\APIResponse;
use Scandiweb\App\Http\Response\Contracts\ResponseFactoryInterface;
use Scandiweb\App\Http\Response\Contracts\ResponseInterface;

/**
 * ResponseFactory class definition
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/response-factory-class
 */
class ResponseFactory implements ResponseFactoryInterface
{

    /**
     * Creates Factory Instance
     *
     * @param HttpRequestInterface $request Client Request
     */
    public function __construct(HttpRequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * Creates A Response Instance Accordingly
     *
     * @param string  $content Response Body, Defaults to empty string.
     * @param integer $status  Response Status Code, Defaults to 200.
     * @param array   $headers Response Headers for the client info.
     * 
     * @return ResponseInterface
     */
    public function createResponse(
        $content = '',
        int $status = 200,
        array $headers = []
    ): ResponseInterface {
        if ($this->request->wantsJson()) {
            return new APIResponse($content, $status, $headers);
        }
        
        return new DefaultResponse($content, $status, $headers);
    }
}
