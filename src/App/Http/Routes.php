<?php
/**
 * All Available Routes
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/Routes-class
 */

namespace Scandiweb\App\Http;

use FastRoute\RouteCollector;
use Scandiweb\App\Http\Controllers\ProductController;
use Scandiweb\App\Http\Controllers\ProductTypeController;
use Scandiweb\App\Http\Request\Contracts\HttpRequestInterface;

/**
 * Routes class.
 * 
 * This class is here just for the separation of concerns, no need to instantiate.
 * Having this class allows the client code in other modules/classes to render
 * available routes y calling the lonely static function here `availableRoutes`.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/Routes-class
 */
class Routes
{

    const CONTROLLER_METHOD_DELIMITER = '@';
    const HANDLER_KEY = 'handler';

    /**
     * Renders a Closure that Registers the Routes.
     *
     * @param HttpRequestInterface $request The current user request
     * 
     * @return callable
     */
    public static function availableRoutes(HttpRequestInterface $request): callable
    {
        return function (RouteCollector $r) use ($request) {
            $r->addGroup(
                "/public/index.php/".$request->getAPIPrefix()."/".$request->getAPIVersion()."/",
                function (RouteCollector $r) {
                    $r->options(
                        'products',
                        [
                            self::HANDLER_KEY =>
                            BaseController::class . '@handlePreFlightRequest'
                        ]
                    );

                    $r->get(
                        'products',
                        [
                            self::HANDLER_KEY => 
                            ProductController::class . '@getAll'
                        ]
                    );

                    $r->options(
                        'products/types',
                        [
                            self::HANDLER_KEY => 
                            BaseController::class . '@handlePreFlightRequest'
                        ]
                    );

                    $r->get(
                        'products/types',
                        [
                            self::HANDLER_KEY => 
                            ProductTypeController::class . '@getAll'
                        ]
                    );

                    $r->get(
                        'products/sku/isValid/{sku}',
                        [
                            self::HANDLER_KEY => 
                            ProductController::class . '@isValidSKU'
                        ]
                    );
                    
                    $r->post(
                        'products',
                        [
                            self::HANDLER_KEY => 
                            ProductController::class . '@addNew'
                        ]
                    );
                    
                    $r->delete(
                        'products',
                        [
                            self::HANDLER_KEY => 
                            ProductController::class . '@massDelete'
                        ]
                    );
                }
            );
        };
    }
}
