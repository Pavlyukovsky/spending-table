<?php

namespace app\modules\bill\models;

use app\models\Entity;
use Yii;

/**
 * This is the model class for table "bill".
 *
 * @property integer $id
 * @property string $name
 * @property double $price
 * @property integer $category_id
 * @property string $created_at
 * @property integer $deleted
 *
 * @property BillCategory $category
 */
class Bill extends Entity
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bill';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price', 'category_id'], 'required'],
            [['price'], 'number'],
            [['category_id'], 'integer'],
            [['created_at', 'deleted'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => BillCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'category_id' => 'Category ID',
            'created_at' => 'Created At',
            'deleted' => 'Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(BillCategory::className(), ['id' => 'category_id']);
    }

    public function beforeSave($insert)
    {
        $this->created_at = Entity::getTimeStampNow();
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function getName()
    {
        return $this->name;
    }

}