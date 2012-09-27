<?php
/**
 *
 * !Attributes - атрибуты БД
 *
 * @property string    $id
 * @property string    $object_id
 * @property string    $model_id
 * @property string    $name
 * @property string    $tag
 * @property string    $title
 * @property string    $descr
 * @property string    $order
 * @property string    $path
 * @property string    $type
 *
 * !Accessors - Геттеры и сеттеры класа и его поведений
 * @property           $deleteUrl
 * @property           $isImage
 * @property           $isAudio
 * @property           $isExcel
 * @property           $isWord
 * @property           $isVideo
 * @property           $isArchive
 * @property           $isDocument
 * @property           $isFileExist
 * @property           $icon
 * @property           $handler
 * @property string    $size            formatted file size
 * @property           $extension
 * @property           $nameWithoutExt
 * @property           $content
 * @property           $downloadUrl
 * @property           $hash
 * @property           $href
 * @property           $serverDir
 * @property           $serverPath
 * @property           $errorsFlatArray
 * @property           $url
 * @property           $updateUrl
 * @property           $createUrl
 * @property string    $error           the error message. Null is returned if no error.
 *
 * !Scopes - именованные группы условий, возвращают этот АР
 * @method   MediaFile published()
 * @method   MediaFile sitemap()
 * @method   MediaFile ordered()
 * @method   MediaFile last()
 *
 */

Yii::import('media.models.Apis.*');
class MediaFile extends ActiveRecord
{
    public static $configuration;

    public $error;

    private $_api_name;


    public function __construct($scenario = 'insert', $api_name = 'local')
    {
        $this->_api_name = $api_name;
        parent::__construct($scenario);
    }


    public function init()
    {
        $this->setApi($this->_api_name);
    }


    public function name()
    {
        return 'Файловый менеджер';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'media_files';
    }


    public function rules()
    {
        return array( /*            array(
                'nameWithoutExt',
                'length',
                'min'      => 1,
                'max'      => 900,
                'tooShort' => 'Название файла должно быть меньше 1 сим.',
                'tooLong'  => 'Пожалуйста, сократите наименование файла до 900 сим.'
            ) */
        );
    }


    public function parent($model_id, $id)
    {
        $alias = $this->getTableAlias();
        $this->getDbCriteria()->mergeWith(array(
            'condition' => "$alias.model_id='$model_id' AND $alias.object_id='$id'",
            'order'     => "$alias.order DESC"
        ));
        return $this;
    }


    public function tag($tag)
    {
        $alias = $this->getTableAlias();
        $this->getDbCriteria()->mergeWith(array(
            'condition' => "$alias.tag='$tag'"
        ));
        return $this;
    }


    public function getDeleteUrl()
    {
        return Yii::app()->createUrl('/media/mediaFileAdmin/delete', array('id' => $this->id));
    }


    /**
     * @return ApiAbstract
     */
    public function getApi()
    {
        return $this->asa('api')->getApiModel();
    }


    public function setApi($api_name)
    {
        if (!$api_name)
        {
            $api_name = 'local';
        }
        $this->detachBehavior('api');
        if (!self::$configuration)
        {
            self::$configuration = new CConfiguration(
                Yii::getPathOfAlias('media.configs') . '/behaviors.php');
        }

        $this->attachBehavior('api', self::$configuration[$api_name]);

        $this->api_name = $api_name;

        $aliace = $this->getTableAlias();
        $this->dbCriteria->mergeWith(array(
            'condition' => "$aliace.api_name=:api_name",
            'params'    => array(
                'api_name' => $api_name
            )
        ));
        return $this;
    }


    public function getNameWithoutExt()
    {
        $name   = pathinfo($this->remote_id, PATHINFO_FILENAME);
        $params = array(' ' => '');
        if (self::FILE_POSTFIX)
        {
            $params[self::FILE_POSTFIX] = '';
        }
        return strtr($name, $params);
    }


    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            if ($this->isNewRecord)
            {
                $model       = MediaFile::model()->parent($this->model_id, $this->object_id)->tag($this->tag)
                    ->find();
                $this->order = $model ? $model->order + 1 : 1;
                $this->type  = $this->detectType();
            }

            return true;
        }
        return false;
    }


    public function search($crit = null)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('object_id', $this->object_id, true);
        $criteria->compare('model_id', $this->model_id, true);
        $criteria->compare('tag', $this->tag, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('descr', $this->descr, true);
        $criteria->compare('order', $this->order);

        if ($crit)
        {
            $criteria->mergeWith($crit);
        }

        return new ActiveDataProvider(get_class($this), array(
            'criteria' => $criteria
        ));
    }


    public function afterFind()
    {
        $this->setApi($this->api_name);
        parent::afterFind();
    }


    public function getDownloadUrl()
    {
        $hash = $this->getHash();
        return Yii::app()->getController()->createUrl('/media/mediaFile/downloadFile', array(
            'hash' => "{$hash}x{$this->id}",
        ));
    }


    public function getHash()
    {
        return md5($this->object_id . $this->model_id . $this->name . $this->tag);
    }


    public static function getDataProvider($model, $tag, $api = 'local')
    {
        $file = new static;
        return new ActiveDataProvider(get_called_class(), array(
            'criteria' => $file->parent(get_class($model), $model->getPrimaryKey())->tag($tag)->setApi($api)
                ->ordered()->getDbCriteria(),
        ));
    }
}
