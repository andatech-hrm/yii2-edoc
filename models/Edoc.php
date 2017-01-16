<?php

namespace andahrm\edoc\models;

use Yii;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use mongosoft\file\UploadBehavior;
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
            [['code', 'date_code', 'title', 'file'], 'required'],
            [['date_code'], 'safe'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['title','file_name'], 'string', 'max' => 255],
            ['file', 'file', 'extensions' => 'doc, docx, pdf', 'on' => ['insert', 'update']],
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
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/edoc', 'ID'),
            'code' => Yii::t('andahrm/edoc', 'เลขที่หนังสือ'),
            'date_code' => Yii::t('andahrm/edoc', 'ลงวันที่'),
            'title' => Yii::t('andahrm/edoc', 'ชื่อหนังสือ'),
            'file' => Yii::t('andahrm/edoc', 'ไฟล์เอกสารแนบ'),
            'file_name' => Yii::t('andahrm/edoc', 'ชื่อไฟล์'),
            'created_at' => Yii::t('andahrm/edoc', 'Created At'),
            'created_by' => Yii::t('andahrm/edoc', 'Created By'),
            'updated_at' => Yii::t('andahrm/edoc', 'Updated At'),
            'updated_by' => Yii::t('andahrm/edoc', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonPostionSalaries()
    {
        return $this->hasMany(PersonPostionSalary::className(), ['edoc_id' => 'id']);
    }
  
  public static function getList(){
      return ArrayHelper::map(self::find()->all(),'id','code');
    }
}
