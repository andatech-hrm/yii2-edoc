<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model andahrm\edoc\models\EdocInsignia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edoc-insignia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'edoc_id')->textInput() ?>

    <?= $form->field($model, 'book_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'part_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'public_date')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('andahrm/edoc', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
