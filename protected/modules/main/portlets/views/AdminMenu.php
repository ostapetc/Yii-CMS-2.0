<? foreach ($modules as $module): ?>
    <?
    if (!isset($module['admin_menu']) || !$module['admin_menu'])
    {
    	continue;
    }
    ?>

    <h3><? echo t($module['name']); ?></h3>
    <ul class="toggle">
        <? foreach ($module['admin_menu'] as $title => $url): ?>
            <?
            $icon_url  = '';
            $url_parts = explode('/', $url);

            if (count($url_parts) > 2)
            {
                $action = ucfirst($url_parts[3]);
                $model  = ucfirst($url_parts[2]);

                if (mb_substr($model, -5) == 'Admin')
                {
                    $model = mb_substr($model, 0, mb_strlen($model) - 5);
                }
                $icon = $model . '_' . $action . '.png';

                $assets_url = Yii::app()->getModule($url_parts[1])->assetsUrl();
                //echo $_SERVER['DOCUMENT_ROOT'] . $assets_url . '/actions_icons/' . $icon . "<br/>";
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $assets_url . '/img/actions_icons/' . $icon))
                {
                    $icon_url = $assets_url . '/img/actions_icons/' . $icon;
                }

                if (!$icon_url)
                {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . 'img/admin/actions_icons/' . $icon))
                    {
                        $icon_url = '/img/admin/actions_icons/' . $icon;
                    }
                }

                if (!$icon_url)
                {   //echo $_SERVER['DOCUMENT_ROOT'] . 'img/admin/actions_icons/' . $action . '.png' . "<br/>";
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . 'img/admin/actions_icons/' . $action . '.png'))
                    {
                        $icon_url = '/img/admin/actions_icons/' . $action . '.png';
                    }
                }
            }

            if (!$icon_url)
            {
                $icon_url = '/img/admin/actions_icons/action.png';
            }
            ?>
            <li class="action_icon" icon_url="<? echo $icon_url; ?>">
                <a href="<? echo $url; ?>" style="background: url(<? echo $icon_url; ?>) no-repeat center left;"><? echo t($title); ?></a>
            </li>
        <? endforeach ?>
    </ul>
<? endforeach ?>

