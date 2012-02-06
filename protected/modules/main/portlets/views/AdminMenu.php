<?php foreach ($modules as $module): ?>
    <?php
    if (!isset($module['admin_menu']) || !$module['admin_menu'])
    {
    	continue;
    }
    ?>

    <h3><?php echo $module['name']; ?></h3>
    <ul class="toggle">
        <?php foreach ($module['admin_menu'] as $title => $url): ?>
            <?php
            $icon_url  = '';
            $url_parts = explode('/', $url);

            if (count($url_parts) > 2)
            {
                $action = lcfirst($url_parts[3]);

                if (mb_substr($url_parts[2], -5) == 'Admin')
                {
                    $url_parts[2] = mb_substr($url_parts[2], 0, mb_strlen($url_parts[2]) - 5);
                }

                $url_parts[2] = lcfirst($url_parts[2]);

                $icon = $url_parts[2] . '_' . $action . '.png';

                $assets_url = Yii::app()->getModule($url_parts[1])->assetsUrl();
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $assets_url . '/actions_icons/' . $icon))
                {
                    $icon_url = $assets_url . '/actions_icons/' . $icon;
                }

                if (!$icon_url)
                {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . 'images/admin/actions_icons/' . $icon))
                    {
                        $icon_url = '/images/admin/actions_icons/' . $icon;
                    }
                }

                if (!$icon_url)
                {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . 'images/admin/actions_icons/' . $action . '.png'))
                    {
                        $icon_url = '/images/admin/actions_icons/' . $action . '.png';
                    }
                }
            }

            if (!$icon_url)
            {
                $icon_url = '/images/admin/actions_icons/tags.png';
            }
            ?>
            <li class="action_icon" icon_url="<?php echo $icon_url; ?>">
                <a href="<?php echo $url; ?>" style="background: url(<?php echo $icon_url; ?>) no-repeat center left;"><?php echo $title; ?></a>
            </li>
        <?php endforeach ?>
    </ul>
<?php endforeach ?>

