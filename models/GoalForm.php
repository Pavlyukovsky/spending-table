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
    public $spending;
    public $amountUp;
    public $month;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['currentSalary', 'spending', 'amountUp', 'month'], 'required'],
            [['currentSalary', 'spending', 'amountUp', 'month'], 'integer'],
        ];
    }
}
