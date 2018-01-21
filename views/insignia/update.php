<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\edoc\models\EdocInsignia */

$this->title = Yii::t('andahrm/edoc', 'Update Edoc Insignia: ' . $model->edoc_id, [
    'nameAttribute' => '' . $model->edoc_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/edoc', 'Edoc Insignias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->edoc_id, 'url' => ['view', 'id' => $model->edoc_id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm/edoc', 'Update');
?>
<div class="edoc-insignia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
