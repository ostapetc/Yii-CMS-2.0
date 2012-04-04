<?
/**
 * save one attribute of one model
 * if $_POST['bulk_update'] == true then make bulk update for many models, but only one attribute of one model
 */
class SaveAttributeAction extends CAction
{
    public function run()
    {
        if (isset($_POST['bulk_update']) && $_POST['bulk_update'] == true)
        {
            unset($_POST['bulk_update']);
            //may be in future there will be real bulk update
            foreach ($_POST['data'] as $options)
            {
                $this->_save($options);
            }
        }
        else
        {
            $this->_save($_POST);
        }
    }

    private function _save($options)
    {
        $model = ActiveRecord::model($options['model'])->findByPk($options['id']);
        //may be you will be need set some attributes before update
        if (isset($options['attributes']))
        {
            $model->attributes = $options['attributes'];
        }

        $attribute         = $options['attribute'];
        $model->$attribute = $options['value'];

        if ($model->saveAttributes(array($attribute)))  //not save! we needn't call onBeforSave and other callbacks
        {
            if (isset($options['unlink_file']))         //if it was file, delete all semilar files
            {
                $file = Yii::getPathOfAlias('webroot').'/'.$options['unlink_file'];
                if (is_file($file) && FileSystemHelper::isAllowForUnlink($file))
                {
                    FileSystemHelper::deleteFileWithSimilarNames(pathinfo($file, PATHINFO_DIRNAME), pathinfo($file, PATHINFO_BASENAME));
                }
            }
            echo $model->$attribute;
        }
        else
        {
            echo $model->getError($attribute);
        }
    }
}