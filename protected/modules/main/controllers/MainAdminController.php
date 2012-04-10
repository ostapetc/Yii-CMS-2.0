<?

class MainAdminController extends AdminController
{   
    public static function actionsTitles() 
    {
        return array(
            'Index'          => 'Просмотр главной страницы',
            'Modules'        => 'Просмотр списка модулей',
            'SessionPerPage' => 'Установки кол-ва элементов на странице',
        );
    }    
    

    public function actionIndex()
    {
        $this->render('index', array(
            'modules' => AppManager::getModulesData(true, true)
        ));
    }
    
    
    public function actionModules()
    {
        $this->render('modules', array(
            'modules'        => AppManager::getModulesData(),
            'active_modules' => AppManager::getActiveModulesArray()
        ));
    }
    

    public function actionSessionPerPage($model, $per_page, $back_url)
    {
        Yii::app()->session["{$model}PerPage"] = $per_page;
        $this->redirect(base64_decode($back_url));
    }
}


        

