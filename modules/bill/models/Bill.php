<?php

namespace app\modules\bill\models;

use app\models\BeautyDate;
use app\models\Entity;
use Yii;
use yii\helpers\VarDumper;

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
     * Получаем данные за прошлый месяц.
     * @return array|bool|\yii\db\ActiveRecord[]
     */
    public static function getBillsByLastMonth()
    {
        $lastMonth = BeautyDate::getLastMonth();
        $now = strtotime('+1 month', $lastMonth);

        $lastMonthBeauty = BeautyDate::getBeautyDate($lastMonth);
        $nowBeauty = BeautyDate::getBeautyDate($now);


        $models = Bill::find()->where(['deleted' => Entity::NOT_DELETED])->andWhere('`created_at` <= "'.$nowBeauty .'"')->andWhere('`created_at` >= "'.$lastMonthBeauty.'"')->all();
        if($models){
            return $models;
        }

        return false;
    }

    /**
     * Получаем данные за прошлый Год.
     * @return array|bool|\yii\db\ActiveRecord[]
     */
    public static function getBillsByLastYear()
    {
        $lastYear = BeautyDate::getLastYear();
        $now = strtotime('+1 year', $lastYear);

        $lastYearBeauty = BeautyDate::getBeautyDate($lastYear);
        $nowBeauty = BeautyDate::getBeautyDate($now);


        $models = Bill::find()->where(['deleted' => Entity::NOT_DELETED])->andWhere('`created_at` <= "'.$nowBeauty .'"')->andWhere('`created_at` >= "'.$lastYearBeauty.'"')->all();
        if($models){
            return $models;
        }

        return false;
    }

    /**
     * Получаем данные за текуший меяц
     * @return array|bool|\yii\db\ActiveRecord[]
     */
    public static function getBillsByCurrentMonth()
    {
        $nowMonth = BeautyDate::getThisMonth();
        $nowMonthBeauty = BeautyDate::getBeautyDate($nowMonth);


        $models = Bill::find()->where(['deleted' => Entity::NOT_DELETED])->andWhere('`created_at` >= "'.$nowMonthBeauty.'"')->all();
        if($models){
            return $models;
        }

        return false;
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
        return parent::beforeSave($insert);
    }

    public function getName()
    {
        return $this->name;
    }

}
