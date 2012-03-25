<?
/**
 * Add disabled field to form, automatic filling from $source field, but filing by tranliteration text.
 * Spaces change on $divider. Other trash will deleting
 * In $source field you can set simple name of soure attribute
 *
 * Добавляет disabled поле в форму, автоматически заполняемую текстом из поля $source, транслитерируя
 * перед этим текст из поля $source. Нетекстовые символы и прочий мусор удаляются
 * Обязательный параметр `source` - имя атрибута источника
 *
 * Render input and input[type=hidden], because jquery.serialize ignore disabled inputs
 *
 * Скрытое поле выводится для того, что бы сохранить валидацию, т.к. jquery.serialize игнорирует disabled поля
 *
 */
class AliasField extends InputWidget
{
    public $source = 'checkbox';
    public $divider = '-';


    public function init()
    {
        parent::init();
        $attrs = array();
        CHtml::resolveNameID($this->model, $this->source, $attrs);

        $options = CJavaScript::encode(array(
            'source' => $attrs['id'],
            'destination'  => $this->id,
            'urlSeparator' => $this->divider,
        ));
        Yii::app()->clientScript
            ->registerScriptFile($this->assets.'/jquery.synctranslit.js')
            ->registerScriptFile($this->assets.'/alias.js')
            ->registerScript($this->id . '_alias', "$('#{$this->id}').alias({$options});");
    }


    public function run()
    {
        echo CHtml::hiddenField($this->name, '', array(
            'id'=> $this->id . '_hidden'
        )); //beckause disabled elements no serialize
        echo CHtml::activeTextField($this->model, $this->attribute, array(
            'class' => 'text'
        ));
        echo '<div class="alias_preloader" ></div>';
    }
}