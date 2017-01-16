<?php

namespace andahrm\edoc;

/**
 * edoc module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'andahrm\edoc\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
      
      $this->layout= 'main';
        parent::init();

        // custom initialization code goes here
    }
}
