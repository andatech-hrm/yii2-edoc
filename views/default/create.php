<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\edoc\models\Edoc */

$this->title = Yii::t('andahrm/edoc', 'Create Edoc');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/edoc', 'Edocs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edoc-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'formAction' => $formAction
    ]) ?>

</div>
