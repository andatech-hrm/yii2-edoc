<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel andahrm\edoc\models\EdocInsigniaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/edoc', 'Edoc Insignias');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edoc-insignia-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('andahrm/edoc', 'Create Edoc Insignia'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'book_number',
            'part_number',
            'book_at',
            [
                'attribute' => 'public_date',
                'format' => 'date',
                'value'=>function($model){
                    if($model->public_date == '0000-00-00') return null;
                    return $model->public_date;
                }
            ],
            [
                'attribute' => 'book_date',
                'format' => 'date',
                'value'=>function($model){
                    if($model->book_date == '0000-00-00') return null;
                    return $model->book_date;
                }
            ],
                    'usage',
            [
                'attribute' => 'file',
                'format' => 'html',
                'value'=>function($model){
                    if($model->file == null) return null;
                    return Html::a($model->file,$model->getUploadUrl('file'));
                }
            ],
            //'file_name',
            'created_at:datetime',
            //'created_by',
            //'updated_at',
            //'updated_by',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
