<?php
/**
 * @property id
 * @property title
 *
 * @property products
 */
class Documentation extends ActiveRecordModel
{
    const PAGE_SIZE = 10;

    const LFT   = 'lft';
    const RGT   = 'rgt';
    const DEPTH = 'depth';

    public $parentId;


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'documentation';
    }


    public function name()
    {
        return 'Модель Documentation';
    }


    public function rules()
    {
        return array(
            array(
                'title', 'length',
                'max' => 250
            ), array(
                'title', 'required'
            ), array(
                'is_published, content', 'safe'
            ), array(
                'title, alias', 'unique'
            ), array(
                'alias', 'AliasValidator'
            ), array(
                'title', 'safe',
                'on' => 'search'
            ),
        );
    }


    public function relations()
    {
        return array(
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('title', $this->title, true);
        $criteria->order = 'lft ASC';
        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria
        ));
    }


    public function behaviors()
    {
        return CMap::mergeArray(parent::behaviors(), array(
            'tree'       => array(
                'class'         => 'application.components.activeRecordBehaviors.NestedSetBehavior',
                'leftAttribute' => self::LFT,
                'rightAttribute'=> self::RGT,
                'levelAttribute'=> self::DEPTH,
            ),
            'withRelated'=> array(
                'class'=> 'application.components.activeRecordBehaviors.WithRelatedBehavior',
            ),
        ));
    }


    public function scopes()
    {
        return array(
            'orderByLft'   => array('order'=> self::LFT),
            'orderByRgt'   => array('order'=> self::RGT),
            'orderByDepth' => array('order'=> self::DEPTH),
            'isSystem'     => array('condition'=> 'is_system=1'),
        );
    }


    /*
    * Выводит дерево в виде вложенных списков, без рекурсии
    */
    public static function getHtmlTree()
    {
        $models = self::getRoot()->descendants()->findAll();

        $depth = 0;
        $res   = '';

        foreach ($models as $n=> $item)
        {
            if ($item->depth == $depth)
            {
                $res .= CHtml::closeTag('li') . "\n";
            }
            else if ($item->depth > $depth)
            {
                $res .= CHtml::openTag('ul', array('class' => 'depth_' . $item->depth)) . "\n";
            }
            else
            {
                $res .= CHtml::closeTag('li') . "\n";

                for ($i = $depth - $item->depth; $i; $i--)
                {
                    $res .= CHtml::closeTag('ul') . "\n";
                    $res .= CHtml::closeTag('li') . "\n";
                }
            }

            $res .= CHtml::openTag('li', array(
                'id'   => 'items_' . $item->id,
                'class'=> 'depth_' . $item->depth
            ));
            $res .= CHtml::tag('div', array(), CHtml::encode($item->title) .
                '<img class="drag" src="/img/admin/hand.png" height="16" width="16" />');
            $depth = $item->depth;
        }

        for ($i = $depth; $i; $i--)
        {
            $res .= CHtml::closeTag('li') . "\n";
            $res .= CHtml::closeTag('ul') . "\n";
        }

        return $res;
    }


    public static function getRoot()
    {
        return self::model()->roots()->find();
    }


    /**** URL's and LINK's *****/
    public function getHref()
    {
        return Yii::app()->controller->createUrl('/docs/documentation/index', array('alias'=> $this->alias));
    }


    public function getAddChildUrl()
    {
        return Yii::app()->controller->createUrl('/products/categoryAdmin/create', array('parent_id'=> $this->id));
    }


    public function getManageUrl()
    {
        return Yii::app()->controller->createUrl('/products/categoryAdmin/manage');
    }


    /****** data processors ******/

    public function getNbspTitle()
    {
        return str_repeat("&nbsp;", ($this->depth - 1) * 3) . $this->title;
    }


    public function getSpaceTitle()
    {
        return str_repeat(' ', ($this->depth - 1) * 3) . $this->title;
    }


    public static function listData($key = 'id', $val = 'nbspTitle')
    {
        return CHtml::listData(self::model()->root->descendants()->findAll(), $key, $val);
    }


    /***** Events *****/
    public function beforeDelete()
    {
        if (parent::beforeDelete())
        {
            $this->withRelated->clear(array(
                'docs' => array(),
            ));

        }
        return false;
    }
}