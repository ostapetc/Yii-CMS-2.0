<?
/** 
 * Created by JetBrains PhpStorm.
 * 
 * User: artem.ostapetc
 * Date: 03.09.12
 * Time: 14:24
 * To change this template use File | Settings | File Templates.
 * 
 * 
 * 
 */

class Menu extends ActiveRecord
{
    const PAGE_SIZE = 10;


    public function name()
    {
        return 'Меню';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'menu';
    }

    
    public function rules()
    {
        return array(
            array('name', 'required'),
            array(
                'is_published',
                'numerical',
                'integerOnly' => true
            ),
            array(
                'language',
                'length',
                'max' => 2
            ),
            array(
                'id',
                'length',
                'max' => 11
            ),
            array(
                'name, code',
                'length',
                'max' => 50
            ),
            array(
                'code',
                'match',
                'pattern' => '|^[A-Z_]+$|',
                'message' => 'заглавными, латиница и знак подчеркивания "_"'
            ),
            array(
                'id, name, is_published',
                'safe',
                'on' => 'search'
            ),
        );
    }


    public function relations()
    {
        return array(
            'links' => array(
                self::HAS_MANY, 'MenuSection', 'menu_id',
                'condition' => "lang = '" . Yii::app()->language . "'"
            ),
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('is_published', $this->is_published);

        return new ActiveDataProvider(get_class($this), array(
            'criteria' => $criteria
        ));
    }


    public function getSections()
    {
        $root = MenuSection::model()->roots()->find('menu_id = ' . $this->id);
        if (!$root)
        {
            return;
        }

        $children = $root->children();
        if (!$children)
        {
            return;
        }

        $sections = $children->findAll();

        foreach ($sections as $i => $section)
        {
            if (!$section->is_published || ($section->page && !$section->page->is_published))
            {
                unset($sections[$i]);
            }
        }

        return $sections;
    }


    public function getCurrentSection()
    {
        if (!$this->sections)
        {
            return;
        }

        foreach ($this->sections as $section)
        {
            if ($section->isActive())
            {
                return $section;
            }

            $childs = $section->children()->findAll();
            if ($childs)
            {
                foreach ($childs as $child)
                {
                    if ($child->isActive())
                    {
                        return $child;
                    }
                }
            }
        }
    }

    public function getPagePath($page_id)
    {
        $section = MenuSection::model()->findByAttributes(array(
            'page_id' => $page_id,
            'menu_id' => $this->id
        ));

        return $section->getPath();
    }
}
