<?php

class Banner extends ActiveRecordModel
{
    public static $sidebar_size = array(
        'width' => 250,
        'height'=> null
    );

    const IMAGES_DIR = 'upload/banners';

    const PAGE_SIZE = 10;

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
                'is_published, page_id', 'numerical',
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
                'id, name, image, url, is_published, date_start, date_end', 'safe',
                'on' => 'search'
            ),
        );
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
            {
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
            'banners_roles' => array(self::HAS_MANY, 'BannerRole', 'banner_id'),
            'roles'         => array(
                self::HAS_MANY, 'AuthItem', 'role',
                'through' => 'banners_roles'
            ),
            'page'          => array(self::BELONGS_TO, 'Page', 'page_id')
        );
    }


    public function behaviors()
    {
        return array_merge(parent::behaviors(), array(
            'sortable'       => array(
                'class'=> 'ext.sortable.SortableBehavior'
            ),
            'MaxMinBehavior' => array(
                'class' => 'application.components.activeRecordBehaviors.MaxMinBehavior'
            )
        ));
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('is_published', $this->is_published);
        $criteria->compare('date_start', $this->date_start, true);
        $criteria->compare('date_end', $this->date_end, true);

        return new ActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'sort'     => array('defaultOrder'=> 'order')
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
        $thumb = ImageHelper::thumb(self::IMAGES_DIR, $this->image, self::$sidebar_size)->htmlOptions(array(
            'alt'         => '',
            'title'       => $this->name,
            'data-content'=> $this->content
        ))->encode();
        if ($return)
        {
            return $thumb;
        }
        else
        {
            echo $thumb;
        }
    }


    public function afterSave()
    {
        if (in_array($this->scenario, array(self::SCENARIO_CREATE, self::SCENARIO_UPDATE)))
        {
            BannerRole::model()->deleteAll('banner_id = ' . $this->id);

            if ($this->roles)
            {
                foreach ($this->roles as $role)
                {
                    $banner_role            = new BannerRole;
                    $banner_role->banner_id = $this->id;
                    $banner_role->role      = $role;
                    $banner_role->save();
                }
            }
        }

        parent::afterSave();
    }


    public function attributeLabels()
    {
        $labels          = parent::attributeLabels();
        $labels['roles'] = 'Отображается для ролей';
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

}