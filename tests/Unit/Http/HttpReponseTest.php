<?php

namespace Scandiweb\Test\Unit\Http;

use PHPUnit\Framework\TestCase;
use Scandiweb\App\Http\Headers\HeadersBag;
use Scandiweb\App\Http\Request\HttpRequest;
use Scandiweb\App\Http\Response\Response;

final class HttpReponseTest extends TestCase
{
    private $_response;

    public function setUp(): void
    {
        $this->_response = $this->getMockForAbstractClass(Response::class);
    }

    public function tearDown(): void
    {
        $this->_response = null;
    }


    public function invalidResponseCodes(): array
    {
        return [[99], [600], [601], [-1], [0], [15], [1000]];
    }

    /**
     * @dataProvider invalidResponseCodes
     */
    public function testIsInvalidResponse(int $statusCode): void
    {
        $this->expectException(\InvalidArgumentException::class);
        
        $this->_response->setStatusCode($statusCode);
    }

    public function informationalResponseCodes(): array
    {
        return [[100], [101], [102], [103]];
    }

    /**
     * @dataProvider informationalResponseCodes
     */
    public function testIsInformational(int $statusCode): void
    {
        $this->_response->setStatusCode($statusCode);

        $this->assertTrue($this->_response->isInformational());
    }

    public function nonInformationalResponseCodes(): array
    {
        return [
            [200], [226], [303],
            [204], [405], [411],
            [424], [503], [511]
        ];
    }

    /**
     * @dataProvider nonInformationalResponseCodes
     */
    public function testIsNotInformationalResponse(int $statusCode): void
    {
        $this->_response->setStatusCode($statusCode);

        $this->assertFalse($this->_response->isInformational());
    }

    public function isSuccessfulResponseCodes(): array
    {
        return [
            [200], [201], [202],
            [203], [204], [205],
            [206], [207], [208],
            [226]
        ];
    }

    /**
     * @dataProvider isSuccessfulResponseCodes
     */
    public function testIsSuccessfulResponse(int $statusCode): void
    {
        $this->_response->setStatusCode($statusCode);

        $this->assertTrue($this->_response->isSuccessful());
    }

    public function isNotSuccessfulResponseCodes(): array
    {
        return [
            [102], [103], [300],
            [301], [404], [407],
            [414], [422], [500],
        ];
    }

    /**
     * @dataProvider isNotSuccessfulResponseCodes
     */
    public function testIsNotSuccessfulResponse(int $statusCode): void
    {
        $this->_response->setStatusCode($statusCode);

        $this->assertFalse($this->_response->isSuccessful());
    }

    public function isRedirectionResponseCodes(): array
    {
        return [
            [300], [301], [302],
            [303], [304], [305],
            [306], [307], [308],
        ];
    }

    /**
     * @dataProvider isRedirectionResponseCodes
     */
    public function testIsRedirectionResponse(int $statusCode): void
    {
        $this->_response->setStatusCode($statusCode);

        $this->assertTrue($this->_response->isRedirection());
    }

    public function isNotRedirectionResponseCodes(): array
    {
        return [
            [100], [202], [204],
            [400], [403], [404],
            [410], [501], [502],
        ];
    }

    /**
     * @dataProvider isNotRedirectionResponseCodes
     */
    public function testIsNotRedirectionResponse(int $statusCode): void
    {
        $this->_response->setStatusCode($statusCode);

        $this->assertFalse($this->_response->isRedirection());
    }

    public function isClientErrorResponseCodes(): array
    {
        return [
            [400], [401], [402],
            [403], [404], [405],
            [406], [407], [408],
            [409], [410], [411],
            [412], [413], [414],
            [415], [416], [417],
            [418], [421], [422],
            [423], [424], [425],
            [426], [428], [429],
            [431], [451]
        ];
    }

    /**
     * @dataProvider isClientErrorResponseCodes
     */
    public function testIsClientErrorResponse(int $statusCode): void
    {
        $this->_response->setStatusCode($statusCode);

        $this->assertTrue($this->_response->isClientError());
    }

    public function isServerErrorResponseCodes(): array
    {
        return [
            [500], [501], [502],
            [503], [504], [505],
            [506], [507], [508],
            [510], [511]
        ];
    }

    /**
     * @dataProvider isServerErrorResponseCodes
     */
    public function testIsServerErrorResponse(int $statusCode): void
    {
        $this->_response->setStatusCode($statusCode);

        $this->assertTrue($this->_response->isServerError());
    }

    public function isNotServerErrorResponseCodes(): array
    {
        return [
            [100], [200], [201],
            [202], [204], [400],
            [403], [404], [405]
        ];
    }

    /**
     * @dataProvider isNotServerErrorResponseCodes
     */
    public function testIsNotServerErrorResponse(int $statusCode): void
    {
        $this->_response->setStatusCode($statusCode);

        $this->assertFalse($this->_response->isServerError());
    }

    public function testIsOk(): void
    {
        $this->_response->setStatusCode(200);

        $this->assertTrue($this->_response->isOk());
    }

    public function testIsForbidden(): void
    {
        $this->_response->setStatusCode(403);

        $this->assertTrue($this->_response->isForbidden());
    }

    public function testIsNotFound(): void
    {
        $this->_response->setStatusCode(404);

        $this->assertTrue($this->_response->isNotFound());
    }

    public function testIsEmpty(): void
    {
        $this->_response->setStatusCode(204);
        $this->assertTrue($this->_response->isEmpty());

        $this->_response->setStatusCode(304);
        $this->assertTrue($this->_response->isEmpty());
    }

    public function testSetDate(): void
    {
        $date = new \DateTimeImmutable;
        
        $this->_response->setDate($date);

        $this->assertSame($date->getTimestamp(), $this->_response->getDate()->getTimestamp());
    }

    public function testPrepareResponse(): void
    {
        $this->_response->setStatusCode(204);
        $this->_response->setHeaders(
            ['Content-Type' => 'text/html', 'Content-Length' => 50]
        );
        
        // create request stub to pass to the method `prepare`
        $requestStub = $this->createMock(HttpRequest::class);
        $requestStub->serverProtocol = 'HTTP/1.1';

        // configure the stub, add needed props & methods that `prepare` use
        $requestStub->method('getFormat')
            ->with($this->equalTo('json'))
            ->willReturn('json');
        $requestStub->method('getMimeType')
            ->with($this->equalTo('json'))
            ->willReturn(['application/json']);

        $this->_response->prepare($requestStub);

        $this->assertSame('', $this->_response->getContent());
        $this->assertFalse($this->_response->getHeaders()->has('Content-Type'));
        $this->assertFalse($this->_response->getHeaders()->has('Content-Length'));
        
        $this->_response->setStatusCode(200);
        $this->_response->prepare($requestStub);
        $this->assertTrue($this->_response->getHeaders()->has('Content-Type'));
        $this->assertSame('application/json', $this->_response->getHeaders()->get('Content-Type'));
        $this->assertSame('HTTP/1.1', $this->_response->getProtocolVersion());
    }

    public function testContent(): void
    {
        $content = 'Hello, World!';
        
        $this->_response->setContent($content);

        $this->assertSame($content, $this->_response->getContent());
    }

    public function testValidResponseBody(): void
    {
        $content = 'This is String Content';

        $this->_response->setContent($content);

        $this->assertSame($content, $this->_response->getContent());

        $content = 1000;

        $this->_response->setContent($content);

        $this->assertSame((string) $content, $this->_response->getContent());

        $content = null;

        $this->_response->setContent($content);

        $this->assertSame('', $this->_response->getContent());

        $content = new class implements \Stringable
        {

            public function __toString(): string
            {
                return "I am an object of class ". get_class();
            }
        
        };

        $this->_response->setContent($content);

        $this->assertSame($content->__toString(), $this->_response->getContent());
    }

    public function testInvalidContent(): void
    {
        $content = [];

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage(
            sprintf(
                'The Response content must be a string or object implementing __toString(), "%s" given.',
                \gettype($content)
            )
        );

        $this->_response->setContent($content);
    }

    public function testProtocolVersion(): void
    {
        $httpProtocolVersion = 'HTTP/2.0';
        
        $this->_response->setProtocolVersion($httpProtocolVersion);

        $this->assertSame($httpProtocolVersion, $this->_response->getProtocolVersion());
    }

    public function testStatusCode(): void
    {
        $this->_response->setStatusCode(418);
        
        $this->assertSame(418, $this->_response->getStatusCode());

        $this->_response->setStatusCode(511);

        $this->assertSame(511, $this->_response->getStatusCode());
    }

    public function testHeaders(): void
    {
        $this->_response->setHeaders(['Accept' => '*/*']);
        
        $this->assertInstanceOf(HeadersBag::class, $this->_response->getHeaders());
    }

    public function testSend(): void
    {
        $content = 'Testing Method Send!';
        
        $this->_response->setContent($content);

        $this->expectOutputString($content);
        
        $this->_response->send();
    }
}
