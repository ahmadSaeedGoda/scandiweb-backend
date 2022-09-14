<?php

namespace Scandiweb\Test\Unit\Util;

use PHPUnit\Framework\TestCase;
use Scandiweb\Exceptions\JsonDecodeException;
use Scandiweb\Util\JSON;

final class JsonUtilTest extends TestCase
{
    /**
     * @dataProvider jsonableProvider
     */
    public function testEncode(array $data): void
    {
        $json = JSON::encode($data);

        $this->assertJson($json);
    }

    public function testDecodeToObject(): void
    {
        $data = '{"foo-bar": 12345}';

        $object = JSON::decode($data);

        $this->assertIsObject($object);
        $this->assertObjectHasAttribute('foo-bar', $object);
    }

    public function testAttemptToDecodeMalformedJson(): void
    {
        $this->expectException(JsonDecodeException::class);

        $data = "{'foo-bar': 12345}";

        $object = JSON::decode($data);
    }

    public function testDecodeToArray(): void
    {
        $data = '{"foo-bar": 12345}';
        $expectsArray = true;

        $array = JSON::decode($data, $expectsArray);

        $this->assertIsArray($array);
        $this->assertArrayHasKey("foo-bar", $array);
    }

    public function jsonableProvider(): array
    {
        return [
            [
                'FirstTestArray' => 
                ['testKey1' => 'Test Value 1']
            ]
        ];
    }

    public function stringJsonProvider(): string
    {
        return '{"foo-bar": 12345}';
    }
}
