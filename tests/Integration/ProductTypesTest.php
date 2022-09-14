<?php

namespace Scandiweb\Test\Integration;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as HTTPClient;

final class ProductTypesTest extends TestCase
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
        $response = $this->_http->request('GET', 'products/types');
    
        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    
        $productTypes = json_decode($response->getBody())->{"data"};
        $this->assertIsArray($productTypes);
        
        if (!empty($productTypes)) {
            $firstRecord = $productTypes[0];
            $this->assertIsObject($firstRecord);
            $this->assertObjectHasAttribute('PK_ProductType', $firstRecord);
            $this->assertObjectHasAttribute('Description', $firstRecord);
            $this->assertObjectHasAttribute('IsActive', $firstRecord);
            $this->assertObjectHasAttribute('product_type_attributes', $firstRecord);
            $this->assertIsArray($firstRecord->product_type_attributes);

            if (!empty($firstRecord->product_type_attributes)) {
                $firstRecordAttributes = $firstRecord->product_type_attributes[0];
                $this->assertIsObject($firstRecordAttributes);
                $this->assertObjectHasAttribute('PK_AttributeID', $firstRecordAttributes);
                $this->assertObjectHasAttribute('AttributeName', $firstRecordAttributes);
                $this->assertObjectHasAttribute('AttributeMeasureUnit', $firstRecordAttributes);
                $this->assertObjectHasAttribute('BackendDataType', $firstRecordAttributes);
                $this->assertObjectHasAttribute('FrontendInputType', $firstRecordAttributes);
                $this->assertObjectHasAttribute('FrontendLabel', $firstRecordAttributes);
                $this->assertObjectHasAttribute('IsRequired', $firstRecordAttributes);
                $this->assertIsInt($firstRecordAttributes->IsRequired);
                $this->assertObjectHasAttribute('DefaultValue', $firstRecordAttributes);
                $this->assertObjectHasAttribute('Note', $firstRecordAttributes);
                $this->assertObjectHasAttribute('FK_ProductType', $firstRecordAttributes);
                $this->assertIsString($firstRecordAttributes->FK_ProductType);
            }
        }
    }
}
