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
    public $percentReinvest;
    public $days;
    public $capitalize;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['begin', 'percent', 'percentReinvest', 'days', 'capitalize'], 'required'],
            [['begin', 'percent', 'percentReinvest', 'days'], 'double'],
        ];
    }
}