<?
class JsonController extends Controller
{
    public static function actionsTitles()
    {
        return array(
            'go'    => 'Просмотр страницы',
            'index' => 'Просмотр страницы',
            'name'  => 'Просмотр страницы',
            'model' => 'Главная страница'
        );
    }

    public function actionGo()
    {
        $methods = get_class_methods(__CLASS__);
        $methods = array_combine($methods, $methods);
        unset($methods[__FUNCTION__]);
        foreach (get_class_methods('Controller') as $method)
        {
            unset($methods[$method]);
        }
        $methods = CJavaScript::encode($methods);
        Yii::app()->getClientScript()->registerScriptFile('/js/plugins/jsonRpc.js')
        ->registerScript('tmp','ServerApi("tmp", "{$methods})")');

        $page = Page::model()->findByAttributes(array('url'=>'/'));
        $this->render('/page/main', array('page' => $page));
    }
    public function actionIndex()
    {
        $a = file_get_contents('php://input');
        echo Y::end(CJSON::decode($a));
    }

    public function getName()
    {

    }
}
