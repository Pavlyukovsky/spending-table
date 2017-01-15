<?php

namespace app\modules\bill\models;

use app\models\Entity;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "bill_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property integer $deleted
 *
 * @property Bill[] $bills
 */
class BillCategory extends Entity
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bill_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'deleted'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'created_at' => 'Created At',
            'deleted' => 'Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBills()
    {
        return $this->hasMany(Bill::className(), ['category_id' => 'id']);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getList()
    {
        $models = BillCategory::find()->where(['deleted' => Entity::NOT_DELETED])->all();
        return ArrayHelper::map($models,'id','name');
    }

    public function beforeSave($insert)
    {
        $this->created_at = Entity::getTimeStampNow();
        return parent::beforeSave($insert);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
