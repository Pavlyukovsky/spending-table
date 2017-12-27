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
                'total' => 0
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
        $percentReinvest = (double)$model->percentReinvest;
        $isCapitalization = ($model->capitalize) ? true : false;

        $investment = $begin;
        $saved = 0; // Сколько денег мы сохраняем (Выводим)
        $earned = 0; // Сколько денег мы всего заработали
        $resultDays = [];
        for ($i = 0; $i < $days; $i++) {
            if ($isCapitalization) {
                // Сколько зарабатываем в день с капитализацией
                $dailyEarned = $investment * $percent / 100;

                // Сколько будем реинвестировать
                $dailyReinvest = $dailyEarned * $percentReinvest / 100;

                // Сколько будем выводить
                $dailySaved = $dailyEarned - $dailyReinvest;
                $saved += $dailySaved;
            } else {
                // Сколько зарабатываем в день без капитализацией
                $dailyEarned = $investment * $percent / 100;

                // Сколько будем реинвестировать
                $dailyReinvest = 0;

                // Сколько будем выводить
                $dailySaved = $dailyEarned;
                $saved += $dailySaved;
            }
            $earned += $dailyEarned;

            $investment = $investment + $dailyReinvest;

            $resultDays[] = ['investment' => $investment, 'reinvest' => $dailyReinvest, 'saved' => $dailySaved, 'earned' => $earned];
        }

        $allPercent = (100 * $earned / $begin);
        $reinvest = $investment - $begin;
        $resultAll = ['investment' => $investment, 'reinvest' => $reinvest, 'saved' => $saved, 'allPercent' => $allPercent];
        return $this->render('bitconnect', ['model' => $model, 'resultDays' => $resultDays, 'resultAll' => $resultAll]);
    }
}
