<? foreach ($sidebars as $type => $path): ?>
    <div class="well">
        <? try
        {
            if ($type == 'partial')
            {
                Yii::app()->controller->renderPartial($path);
            }
            elseif ($type == 'widget')
            {
                Yii::app()->controller->widget($path);
            }
        }
        catch (CException $e)
        {
            echo $e->getMessage();
        }
        ?>
    </div>
<? endforeach ?>