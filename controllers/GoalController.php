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


    public function actionBitconnect()
    {
        // Положил 1000;
        // Процент в день 0.86;
        // Процент добавляется к сумме, по нему выплачивается процент и делаеться капитализация


        $begin = 100;
        $percent = 0.96;
        $cash = $begin;
//        $days = 90;
        $days = 30*12;

        $isCapitalization = true;
        $sum = $begin;

        echo "<pre>";
        $add = 0;
        for ($i = 0; $i < $days - 1; $i++){
            if ($isCapitalization){
                $add = $cash * $percent / 100;
            }

            $cash = $cash + $add;

            printf("Баланс за день № %s = %s <br>", ($i + 1), $cash);
            printf("Получено за день = %s <br>", $add);
            echo "<hr>";
        }

        echo "<br>";
        $percentSum = $cash - $sum;
        printf("Ваш балланс за %s дней = %s <br>", $days, $cash);
        printf("Ваши вложения = %s <br>", $begin);
        $allPercent = (100 * $cash / $begin) - 100; // 100% = $begin; x% = $cash;
        printf("Ваш процент = %s (%s %% - от суммы вложений) <br>", $percentSum, $allPercent);
        return true;
    }
}
