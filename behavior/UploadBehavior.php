<?php

namespace andahrm\edoc\behavior;

use Yii;
use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
/**
 * UploadBehavior automatically uploads file and fills the specified attribute
 * with a value of the name of the uploaded file.
 *
 * To use UploadBehavior, insert the following code to your ActiveRecord class:
 *
 * ```php
 * use mongosoft\file\UploadBehavior;
 *
 * function behaviors()
 * {
 *     return [
 *         [
 *             'class' => UploadBehavior::className(),
 *             'attribute' => 'file',
 *             'scenarios' => ['insert', 'update'],
 *             'path' => '@webroot/upload/{id}',
 *             'url' => '@web/upload/{id}',
 *         ],
 *     ];
 * }
 * ```
 *
 * @author Alexander Mohorev <dev.mohorev@gmail.com>
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */
class UploadBehavior extends \mongosoft\file\UploadBehavior
{  
  
    public $attributeName;
   
    private $_file;
  
    private $_file_name;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->attributeName === null) {
            throw new InvalidConfigException('กรุณาใส่ค่า "attributeName" .');
        }
    }
    

    /**
     * This method is invoked before validation starts.
     */
    public function beforeValidate()
    {
        /** @var BaseActiveRecord $model */
        $model = $this->owner;
        if (in_array($model->scenario, $this->scenarios)) {
            if (($file = $model->getAttribute($this->attribute)) instanceof UploadedFile) {
                $this->_file = $file;
            } else {
                if ($this->instanceByName === true) {
                    $this->_file = UploadedFile::getInstanceByName($this->attribute);
                } else {
                    $this->_file = UploadedFile::getInstance($model, $this->attribute);
                }
            }
            if ($this->_file instanceof UploadedFile) {     
                $this->_file_name =  $this->_file->name;
                $model->setAttribute($this->attributeName,$this->_file_name);              
                $this->_file->name = $this->getFileName($this->_file);
                $model->setAttribute($this->attribute, $this->_file);
                
            }
        }
    }

    /**
     * This method is called at the beginning of inserting or updating a record.
     */
    public function beforeSave()
    {
        /** @var BaseActiveRecord $model */
        $model = $this->owner;
        if (in_array($model->scenario, $this->scenarios)) {
            if ($this->_file instanceof UploadedFile) {
                if (!$model->getIsNewRecord() && $model->isAttributeChanged($this->attribute)) {
                    if ($this->unlinkOnSave === true) {
                        $this->delete($this->attribute, true);
                    }
                }                
                $model->setAttribute($this->attributeName, $this->_file_name);
                $model->setAttribute($this->attribute, $this->_file->name);  
            } else {
                // Protect attribute
                unset($model->{$this->attribute});
            }
        } else {
            if (!$model->getIsNewRecord() && $model->isAttributeChanged($this->attribute)) {
                if ($this->unlinkOnSave === true) {
                    $this->delete($this->attribute, true);
                }
            }
        }
    }

}
