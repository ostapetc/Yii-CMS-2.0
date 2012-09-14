<? foreach ($sidebars as $sidebar): ?>
    <?
    list($type, $path) = $sidebar;

    try
    {
        if ($type == 'partial')
        {
            $content = Yii::app()->controller->renderPartial($path, null, true);
        }
        elseif ($type == 'widget')
        {
            $content = Yii::app()->controller->widget($path, array(), true);
        }

        if ($content)
        {
            echo "<div class='well'>{$content}</div>";
        }
    }
    catch (CException $e)
    {
        echo $e->getMessage();
    }
    ?>
<? endforeach ?>