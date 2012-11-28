<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artem.ostapetc
 * Date: 26.06.12
 * Time: 15:31
 * To change this template use File | Settings | File Templates.
 */
class TreeCheckboxSelect extends JuiInputWidget
{
    public $tree_model;

    public $parent_attribute = 'parent_id';


    public function init()
    {
        parent::init();

        if (!$this->tree_model instanceof ActiveRecord)
        {
            throw new CException('Needs param tree_model instanceof ActiveRecord!');
        }
    }


    public function run()
    {
        Yii::app()->clientScript->registerScriptFile($this->assets . 'TreeCheckboxSelect.js');

        $attribute_name = array_shift($this->resolveNameID()) . '[]';

        echo CHtml::openTag('div', array('class' => 'tree-checkbox-select'));
        $this->renderRecursive($attribute_name);
        echo CHtml::closeTag('div');
    }



    public function renderRecursive($attribute_name, $parent_id = null)
    {
        echo CHtml::openTag('ul');

        $nodes = $this->tree_model->findAllByAttributes(array($this->parent_attribute => $parent_id));
        foreach ($nodes as $node)
        {
            echo CHtml::openTag('li');

            echo CHtml::checkBox(
                $attribute_name,
                '',
                array(
                    'style' => 'margin-right: 5px',
                    'value' => $node->id,
                    'class' => 'node'
            ));

            echo $node->name;
            $this->renderRecursive($attribute_name, $node->id);
            echo CHtml::closeTag('li');
        }

        echo CHtml::closeTag('ul');
    }
}
