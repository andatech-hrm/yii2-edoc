<?php

namespace andahrm\edoc\models;

use Yii;
use yii\helpers\Html;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use kuakling\datepicker\behaviors\DateBuddhistBehavior;
use andahrm\setting\models\Helper;
use yii\helpers\ArrayHelper;
use mongosoft\file\UploadBehavior;
use andahrm\person\models\Person;
//use andahrm\edoc\behavior\UploadBehavior;
/**
 * This is the model class for table "edoc".
 *
 * @property integer $id
 * @property string $code
 * @property string $date_code
 * @property string $title
 * @property string $file
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property PersonPostionSalary[] $personPostionSalaries
 */
class Edoc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'edoc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'date_code', 'title',], 'required'],
            [['date_code'], 'safe'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['title','file_name'], 'string', 'max' => 255],
            ['file', 'file', 'extensions' => 'png, jpg, pdf', 'on' => ['insert', 'update']],
        ];
    }
  
   /**
     * @inheritdoc
     */
    function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => TimestampBehavior::className(),
            ],
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'file',
                //'attributeName' => 'file_name',
                'scenarios' => ['insert', 'update'],
                'path' => '@uploads/edoc/{id}',
                'url' => '/uploads/edoc/{id}',
            ],
            'date_code' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'date_code',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/edoc', 'ID'),
            'code' => Yii::t('andahrm/edoc', 'Code'),
            'date_code' => Yii::t('andahrm/edoc', 'Date Code'),
            'title' => Yii::t('andahrm/edoc', 'Title'),
            'file' => Yii::t('andahrm/edoc', 'File'),
            'file_name' => Yii::t('andahrm/edoc', 'File name'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
        ];
    }
    
     public function getCreatedBy(){      
        return  $this->hasOne(Person::className(), ['user_id' => 'created_by']);
    }
  
    public function getUpdatedBy(){      
        return  $this->hasOne(Person::className(), ['user_id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonPostionSalaries()
    {
        return $this->hasMany(PersonPostionSalary::className(), ['edoc_id' => 'id']);
    }
  
    public static function getList(){
      return ArrayHelper::map(self::find()->all(),'id','codeTitle1');
    }
    
    public function getCodeTitle(){
        return $this->code."<br/>".$this->title."<br/><small>".Yii::$app->formatter->asDate($this->date_code)."</small>";
    }
    
    public function getCodeDateTitle(){
        return $this->code." ".Yii::$app->formatter->asDate($this->date_code)."<br/>".$this->title;
    }
    
    public function getCodeDateTitleFile(){
        return $this->code." ".Yii::$app->formatter->asDate($this->date_code)
        ."<br/>".$this->title
        .($this->file?"<br/>"
        .Html::a("<i class='fa fa-papercl'></i>".$this->getAttributeLabel('file'),
        $this->getUploadUrl('file'),
        ['data-pjax'=>0,'target'=>'_blank']):'');
    }
    
    public function getCodeTitle1(){
        return $this->code." ".Yii::$app->formatter->asDate($this->date_code)." ".$this->title;
    }
    
    public function getCodeTitlePrint(){
        return $this->code." ".Yii::$app->formatter->asDate($this->date_code);
    }
}
