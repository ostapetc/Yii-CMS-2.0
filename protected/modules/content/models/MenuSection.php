<?
/** 
 * 
 * !Attributes - атрибуты БД
 * @property string      $lang
 * @property integer     $is_published
 * @property string      $id
 * @property string      $page_id
 * @property string      $menu_id
 * @property string      $root
 * @property string      $left
 * @property string      $right
 * @property integer     $level
 * @property string      $title
 * @property string      $url
 * @property string      $module_url
 * @property string      $module_id
 * 
 * !Accessors - Геттеры и сеттеры класа и его поведений
 * @property             $href
 * @property             $path
 * @property             $nbspTitle
 * @property             $spaceTitle
 * @property             $errorsFlatArray
 * @property             $updateUrl
 * @property             $createUrl
 * @property             $deleteUrl
 * 
 * !Relations - связи
 * @property Menu        $menu
 * @property Page        $page
 * 
 * !Scopes - именованные группы условий, возвращают этот АР
 * @method   MenuSection ordered()
 * @method   MenuSection last()
 * 
 */

class MenuSection extends ActiveRecord
{
    const PAGE_SIZE = 100;

    public $max_order;

    public $url_info;

    public static $descendants;


    public function name()
    {
        return 'Ссылки меню';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'menu_sections';
    }


    public function behaviors()
    {
        return CMap::mergeArray(parent::behaviors(), [
            'NestedSet'  => [
                'class'          => 'application.components.activeRecordBehaviors.NestedSetBehavior',
                'leftAttribute'  => 'left',
                'rightAttribute' => 'right',
                'levelAttribute' => 'level',
                'hasManyRoots'   => true
            ]
        ]);
    }


    public function rules()
    {
        return [
            ['menu_id, title', 'required'], [
                'is_published', 'numerical'
            ],
            [
                'page_id, menu_id', 'length',
                'max' => 11
            ],
            [
                'title', 'length',
                'max' => 200
            ],
            [
                'url_info, module_url', 'length',
                'max' => 300
            ],
            [
                'module_id', 'length',
                'max' => 64
            ],
            [
                'url', 'length',
                'max' => 200
            ],
            [
                'title, url', 'filter',
                'filter' => 'trim'
            ],
            [
                'id, page_id, menu_id, title, url, is_published', 'safe',
                'on' => 'search'
            ],
        ];
    }


    public function relations()
    {
        return [
            'menu' => [self::BELONGS_TO, 'Menu', 'menu_id'],
            'page' => [self::BELONGS_TO, 'Page', 'page_id'],
        ];
    }


    public function search($root)
    {
        $alias = $this->getTableAlias();

        $criteria = new CDbCriteria;
        $criteria->compare($alias . '.page_id', $this->page_id, true);
        $criteria->compare($alias . '.title', $this->title, true);
        $criteria->compare($alias . '.url', $this->url, true);
        $criteria->compare($alias . '.is_published', $this->is_published);
        $criteria->addCondition($alias . '.root = ' . $root);
        $criteria->addCondition($alias . '.id <> ' . $root);
        $criteria->order = "{$alias}.left";
        $criteria->with  = ['page', 'menu'];

        return new ActiveDataProvider(get_class($this), [
            'criteria' => $criteria
        ]);
    }

    public function noEmpty()
    {
        $cr = new CDbCriteria();
        $cr->addCondition('page_id!=""');
        $cr->addCondition('page_id!=null');
        $cr->addCondition('module_url!=null');
        $cr->addCondition('module_url!=""');
        $cr->addCondition('url!=""');
        $cr->addCondition('url!=null');
        $this->getDbCriteria()->mergeWith($cr);
        return $this;
    }

    public function toModuleOrPage()
    {
        return $this->page_id || $this->module_id;
    }

    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            if ($this->url != '/')
            {
                $this->url = trim($this->url, '/');
            }

            return true;
        }
    }



    public function getHref()
    {
        if ($this->page)
        {
            $url = $this->page->href;
        }
        else if ($this->module_url)
        {
            $url = Yii::app()->controller->createUrl($this->module_url, ['section_id'=>$this->id]);
        }
        else
        {
            $url = $this->url;
        }

        if (!empty($url) && mb_substr($url, 0, 1, 'utf-8') != '/')
        {
            $url = '/' . $url;
        }

        if (count(Language::getList()) > 1)
        {
            $url = '/' . Yii::app()->language . $url;
        }
        //echo $url . "<br/>";
        return $url;
    }


    public function optionsTree($name = 'name', $id = null, $result = [], $value = 'id', $spaces = 0, $parent_id = null)
    {
        //        $objects = $this->findAllByAttributes([
        //            'menu_id'   => $menu_id
        //        ]);
        //
        //        foreach ($objects as $object)
        //        {
        //            if ($object->id == $id) continue;
        //
        //
        //            $result[$object->id] = str_repeat("_", $spaces) . $object->title;
        //
        //            if ($object->childs)
        //            {
        //                $spaces+=2;
        //
        //                $result = $this->optionsTree($id, $menu_id, $result, $spaces, $object->id);
        //            }
        //        }
        //
        //        return $result;
    }


    public function isActive()
    {
        $is_active = $_SERVER['REQUEST_URI'] == $this->href;
        if (!$is_active)
        {
            if (!isset(self::$descendants[$this->id]))
            {
                self::$descendants[$this->id] = $this->descendants()->findAll();
            }

            foreach (self::$descendants[$this->id] as $item)
            {
                if ($_SERVER['REQUEST_URI'] == $item->href)
                {
                    $is_active = true;
                    break;
                }
            }
        }
        return $is_active;
    }


    public function getPath($path = [], $link = null)
    {
        if (!$link)
        {
            $link = $this;
        }

        $path[$link->title] = $link->href;

        $parent = $link->parent;

        if ($parent)
        {
            $path = $this->getPath($path, $parent);
        }
        else
        {
            return array_reverse($path);
        }

        return $path;
    }


    public function getNbspTitle()
    {
        return str_repeat("&nbsp;", ($this->level - 2) * 5) . $this->title;
    }


    public function getSpaceTitle()
    {
        return str_repeat(' ', ($this->level - 1) * 4) . $this->title;
    }


    public static function listData($key = 'id', $val = 'nbspTitle')
    {
        return CHtml::listData(self::model()->root->descendants()->findAll(), $key, $val);
    }


    public function attributeLabels()
    {
        return CMap::mergeArray(parent::attributeLabels(), [
            'roles' => 'Группы пользователей',
            'url_info' => 'Куда будет вести этот пункт меню',
        ]);
    }


    public function checkAccess()
    {
        $action = Yii::app()->controller instanceof AdminController ? 'Admin' : 'View';

        if (!$this->page_id && !Yii::app()->user->checkAccess($this, $action))
        {
            return false;
        }


        if ($this->page_id != null)
        {
            return RbacModule::isObjectAllow('Page', $this->page_id, $action);
        }
        elseif ($this->module_url)
        {
            return true;
        }
        else
        {
            if (!isset(self::$descendants[$this->id]))
            {
                self::$descendants[$this->id] = $this->descendants()->findAll();
            }

            foreach (self::$descendants[$this->id] as $item)
            {
                if ($item->checkAccess())
                {
                    return true;
                }
            }
            return false;
        }
    }


    public static function getHtmlTree($root_id)
    {
        $models = self::model()->findByPk($root_id)->descendants()->findAll();

        $level = 0;
        $res   = '';

        foreach ($models as $n=> $item)
        {
            if ($item->level == $level)
            {
                $res .= CHtml::closeTag('li') . "\n";
            }
            else if ($item->level > $level)
            {
                $res .= CHtml::openTag('ul', ['class' => 'depth_' . $item->level]) . "\n";
            }
            else
            {
                $res .= CHtml::closeTag('li') . "\n";

                for ($i = $level - $item->level; $i; $i--)
                {
                    $res .= CHtml::closeTag('ul') . "\n";
                    $res .= CHtml::closeTag('li') . "\n";
                }
            }

            $res .= CHtml::openTag('li', [
                'id'   => 'items_' . $item->id,
                'class'=> 'depth_' . $item->level
            ]);
            $res .= CHtml::tag('div', [], CHtml::encode($item->title) . '<a class="drag icon-sortable"></a>');
            $level = $item->level;
        }

        for ($i = $level; $i; $i--)
        {
            $res .= CHtml::closeTag('li') . "\n";
            $res .= CHtml::closeTag('ul') . "\n";
        }

        return $res;
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->url_info = $this->page_id ? 'page:'.$this->page_id : 'module:'.$this->module_id.':'.$this->module_url;
    }


}
