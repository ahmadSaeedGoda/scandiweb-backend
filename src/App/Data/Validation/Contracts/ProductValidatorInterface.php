<?php
/**
 * ProductValidatorInterface for Product Validator class.
 * 
 * It respects the Product Business Logic.
 * 
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ProductValidatorInterface
 */

namespace Scandiweb\App\Data\Validation\Contracts;

use Respect\Validation\Exceptions\NestedValidationException;

/**
 * ProductValidatorInterface for Product Validator class.
 * 
 * It respects the Product Business Logic.
 * 
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ProductValidatorInterface
 */
interface ProductValidatorInterface
{
    /**
     * Validates the `deleteProducts` request data
     *
     * @param object $requestBody converted body from string|json to stdClass object
     * 
     * @return NestedValidationException|null
     */
    public function validateProductsDestroy(
        object $requestBody
    ): ?NestedValidationException;

    /**
     * Validates a given `SKU` request data
     *
     * @param string $sku An SKU prospect to be checked for usage by the frontend
     * 
     * @return NestedValidationException|null
     */
    public function validateSKU(string $sku): ?NestedValidationException;
}
