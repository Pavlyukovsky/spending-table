<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 15.01.2017
 * Time: 19:02
 */

namespace app\models;


use yii\db\ActiveRecord;

abstract class Entity extends ActiveRecord
{
    const NOT_DELETED = 0;
    const DELETED = 1;

    /**
     * @return mixed
     */
    abstract public function getName();

    /**
     * Возврашает сегодняшнюю дану в формате TimeStamp. Что бы положить в базу.
     * @return false|string
     */
    public final static function getTimeStampNow()
    {
        return date('Y-m-d H:i:s',time());
    }

    /**
     * Мягкое удаление. Если $hard == true, то удаляем из бд.
     * @param bool $hard
     * @return false|int
     */
    public function delete($hard = false)
    {
        if(!$hard){
            $this->deleted = Entity::DELETED;
            if($this->save()){
                return true;
            }
            return false;
        }

        return parent::delete();
    }

}