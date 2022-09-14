<?php
/**
 * Abstract Response Definition
 * All common/needed functionalities for derived/child classes gathered here.
 * 
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the SYMFONY_COPY_LICENSE
 * file that was distributed with this source code.
 * 
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/response-abstract-class
 */

namespace Scandiweb\App\Http\Response;

use Scandiweb\App\Http\Request\Contracts\HttpRequestInterface;
use Scandiweb\App\Http\Response\Contracts\ResponseInterface;
use Scandiweb\App\Http\Headers\Contracts\HeadersBagInterface;
use Scandiweb\App\Http\Headers\HeadersBag;

/**
 * Abstract Response Definition
 * All common/needed functionalities for derived/child classes gathered here.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/Response-abstract-class
 * @abstract
 */
abstract class Response implements ResponseInterface
{
    const HTTP_CONTINUE = 100;
    const HTTP_SWITCHING_PROTOCOLS = 101;
    const HTTP_PROCESSING = 102;            // RFC2518
    const HTTP_EARLY_HINTS = 103;           // RFC8297
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
    const HTTP_NO_CONTENT = 204;
    const HTTP_RESET_CONTENT = 205;
    const HTTP_PARTIAL_CONTENT = 206;
    const HTTP_MULTI_STATUS = 207;          // RFC4918
    const HTTP_ALREADY_REPORTED = 208;      // RFC5842
    const HTTP_IM_USED = 226;               // RFC3229
    const HTTP_MULTIPLE_CHOICES = 300;
    const HTTP_MOVED_PERMANENTLY = 301;
    const HTTP_FOUND = 302;
    const HTTP_SEE_OTHER = 303;
    const HTTP_NOT_MODIFIED = 304;
    const HTTP_USE_PROXY = 305;
    const HTTP_RESERVED = 306;
    const HTTP_TEMPORARY_REDIRECT = 307;
    const HTTP_PERMANENTLY_REDIRECT = 308;  // RFC7238
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_PAYMENT_REQUIRED = 402;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_NOT_ACCEPTABLE = 406;
    const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    const HTTP_REQUEST_TIMEOUT = 408;
    const HTTP_CONFLICT = 409;
    const HTTP_GONE = 410;
    const HTTP_LENGTH_REQUIRED = 411;
    const HTTP_PRECONDITION_FAILED = 412;
    const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
    const HTTP_REQUEST_URI_TOO_LONG = 414;
    const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const HTTP_EXPECTATION_FAILED = 417;
    const HTTP_I_AM_A_TEAPOT = 418;                                      // RFC2324
    const HTTP_MISDIRECTED_REQUEST = 421;                                // RFC7540
    const HTTP_UNPROCESSABLE_ENTITY = 422;                               // RFC4918
    const HTTP_LOCKED = 423;                                             // RFC4918
    const HTTP_FAILED_DEPENDENCY = 424;                                  // RFC4918

    /**
     * All remaining section exists but will be removed in future.
     * 
     * @deprecated
     */
    const HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL
        = 425; // RFC2817
    const HTTP_TOO_EARLY = 425;                        // RFC-ietf-httpbis-replay-04
    const HTTP_UPGRADE_REQUIRED = 426;                     // RFC2817
    const HTTP_PRECONDITION_REQUIRED = 428;                // RFC6585
    const HTTP_TOO_MANY_REQUESTS = 429;                    // RFC6585
    const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;      // RFC6585
    const HTTP_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_NOT_IMPLEMENTED = 501;
    const HTTP_BAD_GATEWAY = 502;
    const HTTP_SERVICE_UNAVAILABLE = 503;
    const HTTP_GATEWAY_TIMEOUT = 504;
    const HTTP_VERSION_NOT_SUPPORTED = 505;
    const HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506; // RFC2295
    const HTTP_INSUFFICIENT_STORAGE = 507;                 // RFC4918
    const HTTP_LOOP_DETECTED = 508;                        // RFC5842
    const HTTP_NOT_EXTENDED = 510;                         // RFC2774
    const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;      // RFC6585

    /**
     * Headers Obj Prop
     * 
     * @var HeadersBagInterface
     */
    public $headers;

    /**
     * Status codes translation table.
     *
     * The list of codes is complete according to the
     * {@link http://www.iana.org/assignments/http-status-codes/ 
     * Hypertext Transfer Protocol (HTTP) Status Code Registry}
     * (last updated 2016-03-01).
     *
     * Unless otherwise noted, the status code is defined in RFC2616.
     *
     * @var array
     */
    public static $statusTexts = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',            // RFC2518
        103 => 'Early Hints',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',          // RFC4918
        208 => 'Already Reported',      // RFC5842
        226 => 'IM Used',               // RFC3229
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',    // RFC7238
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',                    // RFC2324
        421 => 'Misdirected Request',              // RFC7540
        422 => 'Unprocessable Entity',             // RFC4918
        423 => 'Locked',                           // RFC4918
        424 => 'Failed Dependency',                // RFC4918
        425 => 'Too Early',                        // RFC-ietf-httpbis-replay-04
        426 => 'Upgrade Required',                 // RFC2817
        428 => 'Precondition Required',            // RFC6585
        429 => 'Too Many Requests',                // RFC6585
        431 => 'Request Header Fields Too Large',  // RFC6585
        451 => 'Unavailable For Legal Reasons',    // RFC7725
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',          // RFC2295
        507 => 'Insufficient Storage',             // RFC4918
        508 => 'Loop Detected',                    // RFC5842
        510 => 'Not Extended',                     // RFC2774
        511 => 'Network Authentication Required',  // RFC6585
    ];

    /**
     * Reponse Body
     * 
     * @var string
     */
    protected $content;

    /**
     * Status
     * 
     * @var int
     */
    protected $statusCode;

    /**
     * Response Status Text
     * 
     * @var string
     */
    protected $statusText;

    /**
     * HTTP Protocol Version
     * 
     * @var string
     */
    protected $httpProtocolVersion = self::HTTP_PROTOCOL_VERSION;

    /**
     * Creating Instance common logic for children instances.
     * 
     * @param string  $content Response Body, Defaults to empty string.
     * @param integer $status  Response Status Code, Defaults to 200.
     * @param array   $headers Response Headers for the client info.
     * 
     * @throws \InvalidArgumentException When the HTTP status code is not valid
     */
    public function __construct(
        $content = '',
        int $status = 200,
        array $headers = []
    ) {
        $this->headers = new HeadersBag($headers);
        $this->setContent($content);
        $this->setStatusCode($status);
        $this->setProtocolVersion(self::HTTP_PROTOCOL_VERSION);
    }

    /**
     * Prepares the Response before it is sent to the client.
     *
     * This method tweaks the Response to ensure that it is
     * compliant with RFC 2616. Most of the changes are based on
     * the Request that is "associated" with this Response.
     *
     * @param HttpRequestInterface $request Client Request
     * 
     * @return $this
     */
    public function prepare(HttpRequestInterface $request): ResponseInterface
    {
        $headers = $this->headers;

        if ($this->isInformational() || $this->isEmpty()) {
            $this->setContent(null);
            $headers->remove('Content-Type');
            $headers->remove('Content-Length');
        } else {
            // Content-type based on the Request
            if (!$headers->has('Content-Type')) {
                $format = $request->getFormat();
                if (null !== $format && $mimeType = $request->getMimeType($format)) {
                    $headers->set('Content-Type', $mimeType);
                }
            }
        }

        if (self::HTTP_PROTOCOL_VERSION != $request->serverProtocol) {
            $this->setProtocolVersion($request->serverProtocol);
        }

        return $this;
    }

    /**
     * Sends HTTP headers.
     *
     * @return $this
     */
    public function sendHeaders(): ResponseInterface
    {
        // headers have already been sent by the developer
        if (headers_sent()) {
            return $this;
        }
        // headers
        foreach ($this->headers->all() as $name => $values) {
            $replace = 0 === strcasecmp($name, 'Content-Type');
            foreach ($values as $value) {
                header($name.': '.$value, $replace, $this->statusCode);
            }
        }
        // status
        header(
            sprintf(
                '%s %s %s',
                $this->httpProtocolVersion,
                $this->statusCode,
                $this->statusText
            ),
            true, $this->statusCode
        );

        return $this;
    }

    /**
     * Sends content for the current web response.
     *
     * @return $this
     */
    public function sendContent(): ResponseInterface
    {
        echo $this->content;

        return $this;
    }

    /**
     * Sends HTTP headers and content.
     *
     * @return $this
     */
    public function send(): ResponseInterface
    {
        $this->sendHeaders();
        $this->sendContent();

        return $this;
    }

    /**
     * Sets the response headers if not set yet.
     *
     * @param array $headers [string, string]
     *
     * @return $this
     */
    public function setHeaders(array $headers = []): ResponseInterface
    {
        $this->headers = new HeadersBag($headers);
        return $this;
    }

    /**
     * Getter For Headers
     * 
     * @return HeadersBagInterface $headers
     */
    public function getHeaders(): HeadersBagInterface
    {
        return $this->headers;
    }

    /**
     * Sets the response content.
     *
     * Valid types are strings, numbers, null, and objects that implement a 
     * __toString() method.
     *
     * @param mixed $content Content that can be cast to string
     *
     * @return $this
     *
     * @throws \UnexpectedValueException
     */
    public function setContent($content): ResponseInterface
    {
        if (null !== $content 
            && !\is_string($content)
            && !is_numeric($content)
            && !\is_callable([$content, '__toString'])
        ) {
            throw new \UnexpectedValueException(
                sprintf(
                    'The Response content must be a string or object implementing __toString(), "%s" given.',
                    \gettype($content)
                )
            );
        }

        $this->content = (string) $content;

        return $this;
    }

    /**
     * Gets the current response content.
     *
     * @return string Content
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Sets the HTTP protocol version (1.0 or 1.1).
     *
     * @param string $version (1.0 or 1.1)
     * 
     * @return $this
     *
     * @final
     */
    public function setProtocolVersion(string $version): ResponseInterface
    {
        $this->httpProtocolVersion = $version;

        return $this;
    }

    /**
     * Gets the HTTP protocol version.
     *
     * @return string
     *
     * @final
     */
    public function getProtocolVersion(): string
    {
        return $this->httpProtocolVersion;
    }

    /**
     * Sets the response status code.
     *
     * If the status text is null it will be automatically populated for the known
     * status codes and left empty otherwise.
     *
     * @param int     $code 200/500/400 ...etc
     * @param ?string $text Response Status Text
     * 
     * @return $this
     *
     * @throws \InvalidArgumentException When the HTTP status code is not valid
     *
     * @final
     */
    public function setStatusCode(int $code, $text = null): ResponseInterface
    {
        $this->statusCode = $code;
        if ($this->isInvalid()) {
            throw new \InvalidArgumentException(
                sprintf('The HTTP status code "%s" is not valid.', $code)
            );
        }

        if (null === $text) {
            $this->statusText = isset(self::$statusTexts[$code]) ? 
                self::$statusTexts[$code] : 'unknown status';

            return $this;
        }

        if (false === $text) {
            $this->statusText = '';

            return $this;
        }

        $this->statusText = $text;

        return $this;
    }

    /**
     * Retrieves the status code for the current web response.
     *
     * @return int
     * 
     * @final
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Sets the response charset.
     *
     * @param string $charset UTF-8
     * 
     * @return $this
     *
     * @final
     */
    public function setCharset(string $charset): ResponseInterface
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * Retrieves the response charset.
     *
     * @return string|null
     *
     * @final
     */
    public function getCharset(): ?string
    {
        return $this->charset;
    }

    /**
     * Returns the Date header as a DateTime instance.
     *
     * @return \DateTimeInterface|null
     * 
     * @throws \RuntimeException When the header is not parseable
     *
     * @final
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->headers->getDate('Date');
    }

    /**
     * Sets the Date header.
     *
     * @param \DateTimeInterface $date 'Y:m:d H:i:s'
     * 
     * @return $this
     *
     * @final
     */
    public function setDate(\DateTimeInterface $date): ResponseInterface
    {
        if ($date instanceof \DateTime) {
            $date = \DateTimeImmutable::createFromMutable($date);
        }

        $this->headers->set('Date', $date->format('D, d M Y H:i:s').' GMT');

        return $this;
    }

    /**
     * Is response invalid?
     *
     * @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
     *
     * @return bool
     *
     * @final
     */
    public function isInvalid(): bool
    {
        return $this->statusCode < 100 || $this->statusCode >= 600;
    }

    /**
     * Is response informative?
     *
     * @return bool
     *
     * @final
     */
    public function isInformational(): bool
    {
        return $this->statusCode >= 100 && $this->statusCode < 200;
    }

    /**
     * Is response successful?
     *
     * @return bool
     *
     * @final
     */
    public function isSuccessful(): bool
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }

    /**
     * Is the response a redirect?
     *
     * @return bool
     *
     * @final
     */
    public function isRedirection(): bool
    {
        return $this->statusCode >= 300 && $this->statusCode < 400;
    }

    /**
     * Is there a client error?
     *
     * @return bool
     *
     * @final
     */
    public function isClientError(): bool
    {
        return $this->statusCode >= 400 && $this->statusCode < 500;
    }

    /**
     * Was there a server side error?
     *
     * @return bool
     *
     * @final
     */
    public function isServerError(): bool
    {
        return $this->statusCode >= 500 && $this->statusCode < 600;
    }

    /**
     * Is the response OK?
     *
     * @return bool
     *
     * @final
     */
    public function isOk(): bool
    {
        return 200 === $this->statusCode;
    }

    /**
     * Is the response forbidden?
     *
     * @return bool
     *
     * @final
     */
    public function isForbidden(): bool
    {
        return 403 === $this->statusCode;
    }

    /**
     * Is the response a not found error?
     *
     * @return bool
     *
     * @final
     */
    public function isNotFound(): bool
    {
        return 404 === $this->statusCode;
    }

    /**
     * Is the response empty?
     *
     * @return bool
     *
     * @final
     */
    public function isEmpty(): bool
    {
        return \in_array($this->statusCode, [204, 304]);
    }
}
