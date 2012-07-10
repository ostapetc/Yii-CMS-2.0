<?
 
abstract class AdminController extends Controller
{
    public $layout='//layouts/admin/main';

    public $footer;

    public $crumbs = array();

    public $tabs;

    public function filters()
    {
        return CMap::mergeArray(parent::filters(),array(
            'postOnly + delete'
        ));
    }

    public function beforeAction($action)
    {
        if (Yii::app()->user->isGuest && ($action->id != 'login'))
        {
            $this->redirect(array('/users/userAdmin/login', 'redirect' => base64_encode($_SERVER['REQUEST_URI'])));
        }

        return parent::beforeAction($action);
    }
}
