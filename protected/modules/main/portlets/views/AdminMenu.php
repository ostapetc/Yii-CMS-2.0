<style type="text/css">
    body{
        overflow-y: scroll;
    }
    .acc-group{
        margin: 0;
        border: none;
    }
    .accordion-head{
        text-shadow: 1px 1px 0 #EFEFEF;
        border-top: 1px solid #F0F0F0;
    }
    .accordion-head a{
        padding: 8px 24px;
        color: #333;
        display: block;
        background: #EEEEEE;
    }
    .accordion-head a:hover{
        background: #CFCFCF;
        text-decoration: none;
    }
    .accordion-head a i{
        margin: 0;
    }

    .accordion-body {
        background: #FAFAFA;
        border-top: 1px solid #CCC;
    }
    .accordion-body ul li{
        margin: 0 2% 0 14%;
    }
    .accordion-body li a{
        display: block;
        padding: 4px;
        color: #333;
    }
    .accordion-body li a:hover{
        background: #E0E0E0;
        text-decoration: none;
    }
</style>
<div id="admin_menu">
<? foreach ($modules as $module): ?>
    <?
    if (!isset($module['admin_menu']) || !$module['admin_menu'])
    {
    	continue;
    }
//    dump($modules);
//    Yii::app()->controller->widget('Boot');
    ?>

    <div class="acc-group accordion-group">
        <div class="accordion-head">
            <a href="#menu_module_<?= $module['dir'] ?>" data-toggle="collapse" data-parent="#admin_menu">
                <i class="icon-<?= $module['icon'] ?>"></i>
                <?= $module['name'] ?>
            </a>
        </div>
        <div id="menu_module_<?= $module['dir'] ?>" class="collapse accordion-body">
            <ul>
            <? foreach ($module['admin_menu'] as $title => $url): ?>
                <li><?= CHtml::link($title, $url) ?></li>
            <? endforeach ?>
            </ul>
        </div>
    </div>
<? endforeach ?>
</div>

<?php return true; ?>

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
<?// endforeach ?>
</div>