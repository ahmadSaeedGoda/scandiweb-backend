<?php
/**
 * ValidatorInterface must be implemented by every Validator class.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ValidatorInterface
 */

namespace Scandiweb\App\Data\Validation\Contracts;

use Respect\Validation\Exceptions\NestedValidationException;

/**
 * ValidatorInterface must be implemented by every Validator class.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ValidatorInterface
 */
interface ValidatorInterface
{
    /**
     * Validates the request data
     *
     * @param object $requestBody converted body from string|json to stdClass object
     * 
     * @return NestedValidationException|null
     */
    public function validate(object $requestBody): ?NestedValidationException;
}
