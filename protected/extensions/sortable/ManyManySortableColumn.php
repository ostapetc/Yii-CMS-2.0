<?php

class ManyManySortableColumn extends CDataColumn
{
    public $cssClass = null;
    public $headerText = null;
    public $assets = 'ext.sortable.assets.manyManySortable';
    public $value = 3;

    public function init()
    {
        parent::init();

        $this->addPocketData();
        $this->removeFromData();
        $this->grid->onRegisterScript = array(
            $this,
            'registerScript'
        );
    }

    public function addPocketData()
    {
        $name = "sortable_pocket_{$this->grid->cat_id}";

        if (Yii::app()->user->hasState($name))
        {
            $model               = $this->grid->dataProvider->model;
            $criteria            = $this->grid->dataProvider->getCriteria();
            $ids                 = Yii::app()->user->getState($name);
            $this->grid->_pocket = $model->findAllByPk(array_values($ids), $criteria);
        }
    }

    public function removeFromData()
    {
        $name = "sortable_pocket_{$this->grid->cat_id}";

        if (Yii::app()->user->hasState($name))
        {
            $model    = $this->grid->dataProvider->model;
            $criteria = $this->grid->dataProvider->model->getDbCriteria();
            $ids      = Yii::app()->user->getState($name);
            $criteria->addNotInCondition("`{$model->tableAlias}`.`{$model->tableSchema->primaryKey}`", $ids);
            $this->grid->dataProvider->model->setDbCriteria($criteria);
            $criteria = $this->grid->dataProvider->getCriteria();
            $criteria->addNotInCondition("`{$model->tableAlias}`.`{$model->tableSchema->primaryKey}`", $ids);
            $this->grid->dataProvider->setCriteria($criteria);
        }
    }

    /**
     * Registers necessary client scripts.
     */
    public function registerScript()
    {
        $id     = $this->grid->getId();
        $cat_id = $this->grid->cat_id;
        $url    = Yii::app()->getController()->createUrl('/main/helpAdmin/manyManySortable');
        $model  = $this->grid->dataProvider->modelClass;

        $this->assets = $assets = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias($this->assets));

        $options = CJavaScript::encode(array(
            'id'    => $id,
            'cat_id'=> $cat_id,
            'url'   => $url,
            'model' => $model
        ));

        Yii::app()->getClientScript()->registerScriptFile($assets . '/multiSortableGrid.js')->registerCssFile(
            $assets . '/sortableCGrid.css')->registerScript(
            'sort_grid_' . $id, "$('#{$id}').multiSortableGrid($options);");

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

    protected function renderDataCellContentEx()
    {
        return "<div class='positioner'><img src='" . $this->assets . "/img/hand.png' width='16'></div>";
    }

    public function renderDataCell($row, $data = null)
    {
        $data    = $this->grid->dataProvider->data[$row];
        $options = $this->htmlOptions;
        $pk      = $data->getPrimaryKey();
        if ($this->cssClassExpression !== null)
        {
            $class = $this->evaluateExpression($this->cssClassExpression, array(
                'row'  => $row,
                'data' => $data
            ));
            if (isset($options['class']))
            {
                $options['class'] .= 'pk ' . $class;
            }
            else
            {
                $options['class'] = $class;
            }
        }
        else
        {
            $options['class'] = 'pk';
        }

        $options['id'] = 'pk_' . $pk;

        echo CHtml::tag('td', $options, $this->renderDataCellContentEx($row, $data));
    }

}
