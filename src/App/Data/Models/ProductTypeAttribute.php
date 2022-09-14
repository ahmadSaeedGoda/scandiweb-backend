<?php
/**
 * ProductTypeAttribute is a representation for A product specific attribute 
 * in the database.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ProductTypeAttributeModel-class
 */

namespace Scandiweb\App\Data\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ProductTypeAttribute is a representation for A product specific attribute 
 * in the database.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ProductTypeAttributeModel-class
 */
class ProductTypeAttribute extends Model
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
        $this->setTable('ProductTypeAttributes');
        $this->setKeyName('PK_AttributeID');
        parent::__construct();
    }
}
