<ul>
    <? foreach ($services as $name => $title): ?>
        <li><?= CHtml::link($title, array('/video/videoAccountAdmin/create', 'service' => $name)) ?></li>
    <? endforeach ?>
</ul>
