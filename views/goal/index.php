<?php
use yii\bootstrap\ActiveForm;
use app\models\GoalForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model GoalForm */
/* @var $years array */
/* @var $total integer */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <?php $form = ActiveForm::begin([
                    'id' => 'goal-form',
//                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-1 control-label'],
                    ],
                ]); ?>

                <?= $form->field($model, 'currentSalary')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'spending')->textInput() ?>

                <?= $form->field($model, 'amountUp')->textInput() ?>
                <?= $form->field($model, 'month')->textInput() ?>

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
                        <span class="label label-default">Default</span>
                        <span class="label label-primary">Primary</span>
                        <span class="label label-success">Success</span>
                        <span class="label label-info">Info</span>
                        <span class="label label-warning">Warning</span>
                        <span class="label label-danger">Danger</span>
                    </div>
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
