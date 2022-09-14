<?php
/**
 * DestroyableInterface implemented by any Entity that needs to be destroyed from 
 * Data Source/Storage.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/DestroyableInterface
 */

namespace Scandiweb\App\Http\Controllers\Contracts;

use Scandiweb\App\Http\Response\Contracts\ResponseInterface;

/**
 * DestroyableInterface implemented by any Entity that needs to be destroyed from 
 * Data Source/Storage.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/DestroyableInterface
 */
interface DestroyableInterface
{
    /**
     * Destroy List of Entities
     *
     * @return ResponseInterface
     */
    public function massDelete(): ResponseInterface;
}