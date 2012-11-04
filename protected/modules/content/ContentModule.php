<?
class ContentModule extends WebModule
{

    public $icon = 'file';

    public function getName()
    {
        return 'Контент';
    }


    public function getDescription()
    {
        return 'Свободно редактируемые страницы, контентные блоки, меню сайта';
    }


    public function getVersion()
    {
        return '1.0';
    }


	public function init()
	{

		$this->setImport([
			'content.models.*',
		]);
	}


    public function adminMenu()
    {
        return [
            'Список страниц'    => Yii::app()->createUrl('/content/pageAdmin/manage'),
            'Добавить страницу' => Yii::app()->createUrl('/content/pageAdmin/create'),
            'Разделы страниц'   => Yii::app()->createUrl('/content/pageSectionAdmin/manage'),
            'Добавить раздел'   => Yii::app()->createUrl('/content/pageSectionAdmin/create'),
            'Управление меню'   => Yii::app()->createUrl('/content/menuAdmin/manage'),
            'Добавить меню'     => Yii::app()->createUrl('/content/menuAdmin/create'),
        ];
    }


    public function routes()
    {
        $routes = [
            '/'                                     => '/content/page/index',
            '/page/<id:\d+>'                        => '/content/page/view',
            '/page/create'                          => '/content/page/create',
            '/page/update/<id:\d+>'                 => '/content/page/update',
            '/page/user/<user_id:\d+>/*'            => '/content/page/userPages',
            '/page/tag/<tag_name:[a-zA-Zа-яА-Я ]+>' => '/content/page/tagPages',
            '/page/section/<section_id:\d+>/*'      => '/content/page/sectionPages',
            '/forum'                                => '/content/forum/index',
            '/forum/section/<section_id:\d+>/*'     => '/content/forum/sectionTopics',
            '/forum/topic/<topic_id:\d+>/*'         => '/content/forum/viewTopic',
        ];

        return $routes;
    }

    public function install()
    {
        parent::install();
        $upload_dir = Yii::getPathOfAlias('webroot.upload.pages');
        is_dir($upload_dir) or @mkdir($upload_dir, 755);
    }

    public function getSearchInfo()
    {
        return [
            'pages' =>
                '
                SELECT
                    pages.id, pages.title, pages.text,
                    GROUP_CONCAT(DISTINCT tags.name SEPARATOR "|") as tag_names,
                    GROUP_CONCAT(DISTINCT pages_sections.name SEPARATOR "|") as sections_names

                    FROM  ' . Page::model()->tableName() . '
                    LEFT JOIN tags_rels ON tags_rels.model_id="Page" AND tags_rels.object_id=pages.id
                    LEFT JOIN tags ON tags_rels.tag_id=tags.id
                    LEFT JOIN pages_sections_rels ON pages_sections_rels.page_id=pages.id
                    LEFT JOIN pages_sections ON pages_sections_rels.section_id=pages_sections.id
                    GROUP BY pages.id
                '
        ];
    }
}
