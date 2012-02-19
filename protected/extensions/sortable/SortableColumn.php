<?php
class SortableColumn extends CDataColumn
{
    public $cssClass = null;
    public $headerText = null;
    public $value = 3;
    public $assets = 'ext.sortable.assets.sortable';

    public $headerHtmlOptions = array('style'=>'width: 50px');

    public function init()
    {
        parent::init();

        $this->assets = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias($this->assets));

        $this->grid->onRegisterScript = array(
            $this,
            'registerScript'
        );
    }

    /**
     * Registers necessary client scripts.
     */
    public function registerScript()
    {
        $id = $this->grid->getId();

        $url   = Yii::app()->createUrl("/main/helpAdmin/sortable");
        $model = $this->grid->dataProvider->modelClass;

        $options = CJavaScript::encode(array(
            'id'    => $id,
            'url'   => $url,
            'model' => $model
        ));

        Yii::app()->getClientScript()->registerCoreScript('jquery.ui')->registerScriptFile(
            $this->assets . '/sortableGrid.js')->registerScript(
            'sort_grid_' . $id, "$('#{$id}').sortableGrid({$options});");
    }

    protected function renderHeaderCellContent()
    {
        if ($this->headerText != null)
        {
            echo $this->headerText;
        }
        else
        {
            parent::renderHeaderCellContent();
        }
    }

    public function renderDataCellContent()
    {
        echo "<div class='positioner icon-sortable'></div>";
    }

    public function renderDataCell($row)
    {
        $data    = $this->grid->dataProvider->data[$row];
        $options = $this->htmlOptions;
        $pk      = $this->grid->dataProvider->data[$row]->getPrimaryKey();
        $options['class'] = 'sortable_col';
        if ($this->cssClassExpression !== null)
        {
            $class = $this->evaluateExpression($this->cssClassExpression, array(
                'row' => $row,
                'data'=> $data
            ));
            $options['class'] .= ' pk ' . $class;
        }
        else
        {
            $options['class'] .= ' pk';
        }

        $options['id'] = 'pk_' . $pk;

        echo CHtml::openTag('td', $options);
        $this->renderDataCellContent($row, $data);
        echo '</td>';
    }

}
