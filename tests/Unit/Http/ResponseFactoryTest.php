<?php

namespace Scandiweb\Test\Unit\Http;

use PHPUnit\Framework\TestCase;
use Scandiweb\App\Http\Request\HttpRequest;
use Scandiweb\App\Http\Response\APIResponse;
use Scandiweb\App\Http\Response\DefaultResponse;
use Scandiweb\App\Http\Response\ResponseFactory;

final class ResponseFactoryTest extends TestCase
{

    public function testCreateResponse(): void
    {
        // create request stub to pass to the response factory constructor
        $requestStub = $this->createMock(HttpRequest::class);

        $response = (new ResponseFactory($requestStub))->createResponse();
        
        $this->assertInstanceOf(DefaultResponse::class, $response);

        // Re-create request stub to pass to configure before passing
        $requestStub = $this->createMock(HttpRequest::class);
        $requestStub->method('wantsJson')->willReturn(true);

        $response = (new ResponseFactory($requestStub))->createResponse();
        
        $this->assertInstanceOf(APIResponse::class, $response);
    }
}
