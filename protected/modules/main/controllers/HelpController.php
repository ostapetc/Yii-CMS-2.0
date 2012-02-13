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
            'Captcha'    => 'Капча',
            'Sitemap'    => 'Карта сайта',
            'Sitemapxml' => 'XML карта сайта'
        );
    }


    public function actions()
    {
        return array(
            'captcha'   => array(
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
            'sitemap'   => array(
                'class'           => 'ext.sitemap.ESitemapAction',
                'importListMethod'=> 'getBaseSitePageList',
                'classConfig'     => array(
                    array(
                        'baseModel' => 'News',
                        'title'     => 'title',
                        'route'     => '/news/news/view',
                        'params'    => array('id'=> 'id'),
                        'scopeName' => 'sitemap'
                    ),
                ),
            ),
            'sitemapxml'=> array(
                'class'           => 'ext.sitemap.ESitemapXMLAction',
                'classConfig'     => array(
                    array(
                        'baseModel' => 'News',
                        'route'     => '/news/news/view',
                        'params'    => array('id'=> 'id'),
                        'scopeName' => 'sitemap'
                    ),
                ),
                //'bypassLogs'=>true, // if using yii debug toolbar enable this line
                'importListMethod'=> 'getBaseSitePageList',
            ),
        );
    }


    /**
     * Provide the static site pages which are not database generated
     *
     * Each array element represents a page and should be an array of
     * 'loc', 'frequency' and 'priority' keys
     *
     * @return array[]
     */
    public function getBaseSitePageList()
    {
                return array(
//                    array(
//                        'loc'      => Yii::app()->createAbsoluteUrl('/'),
//                        'title'      => 'Главная страница',
//                        'frequency'=> 'weekly',
//                        'priority' => '1',
//                    ),
                );
    }
}