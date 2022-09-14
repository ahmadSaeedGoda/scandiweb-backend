<?php
/**
 * ProductTypeController Manages interaction between client Request & Data Access
 * layer that's responsible for accessing Data Source.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ProductTypeController-class
 */

namespace Scandiweb\App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Scandiweb\App\Data\Models\ProductType;
use Scandiweb\App\Http\Controllers\Contracts\RetrievableInterface;
use Scandiweb\App\Http\Request\Contracts\HttpRequestInterface;
use Scandiweb\App\Http\Response\Contracts\ResponseInterface;
use Scandiweb\App\Http\Response\Response;
use Scandiweb\Util\JSON;

/**
 * ProductTypeController class
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ProductTypeController-class
 */
class ProductTypeController extends BaseController implements RetrievableInterface
{

    protected Model $model;

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
        $this->model = new ProductType;
    }

    /**
     * Retrieve All Records & fill the response
     *
     * @return ResponseInterface
     */
    public function getAll(): ResponseInterface
    {
        $productTypesCollection = $this->model
            ->where('IsActive', 1)
            ->with(['productTypeAttributes'])
            ->orderBy($this->model->getKeyName(), 'asc')
            ->get();

        $this->response->setStatusCode(Response::HTTP_OK);

        $this->response->setContent(
            JSON::encode(
                [
                    "code"      => Response::HTTP_OK,
                    "status"    => Response::$statusTexts[Response::HTTP_OK],
                    "data"      => $productTypesCollection,
                ]
            )
        );

        return $this->response;
    }//end getAll()
}//end class
