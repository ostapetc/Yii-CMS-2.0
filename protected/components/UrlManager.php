<?php

class UrlManager extends CUrlManager
{
    public function collectRules()
    {
        $multilanguage_site = Yii::app()->params['multilanguage_site'];
        if ($multilanguage_site)
        {
            $languages = Language::getCachedArray();
            $languages = implode('|', array_keys($languages));

            $language_pattern = "<language:({$languages})>";
        }

        $routes = array(
            '/<controller:\w+>/<id:\d+>'              => '<controller>/view',
            '/<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            '/<controller:\w+>/<action:\w+>'          => '<controller>/<action>',
        );

        $modules = AppManager::getModulesData(true);
        foreach ($modules as $class => $data)
        {
            if (method_exists($class, 'routes'))
            {
                $routes = array_merge($routes, call_user_func(array($class, 'routes')));
            }
        }

        foreach ($routes as $pattern => $route)
        {
            unset($routes[$pattern]);
            $pattern = '/' . trim($pattern, '/');

            if ($multilanguage_site)
            {
                $pattern = '/' . $language_pattern . $pattern;
            }

            $routes[$pattern] = $route;
        }

        $routes                                  = array_reverse($routes);
        $routes['<language:(en|ru)>/<route:.*>'] = '<route>';

        Yii::app()->urlManager->addRules($routes);
    }
}

