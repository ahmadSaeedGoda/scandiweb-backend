<?php
/**
 * ProductController Manages interaction between client Request & Data Access
 * layer that's responsible for accessing Data Source.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ProductController-class
 */

namespace Scandiweb\App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Scandiweb\App\Data\Models\Product;
use Scandiweb\App\Data\Transformers\RecievableProductDataTransformer;
use Scandiweb\App\Data\Validation\ProductValidator;
use Scandiweb\App\Http\Controllers\Contracts\DestroyableInterface;
use Scandiweb\App\Http\Controllers\Contracts\RetrievableInterface;
use Scandiweb\App\Http\Controllers\Contracts\StorableInterface;
use Scandiweb\App\Http\Request\Contracts\HttpRequestInterface;
use Scandiweb\App\Http\Response\Contracts\ResponseInterface;
use Scandiweb\App\Http\Response\Response;
use Scandiweb\Exceptions\DuplicateSKUException;
use Scandiweb\Exceptions\UnprocessableEntityException;
use Scandiweb\Util\JSON;

/**
 * ProductController Manages interaction between client Request & Data Access
 * layer that's responsible for accessing Data Source.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ProductController-class
 */
class ProductController extends BaseController implements 
    DestroyableInterface,
    RetrievableInterface,
    StorableInterface
{

    public const DESTROYABLE_PRODUCTS_IDS_REQUEST_KEY = 'destroyableProductsIDs';

    protected Model $model;
    protected ProductValidator $productValidator;

    /**
     * Create a new controller instance.
     *
     * @param HttpRequestInterface $request  Reference to Client Request
     * @param ResponseInterface    $response Reference to Server Response
     *
     * @return void
     */
    public function __construct(
        HttpRequestInterface $request, 
        ResponseInterface $response
    ) {
        parent::__construct($request, $response);
        $this->model = new Product;
        $this->productValidator = new ProductValidator;
    }

    /**
     * Retrieve All Records & fill the response
     *
     * @return ResponseInterface
     */
    public function getAll(): ResponseInterface
    {
        $productsCollection = $this->model->retrieve();

        $this->response->setStatusCode(Response::HTTP_OK);

        $this->response->setContent(
            JSON::encode(
                [
                    "code"      => Response::HTTP_OK,
                    "status"    => Response::$statusTexts[Response::HTTP_OK],
                    "data"      => $productsCollection,
                ]
            )
        );

        return $this->response;
    }//end getAll()

    /**
     * Checks whether the passed out SKU is valid.
     *
     * @return ResponseInterface
     */
    public function isValidSKU(): ResponseInterface
    {
        $requestUriAsArray = explode('/', $this->request->requestUri);

        if (false === is_array($requestUriAsArray)) {
            throw new UnprocessableEntityException('Unprocessable Entity SKU');
        }

        $sku = end($requestUriAsArray);

        if (false === is_string($sku)) {
            throw new UnprocessableEntityException('Unprocessable Entity SKU');
        }

        $validationResult = $this->productValidator->validateSKU($sku);

        if (null !== $validationResult) {
            throw $validationResult;
        }
        
        $isValidSKU = $this->model->isOkaySKU($sku);

        $this->response->setStatusCode(Response::HTTP_OK);

        $this->response->setContent(
            JSON::encode(
                [
                    "code"      => Response::HTTP_OK,
                    "status"    => Response::$statusTexts[Response::HTTP_OK],
                    "data"      => $isValidSKU,
                ]
            )
        );

        return $this->response;
    }

    /**
     * Create new Product logic between request & model
     *
     * @return ResponseInterface
     */
    public function addNew(): ResponseInterface
    {
        $requestBody = JSON::decode($this->request->getBody());
        $validationResult = $this->productValidator->validate($requestBody);

        if (null !== $validationResult) {
            throw $validationResult;
        }
        
        if (false === $this->model->isOkaySKU($requestBody->SKU)) {
            throw new DuplicateSKUException('SKU is Duplicate');
        }

        $storableModel = (new RecievableProductDataTransformer)
            ->transformToStorableModel($requestBody);

        $created = $this->model->store($storableModel);

        $this->response->setStatusCode(Response::HTTP_CREATED);

        $this->response->setContent(
            JSON::encode(
                [
                    "code"      => Response::HTTP_CREATED,
                    "status"    => Response::$statusTexts[Response::HTTP_CREATED],
                    "data"      => $created,
                ]
            )
        );

        return $this->response;
    }

    /**
     * Destroy List of Products
     *
     * @return ResponseInterface
     */
    public function massDelete(): ResponseInterface
    {
        $requestBody = JSON::decode($this->request->getBody());
        
        $validationResult = $this->productValidator
            ->validateProductsDestroy($requestBody);

        if (null !== $validationResult) {
            throw $validationResult;
        }

        $productsIDs = $requestBody->{SELF::DESTROYABLE_PRODUCTS_IDS_REQUEST_KEY};
        
        $destroyed = $this->model->massDelete($productsIDs);

        $this->response->setStatusCode(Response::HTTP_ACCEPTED);

        $this->response->setContent(
            JSON::encode(
                [
                    "code"      => Response::HTTP_ACCEPTED,
                    "status"    => Response::$statusTexts[Response::HTTP_ACCEPTED],
                    "data"      => $destroyed,
                ]
            )
        );

        return $this->response;
    }
}//end class
