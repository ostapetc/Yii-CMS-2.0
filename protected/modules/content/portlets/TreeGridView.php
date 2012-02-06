<?php
class TreeGridView extends AdminGrid
{
    public $baseTreeTableUrl;

    public function init()
    {
        $this->afterAjaxUpdate          = 'function(id, data) {$("#"+id+" .items").treeTable();}';
        $this->dataProvider->pagination = false;

        parent::init();
        if ($this->baseTreeTableUrl === null)
        {
            $this->baseTreeTableUrl = $this->assets . '/js/plugins/treeTable/';
        }

        //Calc parent id from nesteD set
        if (count($this->dataProvider->data))
        {
            $level         = $this->dataProvider->data[0]->tree->levelAttribute;
            $stack         = array();
            $currentLevel  = 0;
            $previousModel = null;
            try
            {
                foreach ($this->dataProvider->data as $model)
                {
                    if ($model->$level == 1)
                    { //root with level=2
                        $model->parentId = 0;
                        $currentLevel    = 1;
                    }
                    else
                    {
                        if ($model->$level == $currentLevel)
                        {

                            if (is_null($stack[count($stack) - 1]))
                            {
                                throw new Exception('Tree is corrupted');
                            }
                            $model->parentId = $stack[count($stack) - 1]->getPrimaryKey();
                        }
                        elseif ($model->$level > $currentLevel)
                        {
                            if (is_null($previousModel))
                            {
                                throw new Exception('Tree is corrupted');
                            }
                            $currentLevel    = $model->$level;
                            $model->parentId = $previousModel->getPrimaryKey();
                            array_push($stack, $previousModel);
                        }
                        elseif ($model->$level < $currentLevel)
                        {
                            for ($i = 0; $i < $currentLevel - $model->$level; $i++)
                            {
                                array_pop($stack);
                            }
                            if (is_null($stack[count($stack) - 1]))
                            {
                                throw new Exception('Tree is corrupted');
                            }
                            $currentLevel    = $model->$level;
                            $model->parentId = $stack[count($stack) - 1]->getPrimaryKey();
                        }
                    }
                    $previousModel = $model;
                }
            } catch (Exception $e)
            {
                Yii::app()->user->setFlash('CQTeeGridView', $e->getMessage());
            }
        }
    }

    public function behaviors()
    {
        return array(
            'Widget' => array(
                'class' => 'application.components.behaviors.ComponentBehavior'
            )
        );
    }

    /**
     * Registers necessary client scripts.
     */
    public function registerClientScript()
    {
        parent::registerClientScript();

        Yii::app()->getClientScript()->registerCoreScript('jquery.ui')->registerScriptFile(
            $this->baseTreeTableUrl . 'javascripts/jquery.treeTable.js', CClientScript::POS_END)
            ->registerCssFile($this->baseTreeTableUrl . 'stylesheets/jquery.treeTable.css')
            ->registerScript('treeTable', '
                $(document).ready(function()  {
                  $("#' . $this->getId() . ' .items").treeTable();
                });
            ');

    }

    /**
     * Renders the data items for the grid views.
     */
    public function renderItems()
    {
        if (Yii::app()->user->hasFlash('CQTeeGridView'))
        {
            print'<div style="background-color:#ffeeee;padding:7px;border:2px solid #cc0000;">' .
                Yii::app()->user->getFlash("CQTeeGridView") . '</div>';
        }
        parent::renderItems();
    }

    /**
     * Renders a table body row with id and parentId, needed for ActsAsTreeTable
     * jQuery extension.
     *
     * @param integer $row the row number (zero-based).
     */
    public function renderTableRow($row)
    {
        $model     = $this->dataProvider->data[$row];
        $parent    = $model->getParent();
        $parent_id = $parent ? $parent->id : '';

        $parentClass = $parent_id ? 'child-of-node-' . $parent_id . ' ' : '';
        //        if ($model->id == 10) {
        //            Y::dump($model->getParent()->id . ' ' . $parentClass);
        //        }

        $ir = $model->isRoot();

        if ($this->rowCssClassExpression !== null)
        {
            echo'<tr id="node-' . $model->id . '" class="' . ($ir ? 'root' : '') . ' ' . $parentClass .
                $this->evaluateExpression($this->rowCssClassExpression, array(
                    'row' => $row,
                    'data'=> $model
                )) . '">';
        }
        else if (is_array($this->rowCssClass) && ($n = count($this->rowCssClass)) > 0)
        {
            echo
                '<tr id="node-' . $model->getPrimaryKey() . '" class="' . ($ir ? 'root' : '') . ' ' .
                $parentClass . $this->rowCssClass[$row % $n] . '">';
        }
        else
        {
            echo'<tr id="node-' . $model->getPrimaryKey() . '" class="' . ($ir ? 'root' : '') . ' ' .
                $parentClass . '">';
        }

        foreach ($this->columns as $column)
        {
            $column->renderDataCell($row);
        }

        echo "</tr>\n";
    }

}
