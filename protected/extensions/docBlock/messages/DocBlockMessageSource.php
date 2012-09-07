<?php
class DocBlockMessageSource extends CPhpMessageSource
{
    public $basePath;

    public function init()
    {
        $this->basePath = Yii::getPathOfAlias('ext.docBlock.messages');
        parent::init();
    }
}
