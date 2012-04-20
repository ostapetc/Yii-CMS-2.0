<?
/**
 * EMultiSelect class file.
 *
 * PHP Version 5.1
 *
 * @category Vencidi
 * @package  Widget
 * @author   Loren <wiseloren@yiiframework.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     http://www.vencidi.com/ Vencidi
 * @since    3.0
 */
/**
 * EMultiSelect Creates Multiple Select Boxes
 *
 * @category Vencidi
 * @package  Widget
 * @author   Loren <wiseloren@yiiframework.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @version  Release: 1.0
 * @link     http://www.vencidi.com/ Vencidi
 * @since    3.0
 */
class EMultiSelect extends JuiInputWidget
{
    public $sortable = true;
    public $searchable = true;
    public $height = '175px';
    public $onchange;
    public $class;


    /**
     * Initializes everything
     *
     * @return void
     */
    public function init()
    {
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
            '$("#'.$this->id.'").multiselect(' . $parameters . ');', CClientScript::POS_READY);
    }


    public function run()
    {
        echo CHtml::activeDropDownList($this->model, $this->attribute, $this->input_element->items, array(
            'multiple' => 'multiple',
            'key'      => isset($this->key) ? $this->key : 'id',
            'class'    => 'multiselect'
        ));
    }
}

?>