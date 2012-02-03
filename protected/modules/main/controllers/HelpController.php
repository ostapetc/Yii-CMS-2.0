<?php

/*
 * Контроллер для всяких вспомогательных функций,
 * экшены можно добавить в него один раз, вместо того, что бы добавлять их во все контроллеры
 */
class HelpController extends BaseController
{
    public static function actionsTitles()
    {
        return array(
            'Captcha'          => 'Капча'
        );
    }


    public function actions()
    {
        return array(
            'captcha'=> array(
                'class'     => 'CCaptchaAction',
                'testLimit' => 6,
                'minLength' => 4,
                'maxLength' => 5,
                'offset'    => 1,
                'width'     => 68,
                'height'    => 30,
                'backColor' => 0xBBBBBB,
                'foreColor' => 0x222222
            ),
        );
    }
}