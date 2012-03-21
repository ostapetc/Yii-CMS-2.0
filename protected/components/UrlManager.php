<?php

class UrlManager extends CUrlManager
{
    public function createUrl($route, $params = array())
    {
        $url = parent::createUrl($route, $params);
        return $url;
    }


    public static  function collectRules()
    {
        if (YII_DEBUG)
        {
            $rules = self::_getRules();
        }
        else
        {
            $rules = Yii::app()->cache->get('url_rules');
            if (!$rules)
            {
                $rules = self::_getRules();
                Yii::app()->cache->set('url_rules', $rules);
            }
        }

        Yii::app()->urlManager->addRules($rules);
    }


    private static function _getRules()
    {
        $multi_language_site = true;

        $languages = Language::getCachedArray();
        $languages = array_keys($languages);
        $languages = implode('|', $languages);

        $language_pattern = "<language:({$languages})>";

        $rules = array(
            '/<controller:\w+>/<id:\d+>'              => '<controller>/view',
            '/<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            '/<controller:\w+>/<action:\w+>'          => '<controller>/<action>',
        );

        $modules = AppManager::getModulesData(true);
        foreach ($modules as $class => $data)
        {
            if (method_exists($class, 'routes'))
            {
                $rules = array_merge($rules, call_user_func(array($class, 'routes')));
            }
        }

        foreach ($rules as $pattern => $route)
        {
            unset($rules[$pattern]);

            if ($pattern[0] != '/')
            {
                $pattern = '/' . $pattern;
            }

            if ($multi_language_site && $language_pattern)
            {
                $pattern = '/' . $language_pattern . $pattern;
            }

            $rules[$pattern] = $route;
        }

        $rules = array_reverse($rules);
        $rules['<language:(en|ru)>/<route:.*>'] = '<route>';

        return $rules;
    }
}

