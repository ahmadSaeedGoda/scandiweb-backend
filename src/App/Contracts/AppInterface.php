<?php
/**
 * Application Interface
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/AppInterface
 */

namespace Scandiweb\App\Contracts;

/**
 * AppInterface
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/AppInterface
 */
interface AppInterface
{
    /**
     * Runs & Executes every step/procedure needed to 
     * generate the final result for the end user/client.
     *
     * @return void
     */
    public function make();

    /**
     * Shuts the Process Down
     *
     * @return void
     */
    public function terminate();
}