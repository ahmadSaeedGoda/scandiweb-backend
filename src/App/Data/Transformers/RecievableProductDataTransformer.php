<?php
/**
 * RecievableProductDataTransformer structures the incoming data into an acceptable 
 * structure for the equivalent model.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/RecievableProductDataTransformer-class
 */

namespace Scandiweb\App\Data\Transformers;

/**
 * RecievableProductDataTransformer class
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/RecievableProductDataTransformer-class
 */
class RecievableProductDataTransformer implements TransformInterface
{
    /**
     * Transforms the incoming product data into an array of attributes that's 
     * acceptable by the Product data model in charge of persisting it.
     *
     * @param object $requestBody converted body from string|json to stdClass object
     * 
     * @return array
     */
    public function transformToStorableModel(object $requestBody): array
    {
        $storableModel = [];
        foreach ($requestBody as $key => $value) {
            if (!empty($requestBody->ProductAttributes)
                && 'ProductAttributes' === $key
            ) {
                $storableModel['productAttributes']
                    = $requestBody->ProductAttributes;
            } else {
                $storableModel['productData'][$key] = $value;
            }
        }
        return $storableModel;
    }
}
