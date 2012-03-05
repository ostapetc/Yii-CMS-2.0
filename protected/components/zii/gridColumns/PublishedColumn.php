<?php
class PublishedColumn extends CDataColumn
{
    public $assets = 'application.components.zii.gridColumns.assets';
    public $html_true;
    public $html_false;

    public $htmlOptions = array(
        'style' => 'width:50px;text-align:center;'
    );


    public function init()
    {
        parent::init();

        $this->assets =
            Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias($this->assets)) . '/publishedColumn';

        $this->initVariables();
        $this->grid->onRegisterScript = array($this, 'registerScript');
    }

    public function initVariables()
    {
        if ($this->filter === null )
        {
            $this->filter = array(t("Нет"),t("Да"));
        }
        if ($this->html_true === null)
        {
            $this->html_true = '<span class="label label-success">'.t('Да').'</span>';
        }
        if ($this->html_false === null)
        {
            $this->html_false = '<span class="label label-important">'.t('Нет').'</span>';
        }
    }


    /**
     * Registers necessary client scripts.
     */
    public function registerScript()
    {
        $options = CJavaScript::encode(array(
            'html_true'       => $this->html_true,
            'html_false'      => $this->html_false,
            'model'           => $this->grid->dataProvider->modelClass,
            'attribute'       => $this->name,
        ));
        Yii::app()->clientScript->registerScriptFile($this->assets . '/js/publishedColumn.js')
            ->registerScript(get_class($this), "$('#{$this->grid->id}').publishedColumn({$options});");

    }

    public function renderDataCellContent($row, $data)
    {
        $html = $data->{$this->name} ? $this->html_true : $this->html_false;
        echo CHtml::link($html, Yii::app()->controller->createUrl('/main/helpAdmin/saveAttribute'), array(
            'data-id'    => $data->getPrimaryKey(),
            'data-value' => $data->is_published,
            'class'      => 'published_icon'
        ));
    }

}