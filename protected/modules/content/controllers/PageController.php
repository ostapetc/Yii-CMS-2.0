<?php

class PageController extends BaseController
{
    public static function actionsTitles()
    {
        return array(
            "View"   => "Просмотр страницы",
            "Main"   => "Главная страница",
            "Search" => "Поиск"
        );
    }


    public function actionView()
    {
        $id = $this->request->getParam("id");
        if ($id)
        {
            $page = Page::model()->published()->findByPk($id);
            if (!$page || mb_strlen($page->url, 'utf-8') > 0)
            {
                $this->pageNotFound();
            }
        }
        else
        {
            $url  = $this->request->getParam("url");
            $page = Page::model()->language()->published()->findByAttributes(array("url" => $url));
            if (!$page)
            {
                $this->pageNotFound();
            }
        }

        $top_menu = Menu::model()->language()->find("code = '" . TopMenu::CODE . "'");
        if ($top_menu)
        {
            $menu_setion = MenuSection::model()->findByAttributes(array(
                'menu_id' => $top_menu->id,
                'page_id' => $page->id
            ));
        }

        $this->crumbs = array($page->title);
        $this->_setMetaTags($page);

        $this->render("view", array("page" => $page));
    }


    public function actionMain()
    {
        $page = Page::model()->published()->language()->findByAttributes(array("url" => "/"));
        if ($page)
        {
            $this->_setMetaTags($page);
        }

        $this->render('main', array(
            'page' => $page
        ));
    }



    private function _setMetaTags(Page $page)
    {
        $meta_tags = $page->metaTags();

        $this->meta_title       = $meta_tags['title'];
        $this->meta_keywords    = $meta_tags['keywords'];
        $this->meta_description = $meta_tags['description'];
    }


    public function actionSearch($query)
    {
        $query = trim(strip_tags($query));
        if (mb_strlen($query, 'utf-8') >= 3)
        {
            $criteria = new CDbCriteria();
            $criteria->addSearchCondition('title', $query, true, 'OR');
            $criteria->addSearchCondition('short_text', $query, true, 'OR');
            $criteria->addSearchCondition('text', $query, true, 'OR');

            $pages = Page::model()->findAll($criteria);
        }

        $this->render('search', array(
            'pages' => isset($pages) ? $pages : null
        ));
    }
}
