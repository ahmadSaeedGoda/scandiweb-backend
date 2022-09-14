<?php
/**
 * HTTP Request interface Definition
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/HttpRequestInterface
 */

namespace Scandiweb\App\Http\Request\Contracts;

/**
 * HttpRequestInterface
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/HttpRequestInterface
 */
interface HttpRequestInterface
{
    /**
     * Strip query string (?foo=bar) and decode URI
     *
     * @return string
     */
    public function removeQueryStringfromUri(): string;

    /**
     * Gets the request format.
     *
     * @param string|null $default The default format
     *
     * @return string|null The request format
     */
    public function getFormat($default = 'json'): string;

    /**
     * Sets the request format.
     *
     * @param string       $format    The request format @see $format prop
     * @param array|string $mimeTypes 'application/json' e.g 'tetx/html', etc
     * 
     * @return void
     */
    public function setFormat($format, $mimeTypes): void;

    /**
     * Gets the mime type associated with the format.
     *
     * @param string $format The format
     *
     * @return string|null The associated mime type (null if not found)
     */
    public function getMimeType($format): ?array;

    /**
     * Get Request Body
     *
     * @return string
     */
    public function getBody(): string;

    /**
     * Setter for API Prefix
     *
     * @param string $prefix any URI to be used in Base URL
     * 
     * @return void
     */
    public function setAPIPrefix(string $prefix = 'api'): void;

    /**
     * Getter for API Prefix
     *
     * @return string
     */
    public function getAPIPrefix(): string;

    /**
     * Setter for API Version URI
     *
     * @param string $version any URI to be used in Base URL
     * 
     * @return void
     */
    public function setAPIVersion(string $version = 'v1'): void;

    /**
     * Getter for API Version
     *
     * @return string
     */
    public function getAPIVersion(): string;

    /**
     * Determines whther the client req asks for Json response
     *
     * @return boolean
     */
    public function wantsJson(): bool;
}
