<?php
/**
 * Concrete App Definition
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/http-app-class
 */

namespace Scandiweb\App\Http;

use FastRoute\Dispatcher;
use Scandiweb\App\App as AbstractApp;
use Scandiweb\App\Http\Request\Contracts\HttpRequestInterface;
use Scandiweb\App\Http\Request\HttpRequest;
use Scandiweb\App\Http\Response\Contracts\ResponseInterface;
use Scandiweb\App\Http\Response\Response;
use Scandiweb\App\Http\Response\ResponseFactory;
use Scandiweb\Database\Configuration\Configuration;
use Scandiweb\Database\DatabaseManager;
use Scandiweb\Util\ReportSpecificErrorsWrapper;

/**
 * Concrete Class that define App implementation
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/http-app-class
 */
class HttpApp extends AbstractApp
{
    protected DatabaseManager $databaseManager;
    protected HttpRequestInterface $request;
    protected ResponseInterface $response;
    protected Dispatcher $dispatcher;
    
    /**
     * Create App
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Wrap the Different procedure/routines that folds the entire App cycle for
     * handling request till sending response back.
     *
     * @return ResponseInterface
     */
    public function make(): ResponseInterface
    {
        $this->processRequests();
        $this->response->prepare($this->request);
        return $this->response->send();
    }

    /**
     * Since the app currently supports HTTP requests only.
     * No need to check other APIs such as SAPI while terminating.
     *
     * @return boolean
     */
    public function terminate(): bool
    {
        $terminated = false;

        if (\function_exists('fastcgi_finish_request')) {
            $terminated = fastcgi_finish_request();
        }
        
        return $terminated;
    }

    /**
     * Initialize App properties
     *
     * @return void
     */
    protected function init(): void
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
        
        $this->request = new HttpRequest();
        $this->request->removeQueryStringfromUri();

        $this->response = (new ResponseFactory($this->request))
            ->createResponse()
            ->setHeaders(ResponseInterface::RESPONSE_HEADERS);
        
        $this->dispatcher = $this->registerRoutes(
            Routes::availableRoutes($this->request)
        );
    }
    
    /**
     * Undocumented function
     *
     * @param callable $callBackFunction As per \FastRoute Docs.
     * 
     * @return Dispatcher
     */
    protected function registerRoutes(callable $callBackFunction): Dispatcher
    {
        $dispatcher = \FastRoute\simpleDispatcher($callBackFunction);
        return $dispatcher;
    }

    /**
     * Processing of all kinds of clients requests falls down here
     *
     * @return void
     */
    protected function processRequests(): void
    {
        $routeInfo = $this->dispatcher
            ->dispatch(
                $this->request->requestMethod,
                $this->request->requestUri
            );

        switch ($routeInfo[0]) {
        case Dispatcher::NOT_FOUND:
            $this->handleNotFoundRequests(
                Response::HTTP_NOT_FOUND,
                Response::$statusTexts[Response::HTTP_NOT_FOUND]
            );
            break;

        case Dispatcher::METHOD_NOT_ALLOWED:
            $this->handleMethodNotAllowedRequests(
                Response::HTTP_METHOD_NOT_ALLOWED, 
                Response::$statusTexts[Response::HTTP_METHOD_NOT_ALLOWED]
            );
            break;

        case Dispatcher::FOUND:

            if ($this->isPreFlightRequest()) {
                $this->handlePreFlightRequest();
                return;
            }

            $errorWrapper = new ReportSpecificErrorsWrapper($this->response);
            
            $handlerArray = $routeInfo[1];

            $errorWrapper->execute(
                function () use ($handlerArray) {

                    $handlerParts = explode(
                        Routes::CONTROLLER_METHOD_DELIMITER,
                        $handlerArray[Routes::HANDLER_KEY]
                    );
                    
                    $controllerClass = $handlerParts[0];
                    $controllerObject = new $controllerClass(
                        $this->request, $this->response
                    );

                    $controllerMethod = $handlerParts[1];
                    
                    $controllerObject->$controllerMethod();
                }
            );
            break;
        }
    }

    /**
     * Handles any request that Does NOT match any available route.
     *
     * @param integer $statusCode Valid HTTP Response Status Code
     * @param string  $statusText Mapped Status text for the @param int $statusCode
     * 
     * @return void
     */
    protected function handleNotFoundRequests(
        int $statusCode, string $statusText
    ): void {
        $this->response->setStatusCode($statusCode);

        $this->response->setContent(
            json_encode(
                [
                    "code" => $statusCode,
                    "status" => $statusText,
                    "message"=> "Kindly mind your path"
                ]
            )
        );
    }

    /**
     * Handles any request that Does match an available route but the
     * HTTP Method/Verb of the request DOES NOT Match the registered One
     * or invalid.
     *
     * @param integer $statusCode Valid HTTP Response Status Code
     * @param string  $statusText Mapped Status text for the @param int $statusCode
     * 
     * @return void
     */
    protected function handleMethodNotAllowedRequests(
        int $statusCode,
        string $statusText
    ): void {
        $this->response->setStatusCode($statusCode);

        $this->response->setContent(
            json_encode(
                [
                    "code" => $statusCode,
                    "status" => $statusText,
                    "message"=> "Method Not Allowed, That's all what we know!"
                ]
            )
        );
    }

    /**
     * Checks Whether the request asks for No Content.
     *
     * @return boolean
     */
    protected function isPreFlightRequest(): bool
    {
        return "OPTIONS" === $this->request->requestMethod;
    }

    /**
     * Responds to the No Content requests. Handles CORS.
     *
     * @return void
     */
    protected function handlePreFlightRequest(): void
    {
        $this->response->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}