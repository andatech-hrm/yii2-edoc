<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\edoc\models\Edoc */

$this->title = Yii::t('andahrm/edoc', 'Update {modelClass}: ', [
    'modelClass' => 'Edoc',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/edoc', 'Edocs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm/edoc', 'Update');
?>
<div class="edoc-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
