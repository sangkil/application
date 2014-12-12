<?php

namespace biz\core\purchase\models;

use Yii;

/**
 * This is the model class for table "{{%purchase}}".
 *
 * @property integer $id
 * @property string $number
 * @property integer $supplier_id
 * @property integer $branch_id
 * @property string $date
 * @property double $value
 * @property double $discount
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property PurchaseDtl[] $purchaseDtls
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class Purchase extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 10;
    const STATUS_PARTIAL_RECEIVE = 20;
    const STATUS_COMPLETE_RECEIVE = 30;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%purchase}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_id', 'branch_id', 'date', 'purchaseDtls'], 'required'],
            [['supplier_id', 'branch_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['status'], 'default', 'value' => self::STATUS_DRAFT],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['discount'], 'number'],
            [['number'], 'string', 'max' => 16],
            [['purchaseDtls'], 'calcDetails'],
        ];
    }

    public function calcDetails()
    {
        
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'supplier_id' => 'Supplier ID',
            'branch_id' => 'Branch ID',
            'date' => 'Date',
            'value' => 'Value',
            'discount' => 'Discount',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseDtls()
    {
        return $this->hasMany(PurchaseDtl::className(), ['purchase_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return[
            'BizTimestampBehavior',
            'BizBlameableBehavior',
            [
                'class' => 'mdm\autonumber\Behavior',
                'digit' => 6,
                'attribute' => 'number',
                'value' => 'PU' . date('y.?')
            ],
            'BizStatusConverter',
            'mdm\behaviors\ar\RelationBehavior',
        ];
    }
}
