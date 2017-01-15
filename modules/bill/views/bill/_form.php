<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\bill\models\BillCategory;

/* @var $this yii\web\View */
/* @var $model app\modules\bill\models\Bill */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bill-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput() ?>


    <?= $form->field($model, 'category_id')->dropDownList(BillCategory::getList(),['prompt' => Yii::t('app', 'Select Category...')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
