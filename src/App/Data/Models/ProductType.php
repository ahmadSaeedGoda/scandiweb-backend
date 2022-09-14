<?php
/**
 * ProductType is a representation for A product type in the database.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ProductTypeModel-class
 */

namespace Scandiweb\App\Data\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ProductType is a representation for A product type in the database.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ProductTypeModel-class
 */
class ProductType extends Model
{
    /**
     * Indicates if the model should be timestamped, 
     * like to have created_at & updated_at properties.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Create a new model instance
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTable('ProductTypes');
        $this->setKeyName('PK_ProductType');
        $this->setKeyType('string');
        $this->setIncrementing(false);
    }

    /**
     * Get the Attrs of the Product, performs joins.
     *
     * @return void
     */
    public function productTypeAttributes()
    {
        return $this->hasMany(
            ProductTypeAttribute::class, 
            'FK_ProductType', 
            'PK_ProductType'
        );
    }
}
