<?
/**
 * Single file-upload and remove widget
 * TODO:no preview non-image files
 */
class FileWidget extends InputWidget
{

    public function run()
    {
        $val = $this->model->{$this->attribute};
        if ((!$this->model->isNewRecord) && $val)
        {
            $id = $this->id . get_class($this);
            $files_data = $this->model->uploadFiles();
            $attribute_data = $files_data[$this->attribute];
            $directory = trim($attribute_data['dir'], '/');

            $preview = ImageHelper::thumb($directory, $val, array('width' => null, 'height'=> 128));
            $preview .= CHtml::ajaxLink('X', array('/main/helpAdmin/saveAttribute'), array(
                'type'    => 'post',
                'data'    => array(
                    'model'       => get_class($this->model),
                    'id'          => $this->model->primaryKey,
                    'attribute'   => $this->attribute,
                    'value'       => '',
                    'unlink_file' => $directory . '/' . $val,
                ),
                'success' => 'js:function() {$("#' . $id . '").remove();}'
            ), array('class'=> 'btn btn-danger delete-img'));
            echo CHtml::tag('div', array('id'=> $id), $preview);
        }
        echo CHtml::activeFileField($this->model, $this->attribute, $this->htmlOptions);
    }
}