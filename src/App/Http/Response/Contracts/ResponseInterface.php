<?php
/**
 * Response Interface
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ResponseInterface
 */

namespace Scandiweb\App\Http\Response\Contracts;

use Scandiweb\App\Http\Headers\Contracts\HeadersBagInterface;
use Scandiweb\App\Http\Request\Contracts\HttpRequestInterface;

/**
 * Response Interface
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ResponseInterface
 */
interface ResponseInterface
{
    public const HTTP_PROTOCOL_VERSION = 'HTTP/1.0';

    public const RESPONSE_HEADERS = [
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'OPTIONS,GET,POST,DELETE',
        'Access-Control-Allow-Headers' =>
            'Access-Control-Allow-Origin, Content-Type, '.
            'Access-Control-Allow-Methods, Access-Control-Allow-Headers,'.
            ' X-Requested-With',
    ];

    /**
     * Mandates Params/Args for creating instance
     *
     * @param string  $content Res Body
     * @param integer $status  Res Status
     * @param array   $headers Res Headers
     */
    public function __construct(
        $content = '', 
        int $status = 200, 
        array $headers = []
    );

    /**
     * Runs Some logic before sending
     *
     * @param HttpRequestInterface $request Client Req
     * 
     * @return ResponseInterface
     */
    public function prepare(HttpRequestInterface $request): ResponseInterface;

    /**
     * Sends Headers of Response to client
     *
     * @return ResponseInterface
     */
    public function sendHeaders(): ResponseInterface;

    /**
     * Send Res Body
     *
     * @return ResponseInterface
     */
    public function sendContent(): ResponseInterface;

    /**
     * Echo the result/resonse body
     *
     * @return ResponseInterface
     */
    public function send(): ResponseInterface;

    /**
     * Setter for Response Obj Headers
     *
     * @param array $headers Res Headers
     * 
     * @return ResponseInterface
     */
    public function setHeaders(array $headers = []): ResponseInterface;

    /**
     * Getter for Response Obj Headers
     *
     * @return HeadersBagInterface
     */
    public function getHeaders(): HeadersBagInterface;

    /**
     * Setter for Response Obj body
     *
     * @param string $content Res Body
     * 
     * @return ResponseInterface
     */
    public function setContent($content): ResponseInterface;

    /**
     * Getter for Response Obj body
     *
     * @return string
     */
    public function getContent(): string;

    /**
     * Setter for HTTP Protocol Version 
     *
     * @param string $version (1.0 or 1.1, maybe 2.0 and future versions)
     * 
     * @return ResponseInterface
     */
    public function setProtocolVersion(string $version): ResponseInterface;

    /**
     * Getter for HTTP Protocol Version 
     *
     * @return string
     */
    public function getProtocolVersion(): string;

    /**
     * Setter for Response Status Code
     *
     * @param integer $code Status Code
     * @param string  $text Status Text
     * 
     * @return ResponseInterface
     */
    public function setStatusCode(int $code, $text = null): ResponseInterface;

    /**
     * Getter for Response Status Code
     *
     * @return integer
     */
    public function getStatusCode(): int;

    /**
     * Setter for Response Charset
     *
     * @param string $charset Res Charset
     * 
     * @return ResponseInterface
     */
    public function setCharset(string $charset): ResponseInterface;

    /**
     * Getter for Response Charset
     *
     * @return string|null
     */
    public function getCharset(): ?string;

    /**
     * Getter for Response Date
     *
     * @return \DateTimeInterface|null
     */
    public function getDate(): ?\DateTimeInterface;

    /**
     * Setter for Response Date
     *
     * @param \DateTimeInterface $date Res DateTime
     * 
     * @return void
     */
    public function setDate(\DateTimeInterface $date);

    /**
     * Determines whether the response is valid to be sent
     *
     * @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
     *
     * @return boolean
     */
    public function isInvalid(): bool;

    /**
     * Determines whether the response contains just info or has a body
     *
     * @return boolean
     */
    public function isInformational(): bool;

    /**
     * Determines whether the response is successfull
     *
     * @return boolean
     */
    public function isSuccessful(): bool;

    /**
     * Determines whether the response is redirectional
     *
     * @return boolean
     */
    public function isRedirection(): bool;

    /**
     * Determines whether the request was bad or unprocessable
     *
     * @return boolean
     */
    public function isClientError(): bool;

    /**
     * Determines whether the response contains a server side errors
     *
     * @return boolean
     */
    public function isServerError(): bool;

    /**
     * Determines whether the response is OK
     *
     * @return boolean
     */
    public function isOk(): bool;

    /**
     * Determines whether the response is forbidden due to some conditions
     *
     * @return boolean
     */
    public function isForbidden(): bool;

    /**
     * Determines whether the response is a not found res
     *
     * @return boolean
     */
    public function isNotFound(): bool;

    /**
     * Determines whether the response has no body
     *
     * @return boolean
     */
    public function isEmpty(): bool;
}
