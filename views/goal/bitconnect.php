<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\models\GoalBitconnectForm;

/* @var $this yii\web\View */
/* @var $model GoalBitconnectForm */
/* @var $years array */
/* @var $total integer */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <?php $form = ActiveForm::begin([
                    'id' => 'goal-bitconnect-form',
                    'fieldConfig' => [
//                        'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
//                        'labelOptions' => ['class' => 'col-lg-1 control-label'],
                    ],
                ]); ?>

                <?= $form->field($model, 'begin')->textInput(['autofocus' => true, 'value' => 100]) ?>
                <?= $form->field($model, 'percent')->textInput(['value' => 0.86]) ?>

                <?= $form->field($model, 'days')->textInput(['value' => 30]) ?>
                <?= $form->field($model, 'capitalize')->checkbox() ?>

                <div class="form-group">
                    <div class="col-lg-12">
                        <?= Html::submitButton('Count', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-lg-12">
                            Total: <?= $total; ?>
                        </div>
                    </div>
                </div>
                <?php if(isset($years)):?>
                <?php foreach ($years as $number => $year): ?>
                    <div class="row">
                        <div class="panel panel-info">
                            <div class="panel-heading">Panel heading Year #<?= $number + 1; ?></div>
                            <table class="table year text-center">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-center"><?=Yii::t('app', 'Current salary')?></th>
                                    <th class="text-center"><?=Yii::t('app', 'Remaining money')?></th>
                                    <th class="text-center"><?=Yii::t('app', 'Saved')?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($year['items'] as $key => $item): ?>
                                    <tr class="<?php echo (!($key % 2)) ? "active" : ""; ?>">
                                        <th scope="row"><?= $key + 1 ?></th>
                                        <td><?= $item['currentSalary']; ?></td>
                                        <td><?= $item['remainingMoney']; ?></td>
                                        <td><?= $item['saved'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="success">
                                    <th scope="row">Total:</th>
                                    <td></td>
                                    <td><?= Yii::t('app', 'Total in all years: ');?><?= $year['total_all']; ?></td>
                                    <td><?= Yii::t('app', 'Total in this year: ');?><?= $year['total_year'] ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php endif;?>
            </div>
        </div>

    </div>
</div>
