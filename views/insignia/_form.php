<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
use andahrm\datepicker\DatePicker;
use kartik\widgets\FileInput;
use kartik\widgets\Typeahead;
use andahrm\setting\models\WidgetSettings;

/* @var $this yii\web\View */
/* @var $model andahrm\edoc\models\Edoc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edoc-form">

    <?php if ($model->file): ?>
        <div class="row">
            <div class="col-sm-12">
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
                } else {
                    echo Html::img($model->getUploadUrl('file', 'preview'), ['class' => 'img-thumbnail', 'width' => "100%"]) . "<br/><br/>";
                }
                ?>
            </div>
        </div>
<?php endif; ?>


<?php
$formOptions['options'] = ['enctype' => 'multipart/form-data'];
if ($formAction !== null)
    $formOptions['action'] = $formAction;
?>
    <?php $form = ActiveForm::begin($formOptions);
    ?>  

    <div class="row">
        <div class="col-sm-3">   
            <?php echo $form->field($model, 'book_number')->textInput(); ?>
        </div>

        <div class="col-sm-3">   
            <?php echo $form->field($model, 'part_number')->textInput(); ?>
        </div>

        <div class="col-sm-3">   
            <?php echo $form->field($model, 'book_at')->textInput(); ?>
        </div>      

        <div class="col-sm-3">        
            <?php echo $form->field($model, 'book_date')->widget(DatePicker::classname(), WidgetSettings::DatePicker()); ?>
        </div>
    </div>
    

    <div class="row">
        <div class="col-sm-3">        
            <?php echo $form->field($model, 'public_date')->widget(DatePicker::classname(), WidgetSettings::DatePicker()); ?>
        </div>
        <div class="col-sm-9">
            <?=
            $form->field($model, 'file')->widget(FileInput::classname(), [
                'options' => ['accept' => ['pdf/*', 'image/*']],
                'pluginOptions' => [
                    'previewFileType' => 'pdf',
                    //'elCaptionText' => '#customCaption',
                    'uploadUrl' => Url::to(['/edoc/default/file-upload']),
                    'showPreview' => false,
                    'showCaption' => true,
                    'showRemove' => true,
                    'showUpload' => false,
                ],
            ]);
            ?>
            <span id="customCaption" class="text-success">No file selected</span>




        </div>
    </div>

    <hr/>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm', 'Create') : Yii::t('andahrm', 'Update'), ['name' => 'save', 'value' => 1, 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<?php
///Surakit
if ($formAction !== null) {
    $js[] = <<< JS
$(document).on('submit', '#{$form->id}', function(e){
  e.preventDefault();
  var form = $(this);
  var formData = new FormData(form[0]);
  // alert(form.serialize());
  
  $.ajax({
    url: form.attr('action'),
    type : 'POST',
    data: formData,
    contentType:false,
    cache: false,
    processData:false,
    dataType: "json",
    success: function(data) {
      if(data.success){
        callbackEdoc(data.result,"#{$form->id}");
      }else{
        alert('Fail');
      }
    }
  });
});
JS;

    $this->registerJs(implode("\n", $js));
}
?>