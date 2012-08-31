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

		$this->setImport(array(
			'content.models.*',
			'content.portlets.*',
		));
	}


    public function adminMenu()
    {
        return array(
            'Список страниц'    => Yii::app()->createUrl('/content/pageAdmin/manage'),
            'Добавить страницу' => Yii::app()->createUrl('/content/pageAdmin/create'),
            'Разделы страниц'   => Yii::app()->createUrl('/content/pageSectionAdmin/manage'),
            'Добавить раздел'   => Yii::app()->createUrl('/content/pageSectionAdmin/create'),
            'Управление меню'   => Yii::app()->createUrl('/content/menuAdmin/manage'),
            'Добавить меню'     => Yii::app()->createUrl('/content/menuAdmin/create'),
        );
    }


    public function routes()
    {
        $routes = array(
            '/'                          => 'content/page/index',
            '/page/<id:\d+>'             => 'content/page/view',
            '/page/create'               => 'content/page/create',
            '/page/update/<id:\d+>'      => 'content/page/update',
            '/page/user/<user_id:\d+>/*' => 'content/page/userPages',
            '/page/tag/<tag_name:[a-zA-Zа-яА-Я ]+>' => 'content/page/tagPages',
            '/page/section/<section_id:\d+>/*'   => 'content/page/sectionPages'
        );

        return $routes;
    }

    public function install()
    {
        parent::install();
        $upload_dir = Yii::getPathOfAlias('webroot.upload.pages');
        is_dir($upload_dir) or @mkdir($upload_dir, 755);
    }
}
