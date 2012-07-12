<?

class EMultiSelect extends JuiInputWidget
{
    public $sortable   = true;

    public $searchable = true;

    public $height     = '175px';

    public $data;

    public $onchange;

    public $class;

    /**
     * Initializes everything
     *
     * @return void
     */
    public function init()
    {
        if (!$this->model instanceof CModel)
        {
            throw new CException(t('Needs `model` param instance of CModel'));
        }

        if (!is_array($this->data))
        {
            throw new CException(t('Needs `data` param as array'));
        }

        parent::init();
        $this->registerScripts();
    }


    /**
     * Registers the JS and CSS Files
     *
     * @return void
     */
    protected function registerScripts()
    {
        parent::registerCoreScripts();

        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($this->assets . '/ui.multiselect.css');
        $cs->registerScriptFile($this->assets . '/ui.multiselect.js', CClientScript::POS_END);

        $parameters = CJavaScript::encode(array(
            'sortable'     => $this->sortable,
            'searchable'   => $this->searchable,
            'height'       => $this->height,
            'onchange'     => $this->onchange
        ));

        $cs->registerScript('EMultiSelect',
            '$("#' . $this->id . '").multiselect(' . $parameters . ');', CClientScript::POS_READY);
    }


    public function run()
    {
        echo CHtml::activeDropDownList($this->model, $this->attribute, $this->data, array(
            'multiple' => 'multiple',
            'key'      => isset($this->key) ? $this->key : 'id',
            'class'    => 'multiselect'
        ));
    }
}

?>