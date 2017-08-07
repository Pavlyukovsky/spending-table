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
class GoalForm extends Model
{
    public $currentSalary;
    public $amountUp;
    public $month;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['currentSalary', 'amountUp', 'month'], 'required'],
            [['currentSalary', 'amountUp', 'month'], 'integer'],
        ];
    }
}
