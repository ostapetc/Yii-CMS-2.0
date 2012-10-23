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


    public function topMenuItems()
    {
        return array(
            array(
                'label' => t('Посты'),
                'url'   => array('content/page/index')
            ),
            array(
                'label' => t('Форум'),
                'url'   => array('/content/forum/index')
            ),
            array(
                'label' => t('Видео'),
                'url'   => array('/media/mediaVideo/manage')
            ),
            array(
                'label' => t('Фото'),
                'url'   => array('/media/mediaAlbum/manage')
            ),
            array(
                'label' => t('Бойцы'),
                'url'   => array('/mma/fighter/index')
            ),
            array(
                'label' => t('Люди'),
                'url'   => array('/users/user/index')
            ),
        );
    }


    public function subMenuItems()
    {
        return array();
    }



    public function filterLoginIfGuest($chain)
    {
        if (Yii::app()->user->isGuest)
        {
            $this->redirect(array('/users/user/login'));
        }
        else
        {
            $chain->run();
        }
    }
}
