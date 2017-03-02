<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\Url;
use yii\web\JsExpression;

use kuakling\datepicker\DatePicker;
use kartik\widgets\FileInput;
use kartik\widgets\Typeahead;
use andahrm\setting\models\WidgetSettings;
/* @var $this yii\web\View */
/* @var $model andahrm\edoc\models\Edoc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edoc-form">
  <?php
  $formOptions['options'] = ['enctype' => 'multipart/form-data'];
  // if($formAction !== null)  $formOptions['action'] = $formAction;
  ?>
    <?php $form = ActiveForm::begin($formOptions); 
    ?>  
  
  <div class="row">
    <div class="col-sm-4">      
      <?php 
      /*$template = '<div class="block" style="border-bottom:1px;">'.
              '<div class="block_content">'.
              '<h2 class="title">{{code}}' .
              '<small class="pull-right">{{updated_at}}</small></h2>' .
              '<p class="excerpt">{{title}}</p>' .             
          '</div></div>';
      ?>
      <?php
      echo $form->field($model, 'code')->widget(Typeahead::classname(),[
              'options' => ['placeholder' => 'Filter as you type ...'],
              'pluginOptions' => ['highlight'=>true],
              'dataset' => [
                    [
                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                        'display' => 'value',
                        //'prefetch' => $baseUrl . '/samples/countries.json',
                        'remote' => [
                            'url' => Url::to(['/edoc/default/edoc-list']) . '?q=%QUERY',
                            'wildcard' => '%QUERY'
                        ],
                         'templates' => [
                            'notFound' => '<div class="text-success" style="padding:0 8px">ไม่พบเอกสารนี้</div>',
                            'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
                        ]
                    ]
                ],
              'pluginEvents' => [
                  "typeahead:select" => 'function(ev, resp) { 
                      window.location = "'.Url::to(['assign-person']).'?edoc_id="+resp.id;
                      //console.log(resp);
                  }',
               ]
          ])*/ ?>
        <?php echo $form->field($model, 'code')->textInput(); ?>
    </div>
  </div>
  
  <div class="x_panel">
  <div class="x_title">
    <h2>รายละเอียดเอกสาร</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    
    <div class="row">
      <div class="col-sm-8">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
      </div>
      <div class="col-sm-4">
        <?php /*echo $form->field($model, 'date_code')->widget(DatePicker::classname(), [              
                    'pluginOptions' => [
                        'todayHighlight' => true,
                        'autoclose' => true,
                        'daysOfWeekDisabled' => [0, 6],
                        'format' => 'yyyy-mm-dd',

                      //'startDate' => date('Y-m-d', strtotime("+3 day"))
                    ]
                ]);*/
                ?>
        <?php echo $form->field($model, 'date_code')->widget(DatePicker::classname(), WidgetSettings::DatePicker([
          // 'pluginOptions' => [
          //   'format' => 'yyyy-mm-dd',
          // ]
        ]));
        ?>
      </div>
    </div>
    
    <div class="well well-small">
        <?= $form->field($model, 'file')->widget(FileInput::classname(), [
            'options' => ['accept' => 'pdf/*'],
            'pluginOptions' => [
              'previewFileType' => 'pdf',
              //'showPreview' => false,
              'showCaption' => false,
              'elCaptionText' => '#customCaption',
              'uploadUrl' => Url::to(['/edoc/default/file-upload'])
            ]
        ]);?>
          <span id="customCaption" class="text-success">No file selected</span>
    </div>
  </div>
</div>
  <hr/>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm', 'Create') : Yii::t('andahrm', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<?php
///Surakit
// if($formAction !== null) {
// $js[] = <<< JS
// $(document).on('submit', '#{$form->id}', function(e){
//   e.preventDefault();
//   var form = $(this);
//   var formData = new FormData(form[0]);
//   // alert(form.serialize());
  
//   $.ajax({
//     url: form.attr('action'),
//     type : 'POST',
//     data: formData,
//     contentType:false,
//     cache: false,
//     processData:false,
//     dataType: "json",
//     success: function(data) {
//       if(data.success){
//         callbackEdoc(data.result);
//       }else{
//         alert('Fail');
//       }
//     }
//   });
// });
// JS;

// $this->registerJs(implode("\n", $js));
// }
?>