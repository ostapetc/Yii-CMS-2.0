<?php

Yii::import("zii.widgets.grid.CGridView");


class AdminGridView extends BootGridView
{
    public $itemsCssClass = "table table-striped table-bordered table-condensed";

    public $cssFile = null;

    public $filters;

    public $pager = array('class'=> 'AdminLinkPager');

    public $buttons = null;

    public $sortable = false;
    public $many_many_sortable = false;
    public $cat_id = false;

    public $_pocket;

    public $mass_removal = false;
    public $filter_hint = false;

    public $template = '{pagerSelect}{summary}<br/>{pocket}{items}{pager}';


    public function init()
    {
        $this->attachBehaviors($this->behaviors());

        if (!isset($this->htmlOptions['class']))
        {
            $this->htmlOptions['class'] = 'grid-view';
        }

        if (!isset($this->htmlOptions['id']))
        {
            $this->htmlOptions['id'] = $this->getId();
        }

        if ($this->baseScriptUrl === null)
        {
            $this->baseScriptUrl = Yii::app()->getAssetManager()
                ->publish(Yii::getPathOfAlias('application.components.zii.assets'), false, -1, true) .
                '/adminGrid';
        }

        if ($this->cssFile !== false)
        {
            if ($this->cssFile === null)
            {
                $this->cssFile = $this->baseScriptUrl . '/styles.css';
            }
            Yii::app()->getClientScript()->registerCssFile($this->cssFile);
        }

        $this->initColumns();

        $this->formatDateValues();
    }


    public function behaviors()
    {
        return array();
    }


    public function formatDateValues()
    {
        $data = $this->dataProvider->data;

        foreach ($data as $item)
        {
            foreach ($item as $attr => $value)
            {
                if (!Yii::app()->dater->isDbDate($value))
                {
                    continue;
                }

                if (!($column = $this->findColumnByName($attr))) //if hasn't column for it attr
                {
                    continue;
                }

                if ($column->value != null) //if set value of column
                {
                    continue;
                }


                $no_values = array('0000-00-00 00:00:00', '0000-00-00');
                $new_value = in_array($value, $no_values) ? null : Yii::app()->dater->readableFormat($value);

                if (is_array($item))
                {
                    $item[$attr] = $new_value;
                }
                else
                {
                    $item->$attr = $new_value;
                }
            }

        }

        $this->dataProvider->setData($data);
    }


    public function findColumnByName($attr)
    {
        foreach ($this->columns as $col)
        {
            if (isset($col->name) && $col->name == $attr)
            {
                return $col;
            }
        }
    }


    /**
     * Добавляет колонки перед последней колонкой
     *
     * @param $configs конфиги для колонок
     */
    public function addColumns($configs, $pos = 0)
    {
        $last_index = $pos >= 0 ? $pos : count($this->columns) + $pos;
        $configs[]  = $this->columns[$last_index];
        array_splice($this->columns, $last_index, 1, $configs);
    }


    /**
     * Добавляет колонку перед последней колонкой
     * @param $config конфиг колонки
     */
    public function addColumn($config, $pos = 0)
    {
        $last_index = $pos >= 0 ? $pos : count($this->columns) + $pos;
        $configs    = array(
            $config, $this->columns[$last_index]
        );
        array_splice($this->columns, $last_index, 1, $configs);
    }


    public function initColumns()
    {
        if ($this->many_many_sortable)
        {
            $this->addColumn(array(
                'class' => 'ext.sortable.ManyManySortableColumn',
                'header'=> t('Сортировка')
            ), -1);
        }

        if ($this->sortable)
        {
            $this->addColumn(array(
                'class' => 'ext.sortable.SortableColumn',
                'header'=> t('Сортировка')
            ), -1);
        }

        if ($this->mass_removal)
        {
            $this->addColumn(array(
                'class'               => 'CCheckBoxColumn',
                'header'              => "<input type='checkbox' class='object_checkboxes'>",
                'selectableRows'      => 2,
                'checkBoxHtmlOptions' => array(
                    'class'    => 'object_checkbox'
                )
            ));
        }
        parent::initColumns();
    }


    public function renderItems()
    {
        if ($this->dataProvider->getItemCount() > 0 || $this->showTableOnEmpty)
        {
            echo "<table class='{$this->itemsCssClass}' cellpadding='0' cellspacing='0' width='100%'>\n";
            $this->renderTableHeader();
            $this->renderTableBody();
            $this->renderTableFooter();
            echo "</table>";

            if ($this->mass_removal)
            {
                echo "<input type='submit' class='submit tiny red' value='удалить' id='mass_remove_button'>";
            }
        }
        else
        {
            $this->renderEmptyText();
        }
    }


    public function renderPocket()
    {
        if ($this->many_many_sortable)
        {
            $save = $this->dataProvider->getData(true);
            $this->dataProvider->setData($this->_pocket);
            $data = $this->_pocket;
            $n    = count($data);
            echo "<tbody class=\"pct sortt\">\n";

            echo '<tr id="pct_empty"><td colspan="' . count($this->columns) . '">';
            echo CHtml::tag('span', array('class'=> 'empty'), "Буфер обмена<br/>
                                Перетащите товара в данную область, что бы перенести ее на другую страницу данного раздела Панели управления.");
            echo "</td></tr>\n";

            if ($n > 0)
            {
                foreach ($data as $row=> $info)
                {
                    $this->renderTableRow($row, $info);
                }
            }
            echo "</tbody>\n";
            $this->dataProvider->setData($save);
        }

    }


    public function renderTableBody()
    {
        $data = $this->dataProvider->getData();

        $n = count($data);
        echo "<tbody class=\"sc sortt\">\n";

        if ($n > 0)
        {
            foreach ($data as $row=> $info)
            {
                $this->renderTableRow($row, $info);
            }
        }
        else
        {
            echo '<tr><td colspan="' . count($this->columns) . '">';
            $this->renderEmptyText();
            echo "</td></tr>\n";
        }
        echo "</tbody>\n";
    }


    public function renderPagerSelect()
    {
        $value = null;
        if ($per_page = Yii::app()->request->getParam('per_page'))
        {
            Yii::app()->user->setState(get_class($this->filter) . "per_page", $per_page);
        }
        $value = Yii::app()->user->getState(get_class($this->filter) . "per_page");

        echo '<div class="pager-select">';
        echo "&nbsp; &nbsp;" . t("Показывать на странице") . ": ";
        Yii::app()->controller->widget('application.components.formElements.Chosen.ChosenWidget', array(
            'name'       => "pager_pages",
            'current'    => $value,
            'items'      => array_combine(range(10, 500, 5), range(10, 500, 5)),
            'htmlOptions'=> array(
                'style'=>'width:60px',
                'class' => 'pager_select',
                'model' => get_class($this->filter)
            )
        ));
        echo '</div>';
    }


    /**
     * Изначально регистрируются 2 плагина gridBase и grid
     * Если установить значение свойства jsPlugin, то подключится так же плагин /css/admin/gridview/grid.js
     * И на сам grid будет инициализироват плагин с названием из jsPlugin
     */
    public function registerClientScript()
    {
        parent::registerClientScript();
        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery.ui');
        $cs->registerScriptFile("/js/plugins/gridview/gridBase.js");
        $cs->registerScriptFile("/js/plugins/gridview/grid.js");

        $options = CJavaScript::encode(array(
            'mass_removal' => $this->mass_removal,
            'filter_hint'  => $this->filter_hint
        ));
        $cs->registerScript($this->getId() . '.grid', "
            $('#{$this->getId()}').grid({$options});
        ");

        $this->onRegisterScript(new CEvent);
    }


    public function onRegisterScript($event)
    {
        $this->raiseEvent('onRegisterScript', $event);
    }
}
