<?php

namespace app\controllers;

use app\models\GoalForm;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;

class GoalController extends Controller
{
    /**
     * Подсчитует сколько можно насобират денег если отлаживать $startSalary с учётом повышения за $month месяцов
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new GoalForm();
        if (!$model->load(Yii::$app->request->post()) || !$model->validate()) {
            return $this->render('index', [
                'model' => $model,
            ]);
        }

        $startSalary = $model->currentSalary; // Начальная ставка (Example: 300)
        $amountUp = $model->amountUp; // Каждые 3 месяца на сколько повышать (Example: 100)
        $currentSalary = $startSalary; // Текушая ставка на данный месяц. (Розшитывается)
        $month = $model->month; // Количество месяцов. (Example: 24)

        // Всего денег
        $total = 0;

        // Массыв со всеми значениями.
        $years = [];
        $year = 0; // Счётчик года

        $year_amount = 0; // Всего в год

        for ($i = 1; $i < $month + 1; $i++) {
            $year_amount += $currentSalary;
            $years[$year]['items'][] = ['currentSalary' => $currentSalary, 'saved' => $year_amount];

            // Если дошли до повышения. То повышаем ЗП.
            if (!($i % 3)) {
                $currentSalary += $amountUp;
            }

            // Если наступил новый год. Или закончились месяца.
            if(!($i % 12) || $i == $month){
                $total += $year_amount;
                $years[$year]['total_year'] = $year_amount;
                $years[$year]['total_all'] = $total;
                $year_amount = 0;
                $year++;
            }
        }

        return $this->render('index', ['model' => $model, 'years' => $years, 'total' => $total]);
    }


}
