<?php

namespace andahrm\edoc\models;

use Yii;

/**
 * This is the model class for table "edoc_insignia".
 *
 * @property int $edoc_id
 * @property string $book_number File
 * @property string $part_number ชื่อไฟล์
 * @property string $book_at
 * @property string $public_date
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property Edoc $edoc
 */
class EdocInsignia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'edoc_insignia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['edoc_id', 'book_number', 'part_number', 'book_at'], 'required'],
            [['edoc_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['public_date'], 'safe'],
            [['book_number', 'part_number', 'book_at'], 'string', 'max' => 20],
            [['edoc_id'], 'unique'],
            [['edoc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edoc::className(), 'targetAttribute' => ['edoc_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'edoc_id' => Yii::t('andahrm/edoc', 'Edoc ID'),
            'book_number' => Yii::t('andahrm/edoc', 'Book Number'),
            'part_number' => Yii::t('andahrm/edoc', 'Part Number'),
            'book_at' => Yii::t('andahrm/edoc', 'Book At'),
            'public_date' => Yii::t('andahrm/edoc', 'Public Date'),
            'created_at' => Yii::t('andahrm/edoc', 'Created At'),
            'created_by' => Yii::t('andahrm/edoc', 'Created By'),
            'updated_at' => Yii::t('andahrm/edoc', 'Updated At'),
            'updated_by' => Yii::t('andahrm/edoc', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdoc()
    {
        return $this->hasOne(Edoc::className(), ['id' => 'edoc_id']);
    }
}
