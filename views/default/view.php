<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\web\UploadedFile;

/* @var $this yii\web\View */
/* @var $model andahrm\edoc\models\Edoc */

$this->title = $model->code . " " . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/edoc', 'Edocs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edoc-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('andahrm', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a(Yii::t('andahrm', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('andahrm', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])
        ?>
    </p>



    <?php
    if (preg_match('/\.pdf$/i', $model->file)) {
        echo \yii2assets\pdfjs\PdfJs::widget([
            'url' => Url::base() . '/..' . $model->getUploadUrl('file'),
            'buttons' => [
                'presentationMode' => false,
                'openFile' => false,
                'print' => true,
                'download' => true,
                'viewBookmark' => false,
                'secondaryToolbarToggle' => false,
                'fullscreen' => true,
            ]
        ]);
    } elseif ($model->file) {
        echo Html::img($model->getUploadUrl('file', 'preview'), ['class' => 'img-thumbnail', 'width' => "100%"]) . "<br/><br/>";
    }
    ?>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'code',
            'date_code:date',
            'title',
            'file',
            'file_name',
            'created_at:datetime',
            'created_by',
            'updated_at',
            'updated_by:datetime',
        ],
    ])
    ?>
</div>
