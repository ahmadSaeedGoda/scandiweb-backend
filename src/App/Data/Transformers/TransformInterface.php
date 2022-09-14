<?php
/**
 * TransformInterface for Any Transformable Entity class
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/TransformInterface
 */

namespace Scandiweb\App\Data\Transformers;

/**
 * TransformInterface for Any Transformable Entity class.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/TransformInterface
 */
interface TransformInterface
{
    /**
     * Transforms the incoming data into an array of attributes that's acceptable
     * by the data model in charge of persisting it.
     *
     * @param object $requestBody converted body from string|json to stdClass object
     * 
     * @return array
     */
    public function transformToStorableModel(object $requestBody): array;
}
