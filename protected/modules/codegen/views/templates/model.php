<? echo "<?\n"; ?>

class <?= $class ?> extends ActiveRecord
{
    const PAGE_SIZE = 20;

    public function name()
    {
        return '<?= $name ?>';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return '<?= $table ?>';
    }


    public function behaviors()
    {
        $behaviors = parent::behaviors();

        <? if ($sortable): ?>
        $behaviors['Sortable'] = array(
            'class' => 'application.extensions.sortable.SortableBehavior'
        );
        <? endif ?>

        <? if ($meta_tags): ?>
        $behaviors['MetaTag'] = array(
            'class' => 'application.components.activeRecordBehaviors.MetaTagBehavior'
        );
        <? endif ?>

        return $behaviors;
    }


    public function rules()
    {
        return array(
            array('title, language', 'required'),
            array(
                'id, title, url, text, is_published, date_create', 'safe',
                'on'=> 'search'
            ),
        );
    }


    public function relations()
    {
        return array(
            'language_model' => array(self::BELONGS_TO, 'Language', 'language'),
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);


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
