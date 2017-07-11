<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel andahrm\edoc\models\EdocSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/edoc', 'Edocs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edoc-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('andahrm/edoc', 'Create Edoc'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php //Pjax::begin(); ?>    
   <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'code',
            'date_code:date',
            //'testDate',
            //'title',
             [
                 'attribute' => 'title',
                 'format' => 'html',
                 'value'=>function($model){
                     return ($model->file?Html::a("<i class='fa fa-paperclip'></i>",$model->getUploadUrl('file'),["data-pjax"=>"0",'class'=>'text-danger'])." ":"")
                     .$model->title;
                 },
            ],
            //'file',
            
             'created_at:datetime',
             [
                 'attribute' => 'created_by',
                 'value'=>'createdBy.fullname',
                 ],
             //'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php //Pjax::end(); ?>
</div>
