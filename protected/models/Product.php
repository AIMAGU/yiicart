<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $product_id
 * @property string $model
 * @property string $sku
 * @property string $upc
 * @property string $ean
 * @property string $jan
 * @property string $isbn
 * @property string $mpn
 * @property string $location
 * @property integer $quantity
 * @property integer $stock_status_id
 * @property string $image
 * @property integer $manufacturer_id
 * @property integer $shipping
 * @property string $price
 * @property integer $points
 * @property integer $tax_class_id
 * @property string $date_available
 * @property string $weight
 * @property integer $weight_class_id
 * @property string $length
 * @property string $width
 * @property string $height
 * @property integer $length_class_id
 * @property integer $subtract
 * @property integer $minimum
 * @property integer $sort_order
 * @property integer $status
 * @property string $date_added
 * @property string $date_modified
 * @property integer $viewed
 */
class Product extends CActiveRecord {

    private $cacheId;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Product the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'product';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('model, sku, upc, ean, jan, isbn, mpn, location, stock_status_id, manufacturer_id, tax_class_id, date_available', 'required'),
            array('quantity, stock_status_id, manufacturer_id, shipping, points, tax_class_id, weight_class_id, length_class_id, subtract, minimum, sort_order, status, viewed', 'numerical', 'integerOnly' => true),
            array('model, sku, mpn', 'length', 'max' => 64),
            array('upc', 'length', 'max' => 12),
            array('ean', 'length', 'max' => 14),
            array('jan, isbn', 'length', 'max' => 13),
            array('location', 'length', 'max' => 128),
            array('image', 'length', 'max' => 255),
            array('price, weight, length, width, height', 'length', 'max' => 15),
            array('date_added, date_modified', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('product_id, model, sku, upc, ean, jan, isbn, mpn, location, quantity, stock_status_id, image, manufacturer_id, shipping, price, points, tax_class_id, date_available, weight, weight_class_id, length, width, height, length_class_id, subtract, minimum, sort_order, status, date_added, date_modified, viewed', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'manufacturer' => array(self::BELONGS_TO, 'Manufacturer', 'manufacturer_id'),            
            'description' => array(self::HAS_ONE, 'ProductDescription', 'product_id'),
            'orders' => array(self::HAS_MANY, 'Order', 'customer_id'),
            'additionalImages' => array(self::HAS_MANY, 'ProductImage', 'product_id'),
            'stockStatus' => array(self::BELONGS_TO, 'StockStatus', 'stock_status_id'), // TODO: add language condition
        );
    }

    public function scopes() {
        return array(
            'latest' => array(
                'order' => 'product_id DESC',
                'limit' => '8',
            ),
            'active' => array(
                'condition' => 'status=1',
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'product_id' => 'Product',
            'model' => 'Model',
            'sku' => 'Sku',
            'upc' => 'Upc',
            'ean' => 'Ean',
            'jan' => 'Jan',
            'isbn' => 'Isbn',
            'mpn' => 'Mpn',
            'location' => 'Location',
            'quantity' => 'Quantity',
            'stock_status_id' => 'Stock Status',
            'image' => 'Image',
            'manufacturer_id' => 'Manufacturer',
            'shipping' => 'Shipping',
            'price' => 'Price',
            'points' => 'Points',
            'tax_class_id' => 'Tax Class',
            'date_available' => 'Date Available',
            'weight' => 'Weight',
            'weight_class_id' => 'Weight Class',
            'length' => 'Length',
            'width' => 'Width',
            'height' => 'Height',
            'length_class_id' => 'Length Class',
            'subtract' => 'Subtract',
            'minimum' => 'Minimum',
            'sort_order' => 'Sort Order',
            'status' => 'Status',
            'date_added' => 'Date Added',
            'date_modified' => 'Date Modified',
            'viewed' => 'Viewed',
        );
    }
    
    public function beforeDelete() {
        $this->cacheId = $this->product_id;
        return parent::beforeDelete();
    }

    public function afterDelete() {        
        // delete dependencies
        ProductAttribute::model()->deleteAll("product_id={$this->cacheId}");
        ProductDescription::model()->deleteAll("product_id={$this->cacheId}");
        ProductDiscount::model()->deleteAll("product_id={$this->cacheId}");
        ProductFilter::model()->deleteAll("product_id={$this->cacheId}");
        ProductImage::model()->deleteAll("product_id={$this->cacheId}");
        ProductOption::model()->deleteAll("product_id={$this->cacheId}");
        ProductOptionValue::model()->deleteAll("product_id={$this->cacheId}");
        ProductRelated::model()->deleteAll("product_id={$this->cacheId}");
        ProductRelated::model()->deleteAll("related_id={$this->cacheId}");
        ProductReward::model()->deleteAll("product_id={$this->cacheId}");
        ProductSpecial::model()->deleteAll("product_id={$this->cacheId}");
        ProductToCategory::model()->deleteAll("product_id={$this->cacheId}");
        ProductToDownload::model()->deleteAll("product_id={$this->cacheId}");
        ProductToLayout::model()->deleteAll("product_id={$this->cacheId}");
        ProductToStore::model()->deleteAll("product_id={$this->cacheId}");
        Review::model()->deleteAll("product_id={$this->cacheId}");
        UrlAlias::model()->deleteAll("query='product_id={$this->cacheId}'");

        parent::afterDelete();
    }
    
    public function hasAdditionalImages(){
        return count($this->additionalImages) > 0 ? true : false;
    }

    public function getImageWithSize($width, $height) {
        if ($this->image && file_exists(Yii::app()->params['imagePath'] . $this->image)) {
            $_image = ImageTool::resize($this->image, $width, $height);
        } else {
            $_image = ImageTool::resize('no_image.jpg', $width, $height);
        }

        return $_image;
    }

    public function getFormattedPrice() {
        // TODO: format price
        return "$" . sprintf("%.2f", "{$this->price}");
    }

}