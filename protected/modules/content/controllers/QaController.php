<?php

/**
 * Created by JetBrains PhpStorm.
 * User: artem.ostapetc
 * Date: 26.09.12
 * Time: 15:57
 * To change this template use File | Settings | File Templates.
 */

class QAController extends ClientController
{
    public static function actionsTitles()
    {
        return [
            'index'  => t('Главная страница Q&A'),
            'create' => t('Новый вопрос')
        ];
    }


    public function subMenuItems()
    {
        return [
            [
                'label' => t('Последние'),
                'url'   => ['index'],
            ],
            [
                'label' => t('Сейчас обсуждают'),
                'url'   => '/',
            ],
            [
                'label' => t('Задать вопрос'),
                'url'   => ['/content/qa/create']
            ],
        ];
    }


    public function sidebars()
    {
        return [
            [
                'actions'  => ['index'],
                'sidebars' => [
                    ['type' => 'widget', 'class' => 'tags.portlets.TagsSidebar']
                ]
            ],
            [
                'actions'  => ['create', 'update'],
                'sidebars' => [
                    [
                        'type'  => 'widget',
                        'class' => 'tags.portlets.TagCreateSidebar',
                    ]
                ]
            ],
        ];
    }


    public function actionIndex()
    {
        $this->page_title = '';

        $this->render('index', [

        ]);
    }


    public function actionCreate()
    {
        $model = new Page(Page::SCENARIO_CREATE);
        $model->type = Page::TYPE_QA;

        $form  = new Form('content.PageCForm', $model);

        if ($form->submitted() && $model->validate())
        {
            $model->save();
            $this->redirect(['index']);
        }

        $this->render('create', ['form' => $form]);
    }
}
