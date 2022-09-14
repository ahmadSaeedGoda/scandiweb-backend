<?php
/**
 * Interface for any executable class or type.
 * Executable classes should implement this interface.
 * php version 7.4.0
 * 
 * @category Util
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/CommandInterface
 */

namespace Scandiweb\Util;

/**
 * Interface for any executable class or type.
 * Executable classes should implement this interface.
 * php version 7.4.0
 * 
 * @category Util
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/CommandInterface
 */

interface CommandInterface
{
    /**
     * This method is meant to just run a callable thing, in a way
     * that's standardized.
     * An example for a standard could be to run inside try/catch block
     * for error handling. 
     *
     * @param callable $func Anonymous function or any callable to be executed.
     * 
     * @return void
     */
    public function execute(callable $func);
}
