<?php
class UploadHtml
{
    public static function url($url, $params = array())
    {
        return Yii::app()->createUrl("/fileManager/".$url, $params);
    }


    public static function link($text, $url, $urlParams = array(), $htmlOptions = array())
    {
        return CHtml::link($text, self::url($url, $urlParams), $htmlOptions);
    }


    public static function editableLink($text, $model, $attr, $url, $htmlOptions=array(), $type='text')
    {
        $name = CHtml::resolveName($model, $attr);
        $htmlOptions = CMap::mergeArray($htmlOptions, array('name'=>$name, 'type'=>$type));
        return CHtml::link($text, self::url($url, array('id'=>$model->id, 'attr'=>$attr )), $htmlOptions);
    }
}