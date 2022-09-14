<?php
/**
 * HTTP Response Headers Interface
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/HeadersBagInterface
 */

namespace Scandiweb\App\Http\Headers\Contracts;

/**
 * HTTP Response Headers Interface
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/HeadersBagInterface
 */
interface HeadersBagInterface
{
    /**
     * Creates Instance
     *
     * @param array $headers An array of HTTP headers
     */
    public function __construct(array $headers = []);

    /**
     * Returns the headers.
     *
     * @return array An array of headers
     */
    public function all();

    /**
     * Returns the parameter keys.
     *
     * @return array An array of parameter keys
     */
    public function keys();

    /**
     * Replaces the current HTTP headers by a new set.
     *
     * @param array $headers An array of HTTP headers
     * 
     * @return void
     */
    public function replace(array $headers = []);

    /**
     * Adds new headers the current HTTP headers set.
     *
     * @param array $headers An array of HTTP headers
     * 
     * @return void
     */
    public function add(array $headers);

    /**
     * Returns a header value by name.
     *
     * @param string      $key     The header name
     * @param string|null $default The default value
     * @param bool        $first   Whether to return the first value or all header 
     *                             values
     *
     * @return string|string[]|null The first header value or default value if 
     * $first is true, an array of values otherwise
     */
    public function get($key, $default = null, $first = true);

    /**
     * Sets a header by name.
     *
     * @param string          $key     The key
     * @param string|string[] $values  The value or an array of values
     * @param bool            $replace Whether to replace the actual value or not 
     *                                 (true by default)
     * 
     * @return void
     */
    public function set($key, $values, $replace = true);

    /**
     * Returns true if the HTTP header is defined.
     *
     * @param string $key The HTTP header
     *
     * @return bool true if the parameter exists, false otherwise
     */
    public function has($key);

    /**
     * Returns true if the given HTTP header contains the given value.
     *
     * @param string $key   The HTTP header name
     * @param string $value The HTTP value
     *
     * @return bool true if the value is contained in the header, false otherwise
     */
    public function contains($key, $value);

    /**
     * Removes a header.
     *
     * @param string $key The HTTP header name
     * 
     * @return void
     */
    public function remove($key);

    /**
     * Returns the HTTP header value converted to a date.
     *
     * @param string    $key     The parameter key
     * @param \DateTime $default The default value
     *
     * @return \DateTime|null The parsed DateTime or the default value if the 
     *                        header does not exist
     *
     * @throws \RuntimeException When the HTTP header is not parseable
     */
    public function getDate($key, \DateTime $default = null);

    /**
     * Returns the number of headers.
     *
     * @return int The number of headers
     */
    public function count();
}
