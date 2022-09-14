<?php
/**
 * StorableInterface implemented by any Entity that needs to be Persisted.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/StorableInterface
 */

namespace Scandiweb\App\Http\Controllers\Contracts;

use Scandiweb\App\Http\Response\Contracts\ResponseInterface;

/**
 * StorableInterface implemented by any Entity that needs to be Persisted.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/StorableInterface
 */
interface StorableInterface
{
    /**
     * Add new Entity, Create new record.
     *
     * @return ResponseInterface
     */
    public function addNew(): ResponseInterface;
}
