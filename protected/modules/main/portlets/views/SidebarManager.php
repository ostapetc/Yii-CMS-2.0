<? foreach ($sidebars as $sidebar): ?>
    <?
    $type = $sidebar['type'];
    unset($sidebar['type']);

    if (is_string($sidebar))
    {
        $class = $sidebar;
        $config = [];
    }
    else
    {
        $class = $sidebar['class'];
        unset($sidebar['class']);
        $config = $sidebar;
    }

    try
    {
        if ($type == 'partial')
        {
            $content = Yii::app()->controller->renderPartial($class, $confi, true);
        }
        elseif ($type == 'widget')
        {
            $content = Yii::app()->controller->widget($class, $config, true);
        }

        if ($content)
        {
            echo "<div class='well'>{$content}</div>";
        }
    }
    catch (CException $e)
    {
        if (YII_DEBUG)
        {
            Yii::app()->handleException($e);
        }
        else
        {
            echo $e->getMessage();
        }
    }
    ?>
<? endforeach ?>