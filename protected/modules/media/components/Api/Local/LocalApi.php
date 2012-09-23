<?php
Yii::import('media.components.Api.Abstract.ApiBehaviorAbstract', true);
class LocalApi extends ApiAbstract
{
    const UPLOAD_PATH = 'upload/mediaFiles';

    protected $fileInfo;


    public function findAll($criteria)
    {

    }


    function count($criteria)
    {

    }


    public function attributeNames()
    {
        return array(
            'title',
            'img',
            'size',
            'player_url',
            'view_count',
            'raters',
            'average',
            'id',
            'author_name',
            'author_uri',
        );
    }


    public function getThumb()
    {
        return ImageHelper::thumb($this->getServerDir(), pathinfo($this->model->remote_id, PATHINFO_BASENAME),
            array(
                'width'  => 48,
                'height' => 48
            ), true)->__toString();
    }


    public function getServerDir()
    {
        return $_SERVER['DOCUMENT_ROOT'] . pathinfo($this->model->remote_id, PATHINFO_DIRNAME) . '/';
    }


    public function findByPk($pk)
    {
        $this->beforeFind();
        $file = new SplFileInfo(Yii::getPathOfAlias('webroot') . '/' . self::UPLOAD_PATH . '/' . $pk);
        return $this->populateRecord($file);
    }


    public function save($key = 'file')
    {
        $file     = CUploadedFile::getInstanceByName($key);
        $new_file = self::UPLOAD_PATH . '/' . $file->name;

        if ($file->saveAs(Yii::getPathOfAlias('webroot') . '/' . $new_file))
        {
            $this->model->remote_id = $this->moveToVault($new_file);
            $this->model->title     = $file->name;
            return true;
        }
        else
        {
            $this->error = $file->getError();
            return false;
        }
    }


    public function getHref()
    {
    }


    public function getUrl()
    {

    }


    /**
     * @param $fileInfo SplFileInfo
     */
    protected function _populate($fileInfo)
    {
//        $this->pk = $fileInfo
    }


}