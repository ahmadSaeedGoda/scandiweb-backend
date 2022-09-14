<?php
/**
 * Generic Abstract Error Handler.
 * To be inhereted by classes that are meant for specific use cases.
 * php version 7.4.0
 * 
 * @category Util
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ErrorHandlerWrapper-abstract-class
 */

namespace Scandiweb\Util;

/**
 * Generic Abstract Error Handler.
 * To be inhereted by classes that are meant for specific use cases.
 * php version 7.4.0
 * 
 * @category Util
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ErrorHandlerWrapper-abstract-class
 * @abstract
 */

abstract class ErrorHandlerWrapper implements CommandInterface
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
    public function execute(callable $func)
    {
        try {
            $func();
        } catch (\Throwable $error) {
            $this->handleError($error);
        }
    }

    /**
     * Gracefully Handles Error/Exception.
     *
     * @param \Throwable $error Any object adheres to \Throwbale interface.
     * 
     * @return void
     * 
     * @abstract
     */
    protected abstract function handleError(\Throwable $error);
}
