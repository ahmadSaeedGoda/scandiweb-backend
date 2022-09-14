<?php

namespace Scandiweb\Test\Unit\Http;

use PHPUnit\Framework\TestCase;
use Scandiweb\App\Http\Request\HttpRequest;

final class HttpRequestTest extends TestCase
{
    public function testStub(): void
    {
        $stub = $this->createStub(HttpRequest::class);

        $stub->method('getFormat')->willReturn('json');

        $this->assertSame('json', $stub->getFormat());
    }
}
