<?php
/**
 * RetrievableInterface implemented by any Entity that needs to be Retrieved from 
 * Data Source/Storage.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/RetrievableInterface
 */

namespace Scandiweb\App\Http\Controllers\Contracts;

use Scandiweb\App\Http\Response\Contracts\ResponseInterface;

/**
 * RetrievableInterface implemented by any Entity that needs to be Retrieved from 
 * Data Source/Storage.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/RetrievableInterface
 */
interface RetrievableInterface
{
    /**
     * Retrieve All Records & fill the response
     *
     * @return ResponseInterface
     */
    public function getAll(): ResponseInterface;
}
