<?php
/**
 * JSON Encode/Decode Wrapper.
 * Just a Wrapper class to make sure encoding/decoding is done correctly.
 * php version 7.4.0
 * 
 * @category Util
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/JSON-class
 */

namespace Scandiweb\Util;

use Scandiweb\Exceptions\JsonEncodeException;
use Scandiweb\Exceptions\JsonDecodeException;

/**
 * JSON Encode/Decode Wrapper.
 * This class provides some utility methods to encode/decode JSON data.
 * php version 7.4.0
 * 
 * @category Util
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/JSON-class
 */

final class JSON
{
    /**
     * Encodes the given data into JSON.
     *
     * @param array $data The data to encode, must be of type array
     *
     * @return string
     *
     * @throws JsonEncodeException If the encoding failed
     */
    public static function encode(array $data): string
    {
        $encodedData = json_encode($data);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new JsonEncodeException(
                sprintf(
                    'Could not encode value into JSON format. Error was: "%s".',
                    json_last_error_msg()
                )
            );
        }

        return $encodedData;
    }

    /**
     * Decodes the given data from JSON.
     *
     * @param string $data       The data to decode.
     * @param bool   $wantsArray Whether the user needs an array to be returned.
     *
     * @return mixed
     *
     * @throws JsonDecodeException If the decoding failed
     */
    public static function decode(string $data, bool $wantsArray = false)
    {
        $decodedData = json_decode($data, $wantsArray);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new JsonDecodeException(
                sprintf(
                    'Could not decode value from JSON format. Error was: "%s".',
                    json_last_error_msg()
                )
            );
        }

        return $decodedData;
    }
}
