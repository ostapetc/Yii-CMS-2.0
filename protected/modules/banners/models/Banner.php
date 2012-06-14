<?php

class Banner extends ActiveRecordModel
{
    const SIZE_WIDTH = 150;

    const IMAGES_DIR = 'upload/banners';

    const PAGE_SIZE = 10;

    const SCENARIO_BIG_BANNER = 'big_banner';

    public $date_active;

    public $src;


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'banners';
    }


    public function name()
    {
        return 'Баннеры';
    }


    public function rules()
    {
        return array(
            array('name', 'required'), array(
                'is_active, page_id', 'numerical',
                'integerOnly' => true
            ), array(
                'name', 'length',
                'max' => 50
            ), array(
                'image', 'file',
                'types'      => 'jpg, jpeg, png, gif',
                'allowEmpty' => true
            ), array('date_start', 'validateDateInterInterVal'), array(
                'url', 'length',
                'max' => 500
            ), array('date_start, date_end, date_active', 'safe'), array('roles', 'safe'), array(
                'id, name, image, url, is_active, date_start, date_end', 'safe',
                'on' => 'search'
            ),
        );
    }


    public function checkSize($attr)
    {
        $width  = 1000;
        $height = 240;

        if (isset($_FILES['Banner']) && !$_FILES['Banner']['error']['image'])
        {
            $size = getimagesize($_FILES['Banner']['tmp_name']['image']);
            if ($size[0] != $width || $size[1] != $height)
            {
                $this->addError($attr, "Размер загружаемого баннера должен быть {$width} x {$height} px!");
            }
        }
    }


    public function validateDateInterInterVal($attr)
    {
        if ($this->date_active)
        {
            if (!$this->$attr || !$this->date_end)
            {
                $this->addError($attr, 'Укажите и дату начала и дату окончания показа!');
                return;
            }

            if ($this->$attr && $this->date_end)
            { //v($this->$attr);
                //v($this->date_end);
                //die;
                $date_start = strtotime($this->$attr);
                $date_end   = strtotime($this->date_end);

                if ($date_start > $date_end)
                {
                    $this->addError($attr, 'Дата окончания показа не должна быть раньше даты начала показа!');
                }
            }
        }
    }


    public function relations()
    {
        return array(
            'page'  => array(self::BELONGS_TO, 'Page', 'page_id')
        );
    }


    public function behaviors()
    {
        $behaviors = array_merge(parent::behaviors(), array(
            'sortable'       => array(
                'class' => 'ext.sortable.SortableBehavior'
            ),
            'AuthObject'     => array(
                'class' => 'application.components.activeRecordBehaviors.AuthObjectBehavior'
            )
        ));

        return $behaviors;
    }


    public function search($is_big)
    {
        $criteria = $this->model()->authObject('Edit')->getDbCriteria();
        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('is_active', $this->is_active);
        $criteria->compare('date_start', $this->date_start, true);
        $criteria->compare('date_end', $this->date_end, true);
        $criteria->order = '`order` DESC';
        $criteria->addCondition('is_big = ' . $is_big);

        return new ActiveDataProvider(get_class($this), array(
            'criteria' => $criteria
        ));
    }


    public function uploadFiles()
    {
        return array(
            'image' => array('dir' => self::IMAGES_DIR)
        );
    }


    public function render($return = false)
    {
        //        $thumb = ImageHelper::thumb(self::IMAGES_DIR, $this->image, self::SIZE_WIDTH, null, false,
        //            'alt = "' . $this->name . '"');
        $thumb =
            "<img src='/" . self::IMAGES_DIR . "/" . $this->image . "' width='" . self::SIZE_WIDTH . "' />";

        if ($return)
        {
            return $thumb;
        }
        else
        {
            echo $thumb;
        }
    }


    public function attributeLabels()
    {
        $labels                = parent::attributeLabels();
        $labels['roles']       = 'Отображается для групп пользователей';
        $labels['date_active'] = 'Активировать по заданной дате';
        return $labels;
    }


    public function getHref()
    {
        if ($this->page)
        {
            return $this->page->href;
        }
        else
        {
            return $this->url;
        }
    }


    public function beforeSave()
    {
        return parent::beforeSave();
    }


    public static function filter($banners)
    {
        foreach ($banners as $i => $banner)
        {
            if ($banner->date_start && (strtotime($banner->date_start) > time()))
            {
                unset($banners[$i]);
            }

            if ($banner->date_end && (strtotime($banner->date_end) <= time()))
            {
                unset($banners[$i]);
            }

            if (!$banner->image ||
                !file_exists($_SERVER['DOCUMENT_ROOT'] . Banner::IMAGES_DIR . '/' . $banner->image)
            )
            {
                unset($banners[$i]);
            }
        }

        return $banners;
    }


    public function notifyByEmail()
    {
        $banner = $this->findByPk($this->id);

        if ($this->date_start == date('Y-m-d'))
        {

            $title = "Опубликован баннер `{$this->name}` на сайте partnersnet.schneider-electric.ru";

            $body = "На сайте partnersnet.schneider-electric.ru";

            if ($this->href)
            {
                $body .= " в разделе <a href='{$this->href}'>{$this->href}</a>";
            }

            $body .= " был опубликован баннер.<br /><br />";

            $body .= "______________________<br/><br />";
            $body .= "Данное письмо было сгенерировано службой автоматической рассылки. Просим Вас не отвечать на него. Если у Вас возник вопрос по работе с сайтом, просим Вас обращаться по адресу: [e-mail адрес службы поддержки сайта]";


            echo $body;
            die;
        }
        else if ($this->date_end == date('Y-m-d') || ($banner->is_active == 1 && $this->is_active == 0))
        {

        }
    }
}