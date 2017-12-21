<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\models\GoalBitconnectForm;

/* @var $this yii\web\View */
/* @var $model GoalBitconnectForm */
/* @var $resultDays array */
/* @var $resultAll array*/

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <?php $form = ActiveForm::begin([
                    'id' => 'goal-bitconnect-form',
                ]); ?>

                <?= $form->field($model, 'begin')->textInput(['autofocus' => true, 'value' => $model->begin ? $model->begin: 100]) ?>
                <?= $form->field($model, 'percent')->textInput(['value' => $model->percent ? $model->percent: 0.86]) ?>

                <?= $form->field($model, 'days')->textInput(['value' => $model->days ? $model->days: 30]) ?>
                <?= $form->field($model, 'capitalize')->checkbox() ?>

                <div class="form-group">
                    <div class="col-lg-12">
                        <?= Html::submitButton('Count', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
            <div class="col-lg-8">
                <?php if(isset($resultDays)):?>
                    <div class="row">
                        <div class="panel panel-info">
                            <div class="panel-heading">Panel heading days</div>
                            <table class="table year text-center">
                                <thead>
                                <tr>
                                    <th><?=Yii::t('app', 'Day')?> #</th>
                                    <th class="text-center"><?=Yii::t('app', 'Balance')?></th>
                                    <th class="text-center"><?=Yii::t('app', 'Earned')?></th>
                                    <th class="text-center"><?=Yii::t('app', 'Earned All')?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($resultDays as $key => $day): ?>
                                    <tr class="<?php echo (!($key % 2)) ? "active" : ""; ?>">
                                        <th scope="row"><?= $key + 1 ?></th>
                                        <td><?= Yii::$app->formatter->asCurrency($day['balance']); ?></td>
                                        <td><?= Yii::$app->formatter->asCurrency($day['earned']); ?></td>
                                        <td><?= Yii::$app->formatter->asCurrency($day['earned']); ?></td>
                                    </tr>
                                <?php endforeach; ?>

                                <tr class="success">
                                    <th scope="row">Total:</th>
                                    <td><?= Yii::t('app', 'Your balance: ');?><?= Yii::$app->formatter->asCurrency($resultAll['balance']); ?></td>
                                    <td><?= Yii::t('app', 'Total Earned ');?><?= Yii::$app->formatter->asCurrency($resultAll['earned']); ?></td>
                                    <td><?= Yii::t('app', 'Total Earned in percent: ');?><?= Yii::$app->formatter->asCurrency($resultAll['allPercent']) ?> %</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif;?>
            </div>
        </div>

    </div>
</div>
