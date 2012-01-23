<link style="text/css" rel="stylesheet" href="/css/admin/modules_panel.css" />

<link href="/js/plugins/context_menu/vscontext.css" type="text/css" rel="stylesheet"/>

<script type="text/javascript" src="/js/plugins/context_menu/vscontext.jquery.js"></script>

<script type="text/javascript" src="/js/admin/modules_panel.js"></script>

<?php
$modules = AppManager::getModulesData(true, true);
?>

<div style="text-align:center;" id="panel">
    <?php foreach ($modules as $class => $module): ?>

        <?php
        if (!isset($module['admin_menu']) || !$module['admin_menu'])
        {
        	continue;
        }

        $assets_dir = Yii::app()->getModule($module['dir'])->assetsUrl();
        ?>

        <div class="module_div">
            <a href="<?php echo array_shift(array_values($module['admin_menu'])); ?>" title="<?php echo $module["name"]; ?>" desc="<?php echo array_shift(array_keys($module['admin_menu'])); ?>" >
                <img src="<?php echo $assets_dir . "/img/icon.png"; ?>" border="0" />
            </a>
            
            <div class="vs-context-menu" id="<?php echo $class . "sub_menu"; ?>">
                <ul>
                    <?php foreach ($module['admin_menu'] as $title => $url): ?>
                        <li>
                            <a href="<?php echo $url; ?>" ><?php echo $title; ?></a>
                        </li>                    
                    <?php endforeach ?>   
                </ul>
            </div>
            
        </div>
    <?php endforeach ?>
    <br clear="all" />
</div>

<p class="slide"><a href="#" class="btn-slide">Все модули</a></p>

