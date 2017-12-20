<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class GoalBitconnectForm extends Model
{
    public $begin;
    public $percent;
    public $days;
    public $capitalize;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['begin', 'percent', 'days', 'capitalize'], 'required'],
            [['begin', 'percent', 'days'], 'double'],
        ];
    }
}