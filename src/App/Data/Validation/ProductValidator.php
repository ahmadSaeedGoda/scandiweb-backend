<?php
/**
 * ProductValidator to make sure every request recieved for creating a new Product
 * record is valid & can be processed.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ProductValidator-class
 */

namespace Scandiweb\App\Data\Validation;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;
use Scandiweb\App\Data\Models\Product;
use Scandiweb\App\Data\Models\ProductType;
use Scandiweb\App\Data\Models\ProductTypeAttribute;
use Scandiweb\App\Data\Validation\Contracts\ProductValidatorInterface;
use Scandiweb\App\Data\Validation\Contracts\ValidatorInterface;

/**
 * ProductValidator to make sure every request recieved for creating a new Product
 * record is valid & can be processed.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ProductValidator-class
 * 
 * @uses Product
 * @uses ProductType
 * @uses ProductTypeAttribute
 * @uses ProductValidatorInterface
 * @uses ValidatorInterface
 */
class ProductValidator implements ValidatorInterface, ProductValidatorInterface
{
    /**
     * Validates the `addProduct` request data
     *
     * @param object $requestBody converted body from string|json to `stdClass` object
     * 
     * @return NestedValidationException|null
     */
    public function validate(object $requestBody): ?NestedValidationException
    {
        try {
            $productTypes = (new ProductType)
                ->where('IsActive', 1)
                ->pluck('PK_ProductType')
                ->toArray();

            if (true === empty($productTypes)) {
                $requestBodyValidator = v::alwaysInvalid()->assert($requestBody);
            }
            
            $requestBodyValidator = v::attribute(
                'SKU', 
                v::alnum('-')->noWhitespace()->length(6, 12, true)
            )
            ->attribute('Name', v::alnum(' ')->length(1, 255, true))
            ->attribute('Price', v::Positive())
            ->attribute(
                'FK_ProductType',
                v::in($productTypes)
            );

            $requestBodyValidator->assert($requestBody);

            $productTypeAttributes = (new ProductTypeAttribute)
                ->where('FK_ProductType', $requestBody->FK_ProductType)
                ->get();

            if (false === $productTypeAttributes->isEmpty()) {
                $productAttributesValidator = v::type('object');
    
                foreach ($productTypeAttributes as $record) {
                    if (1 === $record->IsRequired) {
                        $productAttributesValidator->attribute(
                            $record->AttributeName,
                            v::callback('is_' . $record->BackendDataType)
                        );
                    } elseif (0 === $record->IsRequired) {
                        $productAttributesValidator->attribute(
                            $record->AttributeName,
                            v::callback('is_' . $record->BackendDataType),
                            false // to let the validator know its optional
                        );
                    }
                }
                
                $requestBodyValidator = v::attribute(
                    'ProductAttributes',
                    $productAttributesValidator
                );
            
                $requestBodyValidator->assert($requestBody);
            }
        } catch(NestedValidationException $exception) {
            return $exception;
        }

        return null;
    }

    /**
     * Validates the `deleteProducts` request data
     *
     * @param object $requestBody converted body from string|json to stdClass object
     * 
     * @return NestedValidationException|null
     */
    public function validateProductsDestroy(
        object $requestBody
    ): ?NestedValidationException {
        try {
            $productsIDs = (new Product)->pluck('PK_ProductID')->toArray();

            if (true === empty($productsIDs)) {
                $requestBodyValidator = v::alwaysInvalid()->assert($requestBody);
            }

            $requestBodyValidator = v::objectType()
                ->attribute(
                    'destroyableProductsIDs',
                    v::arrayType()
                        ->length(1, count($productsIDs), true)
                        ->unique()
                        ->each(v::intType()->in($productsIDs, true))
                );

            $requestBodyValidator->assert($requestBody);
        } catch(NestedValidationException $exception) {
            return $exception;
        }

        return null;
    }

    /**
     * Validates a given `SKU` request data
     *
     * @param string $sku An SKU prospect to be checked for usage by the frontend
     * 
     * @return NestedValidationException|null
     */
    public function validateSKU(string $sku): ?NestedValidationException
    {
        try {
            $skuValidator = v::alnum('-')->noWhitespace()->length(6, 12, true);

            $skuValidator->assert($sku);
        } catch(NestedValidationException $exception) {
            return $exception;
        }

        return null;
    }
}
