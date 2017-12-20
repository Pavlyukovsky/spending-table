<?php

namespace app\controllers;

use app\models\GoalBitconnectForm;
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
        $spending = $model->spending; //
        $amountUp = $model->amountUp; // Каждые 3 месяца на сколько повышать (Example: 100)
        $currentSalary = $startSalary; // Текушая ставка на данный месяц. (Розшитывается)
        $remainingMoney = $startSalary - $spending; // Сколько осталось на данный месяц.
        $month = $model->month; // Количество месяцов. (Example: 24)

        // Всего денег
        $total = 0;

        // Массыв со всеми значениями.
        $years = [];
        $year = 0; // Счётчик года

        $year_amount = 0; // Всего в год

        for ($i = 1; $i < $month + 1; $i++) {
            $year_amount += $remainingMoney;
            $years[$year]['items'][] = ['currentSalary' => $currentSalary, 'remainingMoney' => $remainingMoney, 'saved' => $year_amount];

            // Если дошли до повышения. То повышаем ЗП.
            if (!($i % 3)) {
                $remainingMoney += $amountUp;
                $currentSalary += $amountUp;
            }

            // Если наступил новый год. Или закончились месяца.
            if (!($i % 12) || $i == $month) {
                $total += $year_amount;
                $years[$year]['total_year'] = $year_amount;
                $years[$year]['total_all'] = $total;
                $year_amount = 0;
                $year++;
            }
        }

        return $this->render('index', ['model' => $model, 'years' => $years, 'total' => $total]);
    }


    /**
     * // Положил 1000;
     * // Процент в день 0.86;
     * // Процент добавляется к сумме, по нему выплачивается процент и делаеться капитализация
     *
     * @return bool|string
     */
    public function actionBitconnect()
    {
        $model = new GoalBitconnectForm();
        if (!$model->load(Yii::$app->request->post()) || !$model->validate()) {
            return $this->render('bitconnect', [
                'model' => $model,
            ]);
        }

        $begin = (double)$model->begin;
        $percent = (double)$model->percent;
        $days = (int)$model->days;
        $isCapitalization = ($model->capitalize) ? true : false;

        $cash = $begin;
        $sum = $begin;
        $resultDays = [];
        for ($i = 0; $i < $days; $i++) {
            if ($isCapitalization) {
                $add = $cash * $percent / 100;
            } else {
                $add = $sum * $percent / 100;
            }

            $cash = $cash + $add;

            $resultDays[] = ['balance' => $cash, 'earned' => $add];
        }

        $allPercent = (100 * $cash / $begin) - 100;
        $earned = $cash - $sum;
        $resultAll = ['balance' => $cash, 'earned' => $earned, 'allPercent' => $allPercent];
        return $this->render('bitconnect', ['model' => $model, 'resultDays' => $resultDays, 'resultAll' => $resultAll]);
    }
}
