<?php

namespace andahrm\edoc\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use mongosoft\file\UploadBehavior;
####
use andahrm\datepicker\behaviors\DateBuddhistBehavior;

/**
 * This is the model class for table "edoc_insignia".
 *
 * @property string $book_number เล่ม
 * @property string $part_number ตอนที่
 * @property string $book_at เล่มที่
 * @property string $public_date วันที่ประกาศ
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property int $id
 * @property string $book_date ลงวันที่เล่ม
 * @property string $file
 * @property string $file_name
 *
 * @property InsigniaPerson[] $insigniaPeople
 */
class EdocInsignia extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'edoc_insignia';
    }

    /**
     * @inheritdoc
     */
    function behaviors() {
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
                'path' => '@uploads/edoc_insignia/{id}',
                'url' => '/uploads/edoc_insignia/{id}',
            ],
            'book_date' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'book_date',
            ],
            'public_date' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'public_date',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['public_date', 'book_date'], 'safe'],
                [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
                [['book_date'], 'required'],
                [['book_number', 'part_number', 'book_at'], 'string', 'max' => 20],
                [['file_name'], 'string', 'max' => 255],
                ['file', 'file', 'extensions' => 'png, jpg, pdf', 'on' => ['insert', 'update']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'book_number' => Yii::t('andahrm/edoc', 'Book Number'),
            'part_number' => Yii::t('andahrm/edoc', 'Part Number'),
            'book_at' => Yii::t('andahrm/edoc', 'Book At'),
            'public_date' => Yii::t('andahrm/edoc', 'Public Date'),
            'created_at' => Yii::t('andahrm/edoc', 'Created At'),
            'created_by' => Yii::t('andahrm/edoc', 'Created By'),
            'updated_at' => Yii::t('andahrm/edoc', 'Updated At'),
            'updated_by' => Yii::t('andahrm/edoc', 'Updated By'),
            'id' => Yii::t('andahrm/edoc', 'ID'),
            'book_date' => Yii::t('andahrm/edoc', 'Book Date'),
            'file' => Yii::t('andahrm/edoc', 'File'),
            'file_name' => Yii::t('andahrm/edoc', 'File Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsigniaPeople() {
        return $this->hasMany(InsigniaPerson::className(), ['edoc_insignia_id' => 'id']);
    }
    
    public static function getList() {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }

    public function getTitle() {
        $str[] = $this->getAttributeLabel('book_number') . ' ' . $this->book_number;
        $str[] = $this->getAttributeLabel('part_number') . ' ' . $this->part_number;
        $str[] = $this->getAttributeLabel('book_at') . ' ' . $this->book_at;
        $str[] = $this->getAttributeLabel('book_date') . ' ' . Yii::$app->formatter->asDate($this->book_date);
        $str[] = $this->getAttributeLabel('public_date') . ' ' . Yii::$app->formatter->asDate($this->public_date);
        return implode(', ', $str);
    }

}
