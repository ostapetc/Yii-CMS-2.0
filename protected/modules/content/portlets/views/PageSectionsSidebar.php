<style type="text/css">

</style>

<h4>Разделы</h4>
<br/>

<ul class='nav nav-pills nav-stacked'>
    <? foreach ($sections as $id => $name): ?>
        <?
        $class       = 'active';
        $badge       = '';
        $badge_class = 'badge badge-inverse';

        preg_match('|^(\.+)|', $name, $count);
        if (isset($count[1]))
        {
            $class = '';
            $name  = mb_substr($name, mb_strlen($count[1], 'utf-8'));

            $badge_class = 'badge';
        }

        if (isset($pages_count[$id]))
        {
            $badge = '<span class="' . $badge_class . '" style="float: right" title="кол-во страниц в разделе"> ' . $pages_count[$id] . '</span>';
        }
        ?>
        <li class="<?= $class ?>">
            <?= CHtml::link($name . $badge, $this->createUrl('/page/section/' . $id)); ?>
        </li>
    <? endforeach ?>
</ul>
