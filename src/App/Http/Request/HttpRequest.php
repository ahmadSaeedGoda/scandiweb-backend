<?php
/**
 * HttpRequest Definition
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/HttpRequest-class
 */

namespace Scandiweb\App\Http\Request;

use Scandiweb\App\Http\Request\Contracts\HttpRequestInterface;
use Scandiweb\App\Http\Request\Traits\RestfulUtilities;

/**
 * HttpRequest Class
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/HttpRequest-class
 * @uses     RestfulUtilities Trait
 */
class HttpRequest implements HttpRequestInterface
{
    use RestfulUtilities;

    /**
     * Request Format (html, json, xml, ...)
     * 
     * @var string
     */
    protected $format;

    /**
     * Available standardized request formats
     * 
     * @var array
     */
    protected static $formats;

    /**
     * Create new
     */
    public function __construct()
    {
        $this->_bootstrapSelf();
    }

    /**
     * Strip query string (?foo=bar) and decode URI
     *
     * @return string
     */
    public function removeQueryStringfromUri(): string
    {
        if (false !== $pos = strpos($this->requestUri, '?')) {
            $this->requestUri = substr($this->requestUri, 0, $pos);
        }
        return rawurldecode($this->requestUri);
    }

    /**
     * Get Request Body
     *
     * @return string
     */
    public function getBody(): string
    {
        switch ($this->requestMethod) {
        case 'GET':
            return '';
            break;

        default:
            $input = file_get_contents('php://input');
            return (false === $input)? '' : $input;
            break;
        }
    }

    /**
     * Gets the request format.
     *
     * @param string|null $default The default format
     *
     * @return string|null The request format
     */
    public function getFormat($default = 'json'): string
    {
        if (null === static::$formats) {
            static::initializeFormats();
        }

        return null === $this->format ? $default : $this->format;
    }

    /**
     * Sets the request format.
     *
     * @param string       $format    The request format @see $format prop
     * @param array|string $mimeTypes 'application/json' e.g 'tetx/html', etc
     * 
     * @return void
     */
    public function setFormat($format, $mimeTypes): void
    {
        if (null === static::$formats) {
            static::initializeFormats();
        }

        static::$formats[$format] = \is_array($mimeTypes) ? 
            $mimeTypes : 
            [$mimeTypes];
    }

    /**
     * Gets the mime type associated with the format.
     *
     * @param string $format The format
     *
     * @return string|null The associated mime type (null if not found)
     */
    public function getMimeType($format): ?array
    {
        if (null === static::$formats) {
            static::initializeFormats();
        }

        return isset(static::$formats[$format]) ? static::$formats[$format] : null;
    }

    /**
     * Initializes HTTP request formats.
     *
     * @return void
     */
    protected static function initializeFormats()
    {
        /**
         * This app only supports json format currently! method `setFormat` can be 
         * used to add more (should be standardized before calling it).
         */
        static::$formats = [
            'json' => ['application/json'],
        ];
    }

    /**
     * Creates all req props dynamically as public access
     *
     * @return void
     */
    private function _bootstrapSelf(): void
    {
        foreach ($_SERVER as $key => $value) {
            $this->{$this->_toCamelCase($key)} = $value;
        }
    }

    /**
     * Helper Func to convert underscored or $SERVER keys into camelCased
     *
     * @param string $string $SERVER GLOBAL ARRAY KEYS
     * 
     * @return string
     */
    private function _toCamelCase($string): string
    {
        $result = strtolower($string);

        preg_match_all('/_[a-z]/', $result, $matches);

        foreach ($matches[0] as $match) {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }
}
