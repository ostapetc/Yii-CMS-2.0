<?

abstract class ClientController extends Controller
{
    public $layout = '//layouts/main';


    public function actions()
    {
        return array(
            'captcha' => array(
                'class'     => 'CCaptchaAction',
                'testLimit' => 6,
                'minLength' => 4,
                'maxLength' => 5,
                'offset'    => 1,
                'width'     => 68,
                'height'    => 30,
                'backColor' => 0xBBBBBB,
                'foreColor' => 0x222222
            )
        );
    }


//    public function topMenuItems()
//    {
//
//    }


    public function subMenuItems()
    {
        return array();
    }



    public function filterLoginIfGuest($chain)
    {
        if (Yii::app()->user->isGuest)
        {
            $this->redirect(array('/users/session/create'));
        }
        else
        {
            $chain->run();
        }
    }
}
