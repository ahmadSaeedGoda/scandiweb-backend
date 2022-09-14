<?php
/**
 * ProductAttribute is a representation for A value of 
 * an exact product attribute in the database.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ProductAttributeModel-class
 */

namespace Scandiweb\App\Data\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ProductAttribute is a representation for A value of 
 * an exact product attribute in the database.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ProductAttributeModel-class
 */
class ProductAttribute extends Model
{
    /**
     * Indicates if the model should be timestamped, 
     * like to have created_at & updated_at properties.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'FK_ProductID',
        'FK_AttributeID',
        'AttributeValue'
    ];

    /**
     * Create a new model instance
     */
    public function __construct()
    {
        $this->setTable('ProductAttributes');
        $this->setIncrementing(false);
        parent::__construct();
    }
    
    // protected function setKeysForSaveQuery($query)
    // {
    //     $query->where('FK_ProductID', '=', $this->getAttribute('FK_ProductID'))
    //         ->where('FK_AttributeID', '=', $this->getAttribute('FK_AttributeID'));
    //     return $query;
    // }
}
