<?php

namespace Scandiweb\Test\Integration;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as HTTPClient;

final class ProductsTest extends TestCase
{
    private $_http;

    public function setUp(): void
    {
        $this->_http = new HTTPClient(['base_uri' => getenv('BASE_URL')]);
    }

    public function tearDown(): void
    {
        $this->_http = null;
    }

    public function testGet()
    {
        $response = $this->_http->request('GET', 'products');
    
        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    
        $products = json_decode($response->getBody())->{"data"};
        $this->assertIsArray($products);
        
        if (!empty($products)) {
            $firstProduct = $products[0];
            $this->assertIsObject($firstProduct);
            $this->assertObjectHasAttribute('PK_ProductID', $firstProduct);
            $this->assertObjectHasAttribute('SKU', $firstProduct);
            $this->assertObjectHasAttribute('Name', $firstProduct);
            $this->assertObjectHasAttribute('Price', $firstProduct);
            $this->assertObjectHasAttribute('CurrencySymbol', $firstProduct);
            $this->assertObjectHasAttribute('FK_ProductType', $firstProduct);
            $this->assertObjectHasAttribute('product_attributes', $firstProduct);
            $this->assertIsArray($firstProduct->product_attributes);

            if (!empty($firstProduct->product_attributes)) {
                $firstProductAttributes = $firstProduct->product_attributes[0];
                $this->assertIsObject($firstProductAttributes);
                $this->assertObjectHasAttribute('PK_AttributeID', $firstProductAttributes);
                $this->assertObjectHasAttribute('AttributeName', $firstProductAttributes);
                $this->assertObjectHasAttribute('AttributeMeasureUnit', $firstProductAttributes);
                $this->assertObjectHasAttribute('BackendDataType', $firstProductAttributes);
                $this->assertObjectHasAttribute('FrontendInputType', $firstProductAttributes);
                $this->assertObjectHasAttribute('FrontendLabel', $firstProductAttributes);
                $this->assertObjectHasAttribute('IsRequired', $firstProductAttributes);
                $this->assertIsInt($firstProductAttributes->IsRequired);
                $this->assertObjectHasAttribute('DefaultValue', $firstProductAttributes);
                $this->assertObjectHasAttribute('Note', $firstProductAttributes);
                $this->assertObjectHasAttribute('FK_ProductType', $firstProductAttributes);
                $this->assertIsString($firstProductAttributes->FK_ProductType);

                $this->assertIsArray($firstProduct->attributes_values);

                if (!empty($firstProduct->attributes_values)) {
                    $firstAttributeValue = $firstProduct->attributes_values[0];
                    $this->assertIsObject($firstAttributeValue);
                    $this->assertObjectHasAttribute('FK_ProductID', $firstAttributeValue);
                    $this->assertObjectHasAttribute('FK_AttributeID', $firstAttributeValue);
                    $this->assertObjectHasAttribute('AttributeValue', $firstAttributeValue);
                }
            }
        }
    }

    public function testAdd(): string
    {
        $sku = $this->_getRandomSKU();

        $requestBody = <<<JSON
        {
            "SKU": "$sku",
            "Name": "Test Name",
            "Price": 1.99,
            "FK_ProductType": "Book",
            "ProductAttributes": {
                "weight": 1.75
            }
        }
        JSON;

        $response = $this->_http->request('POST', 'products', ['body' => $requestBody]);
    
        $this->assertEquals(201, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    
        $responseBody = json_decode($response->getBody());

        $this->assertTrue($responseBody->{"data"});

        return $sku;
    }

    public function testDelete()
    {
        // should be replaced dynamically, or revamp the testing methodology completely,
        // as it populates the main DB which is an anti pattern.
        $requestBody = <<<JSON
        {
            "destroyableProductsIDs": [20]
        }
        JSON;

        $response = $this->_http->request('DELETE', 'products', ['body' => $requestBody]);
    
        $this->assertEquals(202, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    
        $responseBody = json_decode($response->getBody());

        $this->assertTrue($responseBody->{"data"});
    }

    private function _getRandomSKU()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
        $sku = '';
        $length = 12;

        for ($i = 0; $i < $length; $i++) {
            $sku .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
    
        return $sku;
    }
}
