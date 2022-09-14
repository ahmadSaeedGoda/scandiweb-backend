<?php
/**
 * Error Handler for pre-determined array of errors
 * php version 7.4.0
 * 
 * @category Util
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ReportSpecificErrorsWrapper-calss
 */

namespace Scandiweb\Util;

use Respect\Validation\Exceptions\NestedValidationException;
use Scandiweb\App\Http\Response\Contracts\ResponseInterface;
use Scandiweb\App\Http\Response\Response;
use Scandiweb\Exceptions\DuplicateSKUException;
use Scandiweb\Exceptions\JsonDecodeException;
use Scandiweb\Exceptions\JsonEncodeException;
use Scandiweb\Exceptions\UnprocessableEntityException;

/**
 * Error Handler for pre-determined array of errors
 * php version 7.4.0
 * 
 * @category Util
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ReportSpecificErrorsWrapper-class
 */
class ReportSpecificErrorsWrapper extends ErrorHandlerWrapper
{
    /**
     * A pre-constructed response object to be filled with status code & body
     * according to thrown error.
     *
     * @var ResponseInterface
     */
    protected ResponseInterface $response;

    /**
     * Create a new instance.
     *
     * @param ResponseInterface $response A pre-constructed response object to be 
     *                                    filled with status code & body according 
     *                                    to thrown error.
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * {@inheritdoc}
     * 
     * @param \Throwable $exception 
     * 
     * @return void
     */
    protected function handleError(\Throwable $exception)
    {
        switch ($exception) {
        case $exception instanceof JsonEncodeException:
        case $exception instanceof JsonDecodeException:
        case $exception instanceof UnprocessableEntityException:
            $this->response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);

            $this->response->setContent(
                json_encode(
                    [
                        "code"      => Response::HTTP_UNPROCESSABLE_ENTITY,
                        "status"    => Response::$statusTexts[
                            Response::HTTP_UNPROCESSABLE_ENTITY
                        ],
                        "error"     => "Invalid input\n" . $exception->getMessage(),
                    ]
                )
            );

            break;
        
        case $exception instanceof DuplicateSKUException:

            $this->response->setStatusCode(Response::HTTP_BAD_REQUEST);

            $this->response->setContent(
                json_encode(
                    [
                        "code"      => Response::HTTP_BAD_REQUEST,
                        "status"    => Response::$statusTexts[
                            Response::HTTP_BAD_REQUEST
                        ],
                        "error"     => $exception->getMessage(),
                    ]
                )
            );
            break;
        
        case $exception instanceof NestedValidationException:

            $this->response->setStatusCode(Response::HTTP_BAD_REQUEST);

            $this->response->setContent(
                json_encode(
                    [
                        "code"      => Response::HTTP_BAD_REQUEST,
                        "status"    => Response::$statusTexts[
                            Response::HTTP_BAD_REQUEST
                        ],
                        "errors"    => $exception->getMessages(),
                    ]
                )
            );
            break;

        default:
            $this->response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);

            $this->response->setContent(
                json_encode(
                    [
                        "code"      => Response::HTTP_INTERNAL_SERVER_ERROR,
                        "status"    => Response::$statusTexts[
                            Response::HTTP_INTERNAL_SERVER_ERROR
                        ],
                        "error"     => $this->convertExceptionToArray($exception)
                    ]
                )
            );
            break;
        }
    }

    /**
     * Convert the given exception to an array.
     *
     * @param \Throwable $e Given error/exception
     * 
     * @return array
     */
    protected function convertExceptionToArray(\Throwable $e): array
    {
        if ('TRUE' === getenv('DEBUG')) {
            return [
                'message' => $e->getMessage(),
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTrace(),
            ];
        }
        
        return [ 'message' => 'Server Error' ];
    }
}
