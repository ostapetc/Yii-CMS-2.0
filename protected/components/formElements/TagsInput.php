<?

class TagsInput extends InputWidget
{
    private $element_name = 'tags';
    private $default_text = 'Введите тэги';


    public function run()
    {
        $model_class = get_class($this->model);
		
		$tags = '';
		
		if (!$this->model->isNewRecord) 
		{
			$sql = "SELECT GROUP_CONCAT(tags.name) AS tags
						   FROM tags
						   INNER JOIN tags_rels ON tags_rels.tag_id = tags.id
						   WHERE tags_rels.object_id = {$this->model->id} AND
								 tags_rels.model_id  = '{$model_class}'";
			
			$tags = Yii::app()->db->createCommand($sql)->queryScalar();		
		}

        $this->registerScripts($model_class);
        echo CHtml::textField("{$model_class}[{$this->element_name}]", $tags, array('id' => $model_class . '_' . $this->element_name, 'class' => 'text'));
    }


    public function registerScripts($model_class)
    {
        Yii::app()->getClientScript()
                  ->registerScriptFile($this->assets . '/jquery.tagsinput.min.js')
                  ->registerCssFile($this->assets . '/jquery.tagsinput.css')
                  ->registerScript(
                        'da',
                        '$("#' .  $model_class . '_' . $this->element_name . '").tagsInput({
                            "width"            : "420px",
                            "defaultText"      : "' . $this->default_text . '",
                            "autocomplete_url" : "/main/tag/autoComplete",
                            "minChars"         : 3
                        });',
                        CClientScript::POS_READY
                    );
    }

}
