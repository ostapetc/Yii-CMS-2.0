<?

class UrlManager extends CUrlManager
{
    public function collectRules()
    {
        $multilanguage_support = Yii::app()->params['multilanguage_support'];
        if ($multilanguage_support)
        {
            $languages = Language::getList();
            $languages = implode('|', array_keys($languages));

            $language_pattern = "<language:({$languages})>";
        }

        $routes = array(
            '/<controller:\w+>/<id:\d+>'              => '<controller>/view',
            '/<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            '/<controller:\w+>/<action:\w+>'          => '<controller>/<action>',
        );

        if (Yii::app()->params['collect_routes_from_modules'])
        {
            foreach (Yii::app()->getModules() as $id => $config)
            {
                $module = Yii::app()->getModule($id);
                if (method_exists($module, 'routes'))
                {
                    $routes = array_merge($routes, $module->routes());
                }
            }
        }

        $multilanguage_support = Yii::app()->params['multilanguage_support'];

        if ($multilanguage_support)
        {
            $languages = Language::getList();
            $languages = implode('|', array_keys($languages));

            $language_pattern = "<language:({$languages})>";
        }

        foreach ($routes as $pattern => $route)
        {
            unset($routes[$pattern]);
            $pattern = '/' . trim($pattern, '/');

            if ($multilanguage_support)
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

