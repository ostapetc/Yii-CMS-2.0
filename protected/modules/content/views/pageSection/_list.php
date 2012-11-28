<? if ($sections): ?>
    <ul class="tags">
        <li><span class="glyphicon-briefcase"></span></li>

        <? foreach ($sections as $i => $section): ?>
            <? if ($i > 0): ?>, <? endif ?>
            <li>
<!--                <a rel="tag" href="--><?//= $this->createUrl("/pages/tag/{$tag->name}"); ?><!--">--><?//= $tag->name ?><!--</a>-->
                <?= CHtml::link($section->name, $this->createUrl('/page/section/' . $section->id), ['class' => 'section', 'title' => $section->name]); ?>
            </li>
        <? endforeach ?>
    </ul>
<!--            -->
<!--    <div class="sections">-->
<!--        <span class="glyphicon-briefcase"></span>-->
<!--        --><?// foreach ($sections as $i => $section): ?>
<!--            --><?// if ($i > 0): ?><!--,  --><?// endif; ?>
<!--            --><?//= CHtml::link($section->name, $this->createUrl('/page/section/' . $section->id), ['class' => 'section', 'title' => $section->name]); ?>
<!--        --><?// endforeach ?>
<!--    </div>-->
<? endif ?>

