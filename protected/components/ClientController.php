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
        $sports = Sport::model()->findAll();
        foreach ($sports as $i => $sport)
        {
            $sports[$i] = array(
                'label' => $sport->name,
                'url'   => '/' . $sport->caption,
            );
        }

        return array(
            array(
                'label' => t('Раздел спорта'),
                'items' => $sports
            ),
            array(
                'label' => t('Топики'),
                'url'   => array('content/page/index')
            ),
            array(
                'label' => t('Блоги'),
                'url'   => array('content/pageSection/index')
            ),
            array(
                'label' => t('Видео'),
                'url'   => '/'
            ),
            array(
                'label' => t('Фото'),
                'url'   => '/'
            ),
            array(
                'label' => t('Люди'),
                'url'   => '/'
            ),
        );
    }


    public function subMenuItems()
    {
        return array();
    }


}
