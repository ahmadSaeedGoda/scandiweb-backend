<?php

namespace Scandiweb\Test\Integration;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as HTTPClient;
use Scandiweb\App\Data\Models\Product;
use Scandiweb\Database\Configuration\Configuration;
use Scandiweb\Database\DatabaseManager;

final class ProductsTest extends TestCase
{
    private $_http;

    public function setUp(): void
    {
        $this->_http = new HTTPClient(['base_uri' => 'http://www.scandiweb.local/api/v1/']);
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

    /**
     * @depends testAdd
     */
    public function testDelete(string $sku)
    {
        $databaseConfig = new Configuration(
            getenv('MYSQL_DB_DRIVER'),
            getenv('MYSQL_DB_HOST'),
            getenv('MYSQL_DB_PORT'),
            getenv('MYSQL_DB_DATABASE'),
            getenv('MYSQL_DB_USERNAME'),
            getenv('MYSQL_DB_PASSWORD'),
        );

        $this->databaseManager = new DatabaseManager($databaseConfig);
        
        $productsIDs = (new Product)->where('SKU', $sku)->pluck('PK_ProductID')->toArray();

        $requestBody = <<<JSON
        {
            "destroyableProductsIDs": [$productsIDs[0]]
        }
        JSON;

        $response = $this->_http->request('DELETE', 'products', ['body' => $requestBody]);
    
        $this->assertEquals(202, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    
        $responseBody = json_decode($response->getBody());

        $this->assertTrue($responseBody->{"data"});
    }

    private function _getRandomSKU() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
        $sku = '';
        $length = 12;

        for ($i = 0; $i < $length; $i++) {
            $sku .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
    
        return $sku;
    }
}
