<?
class GridView extends BootGridView
{
    public $pager = array('class'=> 'LinkPager');
    public $template = '{items}<br/>{pager}';

    public function init()
    {
        $this->dataProvider->model->onBeforeGridInit(new CModelEvent($this));
        parent::init();
        $this->dataProvider->model->onAfterGridInit(new CModelEvent($this));
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
        $this->dataProvider->model->onBeforeGridInitColumns(new CModelEvent($this));

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
        $this->dataProvider->model->onAfterGridInitColumns(new CModelEvent($this));
    }
}