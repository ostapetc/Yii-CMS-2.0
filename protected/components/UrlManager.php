<?php

class UrlManager extends CUrlManager
{
    public function createUrl($route, $params = array())
    {
        $url = parent::createUrl($route, $params);

        return $url;
    }

    public function collectRules()
    {
        $multi_language_site = true;

        $languages = Language::getArray();
        $languages = array_keys($languages);
        $languages = implode('|', $languages);

        $language_pattern = "<language:({$languages})>";

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

            if ($pattern[0] != '/')
            {
                $pattern = '/' . $pattern;
            }

            if ($multi_language_site && $language_pattern)
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

