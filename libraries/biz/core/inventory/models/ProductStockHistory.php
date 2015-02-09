<?php

namespace biz\core\inventory\models;

use Yii;

/**
 * This is the model class for table "{{%product_stock_history}}".
 *
 * @property string $date
 * @property integer $warehouse_id
 * @property integer $product_id
 * @property double $qty
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class ProductStockHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_stock_history}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'warehouse_id', 'product_id', 'qty'], 'required'],
            [['date'], 'safe'],
            [['warehouse_id', 'product_id'], 'integer'],
            [['qty'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'date' => 'Date',
            'warehouse_id' => 'Warehouse ID',
            'product_id' => 'Product ID',
            'qty' => 'Qty',
        ];
    }
}
