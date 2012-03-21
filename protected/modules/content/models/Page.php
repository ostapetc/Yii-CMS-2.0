<?php

class Page extends ActiveRecordModel
{
    const PAGE_SIZE = 20;


    public static $widgets = array(
        'FeedbackPortlet' => 'Форма обратной связи',
        'OrderPortlet'    => 'Форма заказа'
    );


    public function name()
    {
        return t('Страницы');
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'pages';
    }


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['MetaTag'] = array(
            'class' => 'application.components.activeRecordBehaviors.MetaTagBehavior'
        );
        $behaviors['Sortable'] = array(
            'class' => 'application.extensions.sortable.SortableBehavior'
        );

        return $behaviors;
    }


    public function rules()
    {
        return array(
            array('title, language', 'required'),
            array(
                'is_published, on_main, left_menu_id',
                'numerical',
                'integerOnly' => true
            ),
            array(
                'url', 'length',
                'max' => 250
            ),
            array(
                'title', 'length',
                'max'=> 200
            ),
            array('text, short_text', 'safe'),
            array('meta_tags, god', 'safe'),
            array(
                'title, url', 'filter',
                'filter' => 'strip_tags'
            ),
            array(
                'id, title, url, text, is_published, date_create', 'safe',
                'on'=> 'search'
            ),
            array('widget', 'in', 'range' => array_keys(self::$widgets))
        );
    }


    public function relations()
    {
        return array(
            'language_model' => array(self::BELONGS_TO, 'Language', 'language'),
            'left_menu'      => array(self::BELONGS_TO, 'Menu', 'left_menu_id')
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('is_published', $this->is_published);
        $criteria->compare('date_create', $this->date_create, true);

        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' =>array(
                'pageSize' => self::PAGE_SIZE
            )
        ));
    }


    public function getHref()
    {
        $url = trim($this->url);
        if ($url)
        {
            if ($url[0] != "/") {
                $url = "/page/{$url}";
            }

            return $url;
        }
        else
        {
            return "/page/" . $this->id;
        }
    }


    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            if ($this->url != '/')
            {
                $this->url = trim($this->url, "/");
            }

            return true;
        }
    }


    public function getContent()
    {
        $content = $this->text;

        if (RbacModule::isAllow('PageAdmin_Update'))
        {
            $content .= "<br/>" .CHtml::link(t('Редактировать'), array(
                '/content/pageAdmin/update/',
                'id'=> $this->id
            ), array('class'=> 'btn btn-danger'));
        }

        return $content;
    }
}
