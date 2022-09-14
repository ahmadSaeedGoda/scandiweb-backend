<?php
/**
 * Product is a representation for A product record in the database.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ProductModel-class
 */

namespace Scandiweb\App\Data\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Product is a representation for A product record in the database.
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/ProductModel-class
 */
class Product extends Model
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
        'SKU',
        'Name',
        'Price',
        'FK_ProductType',
    ];

    /**
     * Create a new model instance
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTable('Products');
        $this->setKeyName('PK_ProductID');
    }

    /**
     * Get the Attrs of the Product, performs joins.
     *
     * @return void
     */
    public function productAttributes()
    {
        return $this->hasMany(
            ProductTypeAttribute::class, 
            'FK_ProductType', 
            'FK_ProductType'
        );
    }

    /**
     * Get the Attrs' Values of the Product.
     *
     * @return void
     */
    public function attributesValues()
    {
        return $this->hasMany(
            ProductAttribute::class, 
            'FK_ProductID', 
            'PK_ProductID'
        );
    }

    /**
     * Retrieves All Records at once, and loads the attributes 
     * with its values eagerly.
     *
     * @return Collection
     */
    public function retrieve(): Collection
    {
        return $this->with(['productAttributes', 'attributesValues'])->get();
    }

    /**
     * Checks whether a given SKU is valid.
     *
     * @param string $sku Product Prospect SKU
     * 
     * @return boolean
     */
    public function isOkaySKU(string $sku): bool
    {
        return count($this->where('SKU', $sku)->get()) === 0;        
    }

    /**
     * Create new Product logic
     *
     * @param array $storableModel Product data
     * 
     * @return boolean
     */
    public function store(array $storableModel): bool
    {
        $productTypeAttributeModel = new ProductTypeAttribute;
        $productTypeAttributesCollection = $productTypeAttributeModel
            ->where(
                'FK_ProductType', 
                $storableModel['productData']['FK_ProductType']
            )
            ->get();

        if ($productTypeAttributesCollection->isEmpty()) {
            $this->fill($storableModel['productData'])->save();
            return true;
        }

        try {
            $this->getConnection()->beginTransaction();
                
            $newProduct = $this->fill($storableModel['productData']);
            $newProduct->save();
            
            if (!empty($storableModel['productAttributes'])) {
                foreach ($productTypeAttributesCollection as $record) {
                    foreach (
                        $storableModel['productAttributes'] as 
                            $attributeName => $attributeValue) {
                        if ($attributeName === $record->AttributeName) {
                            (new ProductAttribute)
                                ->fill(
                                    [
                                    'FK_ProductID'  => $newProduct->PK_ProductID,
                                    'FK_AttributeID' => $record->PK_AttributeID,
                                    'AttributeValue' => $attributeValue
                                    ]
                                )->save();
                        }
                    }
                }
            }
            
            $this->getConnection()->commit();

        } catch (\Throwable $th) {
            $this->getConnection()->rollBack();
            throw $th;
        }

        return true;
    }

    /**
     * Mass deletes from products table given records ids
     *
     * @param array $ids Products IDs to be deleted from DB
     * 
     * @return boolean
     */
    public function massDelete(array $ids): bool
    {
        try {
                
            $this->getConnection()->beginTransaction();
            
            (new ProductAttribute)->whereIn('FK_ProductID', $ids)->delete();
            
            self::destroy($ids);

            $this->getConnection()->commit();

        } catch (\Throwable $th) {
            $this->getConnection()->rollBack();
            throw $th;
        }

        return true;
    }
}
