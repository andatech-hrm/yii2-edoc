<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model andahrm\edoc\models\EdocInsignia */

$this->title = $model->edoc_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/edoc', 'Edoc Insignias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edoc-insignia-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('andahrm/edoc', 'Update'), ['update', 'id' => $model->edoc_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('andahrm/edoc', 'Delete'), ['delete', 'id' => $model->edoc_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('andahrm/edoc', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'edoc_id',
            'book_number',
            'part_number',
            'book_at',
            'public_date',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
